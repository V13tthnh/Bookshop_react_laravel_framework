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
            "ajax": { url: "{{route('supplier.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name'},
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone'},
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning editBtn  " value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                                +'<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                    }
                },
            ],
        });
        //clear create form
        function clearCreateForm(){
            $('#storeName').val('');
            $('#storeAddress').val('');
            $('#storePhone').val('');
            $('#storeDescription').val('');
        }
        //store
        $('#addBtn').click(function(){
            var name = $('#storeName').val();
            var address = $('#storeAddress').val();
            var phone = $('#storePhone').val();
            var description = $('#storeDescription').val();
            $.ajax({
                url: "{{route('supplier.store')}}",
                method: "post",
                data:{
                    "_token" : "{{csrf_token()}}",
                    "name" : name,
                    "address" : address,
                    "phone" : phone,
                    "description":description
                }
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide'); //ẩn model thêm mới
                    clearCreateForm(); //clear form
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            });
        });
        //edit
        $('#myTable').on('click', '.editBtn', function(){
            var id = $(this).val();
            $.ajax({
                url: "supplier/edit/" + id,
                method: "get"
            }).done(function(res){
                $('#updateId').val(res.data.id);
                $('#updateName').val(res.data.name);
                $('#updateAddress').val(res.data.address);
                $('#updatePhone').val(res.data.phone);
                $('#updateDescription').summernote('code',res.data.description);
            });
        });
        //update
        $('#updateBtn').click(function(){
            var id = $('#updateId').val();
            var name = $('#updateName').val();
            var address = $('#updateAddress').val();
            var phone = $('#updatePhone').val();
            var description = $('#updateDescription').val();
            $.ajax({
                url: "supplier/update/" + id,
                method: "post",
                data:{
                    "_token" : "{{csrf_token()}}",
                    "name" : name,
                    "address" : address,
                    "phone" : phone,
                    "description":description
                }
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide'); //ẩn model edit
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            });
        });
        //delete
        $('#myTable').on('click', '.deleteBtn', function(){
            var id = $(this).val();
            $.ajax({
                url: "supplier/destroy/" + id,
                method: "post",
                data:{
                    "_token" : "{{csrf_token()}}",
                }
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            });
        });
        $(function () {
             // description create
            $('#storeDescription').summernote()
            // description edit
            $('#updateDescription').summernote()
        });
    });

</script>
@endsection

@section('content')
<!-- Them -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Nhà cung cấp</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" id="storeName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Địa chỉ</label>
                        <input type="text" id="storeAddress" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Điện thoại</label>
                        <input type="text" id="storePhone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mô tả</label required>
                        <textarea id="storeDescription" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="addBtn">Lưu</button>
                </div>
        </div>
    </div>
</div>
<!-- Sua -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa nhà cung cấp</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
                <input type="text"  id="updateId" hidden>
                <div class="modal-body">
                <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" id="updateName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Địa chỉ</label>
                        <input type="text" id="updateAddress" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Điện thoại</label>
                        <input type="text" id="updatePhone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mô tả</label required>
                        <textarea id="updateDescription" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="updateBtn">Lưu thay đổi</button>
                </div>
            
        </div>
    </div>
</div>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách nhà cung cấp</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('supplier.trash')}}" class="btn btn-warning">
                        <i class="nav-icon fa fa-list"></i> Danh sách đã xóa
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