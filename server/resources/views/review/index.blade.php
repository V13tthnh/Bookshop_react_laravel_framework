@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: "In" },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('review.data.table')}}", method: "get", dataType: "json", },
            "columns": [{ data: 'id', name: 'id' },
            { data: 'customer_name', name: 'customer.name' },
            { data: 'book_name', name: 'book.name' },
            { data: 'combo_name', name: 'combo.name' },
            { data: 'comment', name: 'comment' },
            { data: 'rating', name: 'rating' },
            {
                data: 'status', render: function (data, type, row) {
                    return data == 1 ? '<div class="bg-success color-palette text-center">Đã duyệt</div>' : 
                            data == 0 ? '<div class="bg-warning color-palette text-center">Chưa duyệt</div>' :
                            '<div class="bg-info color-palette text-center">Đã ẩn</div>';
                }
            },
            {
                data: 'id', render: function (data, type, row) {
                    return '<button class="btn btn-info editBtn mr-2" value="' + data + '"><i class="nav-icon fa fa-edit"></i> Duyệt</button>'
                        + '<button class="btn btn-warning showBtn mr-2" value="' + data + '" ><i class="nav-icon fa fa-eye"></i> Ẩn</button>'
                        + '<button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i> Xóa</button>';
                }
            },]
        });

        $('#myTable').on('click', '.editBtn', function () {
            let id = $(this).val();
            $.ajax({
                method: 'get',
                url: 'review/update/' + id,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    table.ajax.reload();
                }
            })
        });

        $('#myTable').on('click', '.showBtn', function () {
            let id = $(this).val();
            $.ajax({
                method: 'get',
                url: 'review/update-status/' + id,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    table.ajax.reload();
                }
            })
        });

        $('#myTable').on('click', '.deleteBtn', function () {
            let id = $(this).val();
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: 'Dữ liệu đánh giá của khách hàng sẽ bị xóa khỏi hệ thống!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        method: 'get',
                        url: 'review/destroy/' + id,
                    }).done(function (res) {
                        if (res.success) {
                            Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                            table.ajax.reload();
                        }
                    })
                }
            });
        })
    });
</script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách đánh giá</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách đánh giá</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách đánh giá</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên khách hàng</th>
                                    <th>Tên sách</th>
                                    <th>Tên combo</th>
                                    <th>Nội dung</th>
                                    <th>Số sao</th>
                                    <th>Trạng thái</th>
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