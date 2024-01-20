@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        var orderId = 0;
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: `<i class="fas fa-print"></i> In` },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('order.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'customer_name', name: 'customer.name' },
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone' },
                { data: 'format', name: 'format ' },
                { data: 'vnp_status', render: function (data, type, row){
                    return data == 1 ? 'Đã thanh toán' : 'Chưa thanh toán';
                } },
                { data: 'total', render: $.fn.dataTable.render.number('.', 2, '') },
                {
                    data: 'status', render: function (data, type, row) {
                        if (data === 1) {
                            return '<div class="bg-warning color-palette text-center">Đã đặt</div>'
                        }
                        if (data === 2) {
                            return '<div class="bg-primary color-palette text-center">Đã xác nhận</div>'
                        }
                        if (data === 3) {
                            return '<div class="bg-info color-palette text-center">Đang giao</div>'
                        }
                        if (data === 4) {
                            return '<div class="bg-success color-palette text-center">Đã giao</div>'
                        }
                        if (data === 5) {
                            return '<div class="bg-danger color-palette text-center">Đã hủy</div>'
                        }
                    }
                },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<a class="btn btn-info ml-2" href="order/data-table-detail/' + data + '"><i class="nav-icon fa fa-eye"></i> Xem chi tiết</a>'
                            + '<button class="btn btn-warning ml-2 updateStatus" value="' + data + '" data-toggle="modal" data-target="#modal-update"><i class="nav-icon fa fa-edit"></i> Sửa trạng thái</button>';
                    }
                },
            ],
        });

        //Xử lý cập nhật trạng thái hóa đơn
        $('#myTable').on('click', '.updateStatus', function () {
            var id = $(this).val();
            $.ajax({
                url: "order/edit-status/" + id,
                method: "get",
            }).done(function (res) {
                if (res.success) {
                    $('#orderStatus').val(res.data.status);
                    $('#updateBtn').val(id);
                }
            });
        });

        $('#updateBtn').click(function () {
            var id = $(this).val();
            if (Number($('#orderStatus').val()) === 5) {
                Swal.fire({ //Thông báo xác nhận trước khi xóa
                    title: 'Bạn muốn hủy đơn hàng này?',
                    text: 'Cảnh báo, hãy kiểm tra thật kỹ thông tin đơn hàng để tránh nhầm lẫn!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy bỏ'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "order/update-status/" + id,
                            method: "post",
                            data: {
                                "_token": "{{csrf_token()}}",
                                "status": $('#orderStatus').val()
                            }
                        }).done(function (res) {
                            if (res.success) {
                                Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                                $('#modal-update').modal('hide');
                                table.ajax.reload();
                            }
                            else {
                                Swal.fire({ title: res.message, icon: 'warning', confirmButtonText: 'OK' });
                            }
                        });
                    }
                });
                return;
            }
            $.ajax({
                url: "order/update-status/" + id,
                method: "post",
                data: {
                    "_token": "{{csrf_token()}}",
                    "status": $('#orderStatus').val()
                }
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-update').modal('hide');
                    table.ajax.reload();
                }
            });
        });
    });
</script>
@endsection

@section('content')

<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập nhật trạng thái</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputFile">Trạng thái</label>
                    <div class="input-group">
                        <select id="orderStatus" class="form-control">
                            <option value="1">Đã đặt</option>
                            <option value="2">Đã xác nhận</option>
                            <option value="3">Đang giao</option>
                            <option value="4">Đã giao</option>
                            <option value="5">Đã hủy</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button id="updateBtn" value="" class="btn btn-primary">Cập nhật</button>
            </div>
            </form>
        </div>
    </div>
</div>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách hóa đơn</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên khách hàng</th>
                                    <th>Địa chỉ</th>
                                    <th>SĐT</th>
                                    <th>Hình thức</th>
                                    <th>Trạng Thái thanh toán</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Ngày mua</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection