@extends('layout')

@section('js')
<script>
    $(document).ready(function(){
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, 
            "dom": 'Bfrtip', 
            "buttons": [{extend:"copy", text:"Sao chép"}, //custom các button
                        {extend:"csv", text:"Xuất csv"}, 
                        {extend:"excel",text:"Xuất Excel"}, 
                        {extend:"pdf",text:"Xuất PDF"}, 
                        {extend:"print",text:"In"}, 
                        {extend:"colvis",text:"Hiển thị cột"}],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('publisher.data.table')}}", method: "get", dataType: "json", },
            "columns" : [{ data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'id', render: function(data, type, row){
                            return '<button class="btn btn-warning editBtn" value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                                +'<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                        } },]
        });
        //store
        $('#addBtn').click(function(){
            var name = $('#storeName').val();
            var description = $('#storeDescription').val();
            $.ajax({
                url: "{{route('publisher.store')}}",
                method: "post",
                data: {
                    "_token":"{{csrf_token()}}",
                    "name":name,
                    "description":description
                }
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide'); //ẩn model thêm mới
                    $('#storeName').val(''); //clear dữ liệu input sau khi thêm thành công
                    $('#storeDescription').summernote('code', '');
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
                url: "publisher/edit/" + id,
                method: "get",
            }).done(function(res){
                $('#updateId').val(res.data.id);
                $('#updateName').val(res.data.name);
                $('#updateDescription').summernote('code', res.data.description);
            });
        });
        //update
        $('#updateBtn').click(function(){
            var id = $('#updateId').val();
            var name = $('#updateName').val();
            var description = $('#updateDescription').val();
            $.ajax({
                url: "publisher/update/" + id,
                method: "post",
                data:{
                    "_token": "{{csrf_token()}}",
                    "name": name,
                    "description": description
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
                url: "publisher/destroy/" + id,
                method: "post",
                data:{
                    "_token" : "{{csrf_token()}}",
                }
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    table.ajax.reload();
                }
            });
        });
        $(function () {
            // create description
            $('#storeDescription').summernote();
            // edit description
            $('#updateDescription').summernote();
        });
    });
</script>
@endsection

@section('content')
<!-- Them sach -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm nhà xuất bản</h4>
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
                        <label for="inputName">Mô tả</label>
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

<!-- Sua sach -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa nhà xuất bản</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <input type="text" id="updateId" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input id="updateName" type="text"  class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Mô tả</label>
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
                <h1>Danh sách nhà xuất bản</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('publisher.trash')}}" class="btn btn-warning">
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
                        <h3 class="card-title">Danh sách nhà xuất bản</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
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