@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true, 
            "pageLength": 10, "dom": 'Bfrtip', "lengthMenu": [10, 25, 50, 75, 100],
            "buttons": [{extend:"copy", text:"Sao chép"}, //custom các button
                        {extend:"csv", text:"Xuất csv"}, 
                        {extend:"excel",text:"Xuất Excel"}, 
                        {extend:"pdf",text:"Xuất PDF"}, 
                        {extend:"print",text:"In"}, 
                        {extend:"colvis",text:"Hiển thị cột"}],
            "language": { search: "Tìm kiếm:" }, //custom thanh tìm kiếm
            "ajax": { url: "{{route('supplier.data.table.trash')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name'},
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone'},
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-info restoreBtn" value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-trash-restore-alt"></i></button>';
                    }
                },
            ],
        });
        //restore
        $('#myTable').on('click', '.restoreBtn', function(){
            var id = $(this).val();
            $.ajax({
                url: "/supplier/untrash/" + id,
                method: "get",
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    table.ajax.reload(); 
                }
            });
        });
    });

</script>
@endsection

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách nhà cung cấp</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{route('supplier.index')}}" class="btn btn-warning">
                        <i class="nav-icon fa fa-list"></i> Danh sách
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
                        <h3 class="card-title">Danh sách admin</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Địa chỉ</th>
                                    <th>Điện thoại</th>
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