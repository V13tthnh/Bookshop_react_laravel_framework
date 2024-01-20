@extends('layout')

@section('js')
<script>
    //Edit ajax
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, "processing": true,
            "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: `<i class="fas fa-print"></i> In` },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "ajax": { url: "{{route('comment.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'customer_name', name: 'customer.name' },
                { data: 'book_name', name: 'book.name' },
                { data: 'combo_name', name: 'combo.name' },
                { data: 'comment_text', name: 'comment_text' },
                { data: 'created_at', name: 'created_at' },
                { data: 'replies_count', name: 'replies_count' },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-info mr-2 showBtn" value="' + data + '" data-toggle="modal" data-target="#modal-replies"><i class="nav-icon fa fa-eye"></i> Phản hồi</button>'
                            + '<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i> Xóa</button></div>'
                    }
                },
            ],
        });

        $('#myTable').on('click', '.showBtn', function () {
            var id = $(this).val();
            $('#tableDetail').DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
                "paging": true, "ordering": true, "searching": true,
                "pageLength": 10, "dom": 'Bfrtip', stateSave: true, "bDestroy": true,
                "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
                { extend: "csv", text: "Xuất csv" },
                { extend: "excel", text: "Xuất Excel" },
                { extend: "pdf", text: "Xuất PDF" },
                { extend: "print", text: `<i class="fas fa-print"></i> In` },
                { extend: "colvis", text: "Hiển thị cột" }],
                "language": { search: "Tìm kiếm:", emptyTable: "Không có dữ liệu trong bảng" },
                "lengthMenu": [10, 25, 50, 75, 100],
                "ajax": { url: "comment/data-table-detail/" + id, method: "get", dataType: "json", },
                "columns": [
                    {
                        "title": "#", // Tiêu đề của cột
                        "data": null,
                        "render": function (data, type, row, meta) {
                            // 'meta.row' là chỉ số hàng, 'meta.settings._iDisplayStart' là số lượng hàng hiển thị trên mỗi trang
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'customer_name', name: 'customer.name' },
                    { data: 'reply_text', name: 'reply_text' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'id', render: function (data, type, row) {
                            return '<div class="btn-group btn-group-toggle "><button class="btn btn-danger delete_reply" value="' + data + '"><i class="nav-icon fa fa-trash"></i> Xóa</button></div>'
                        }
                    },
                ],
            });
        });

        $('#myTable').on('click', '.deleteBtn', function () {
            var id = $(this).val();
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: 'Dữ liệu của comment sẽ bị xóa vĩnh viễn khỏi hệ thống!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: "comment/destroy/" + id,
                        method: "post",
                        data: { "_token": "{{csrf_token()}}", }
                    }).done(function (res) {
                        if (res.success) {
                            Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                            table.ajax.reload();
                        }
                    });
                }
            });
        });

        $('#tableDetail').on('click', '.delete_reply', function () {
            var id = $(this).val();
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: 'Dữ liệu của comment sẽ bị xóa vĩnh viễn khỏi hệ thống!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: "comment/destroy-reply/" + id,
                        method: "post",
                        data: { "_token": "{{csrf_token()}}", }
                    }).done(function (res) {
                        if (res.success) {
                            Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                            $(this).ajax.reload();
                        }
                    });
                }
            });

        });
    })
</script>
@endsection

@section('content')
<!-- Them -->
<div class="modal fade" id="modal-replies" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi tiết phiếu nhập</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Khách hàng</th>
                            <th>Bình luận</th>
                            <th>Ngày đăng</th>
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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách bình luận</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách bình luận</li>
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
                        <h3 class="card-title">Danh sách tác giả</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Khách hàng</th>
                                    <th>Sách</th>
                                    <th>Combo</th>
                                    <th>Bình luận</th>
                                    <th>Ngày đăng</th>
                                    <th>Số lượng phản hồi</th>
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