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
            { extend: "print", text: `<i class="fas fa-print"></i> In` },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('goods-received-note.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'supplier_name', name: 'supplier.name' },
                { data: 'admin_name', name: 'admin.name' },
                { data: 'total', render: $.fn.dataTable.render.number('.', 2, '') },
                { data: 'formality', name: 'formality' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<a class="btn btn-warning showDetail" href="goods-received-note/show/' + data + '"><i class="nav-icon fa fa-eye"></i> Chi tiết</a>';
                    }
                },
            ],
        });
    });
</script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách phiếu nhập</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a type="button" href="{{route('goods-received-note.create')}}" class="btn btn-success">
                        <i class="nav-icon fas fa-edit"></i> Nhập hàng
                    </a>
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
                        <h3 class="card-title">Danh sách phiếu nhập</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Tên admin</th>
                                    <th>Tổng tiền</th>
                                    <th>Hình thức</th>
                                    <th>Ngày lập</th>
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