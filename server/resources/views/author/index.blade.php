@extends('layout')

@section('js')
<script>
    //Edit ajax
    $(document).ready(function () {
        $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, "processing":true,
            "dom": 'Bfrtip', 
            "buttons": [{extend:"copy", text:"Sao chép"}, //custom các button
                        {extend:"csv", text:"Xuất csv"}, 
                        {extend:"excel",text:"Xuất Excel"}, 
                        {extend:"pdf",text:"Xuất PDF"}, 
                        {extend:"print",text:`<i class="fas fa-print"></i> In`}, 
                        {extend:"colvis",text:"Hiển thị cột"}],
            "language": { search: "Tìm kiếm:" },
            "ajax": { url: "{{route('author.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'image', render: function(data, type, row){ 
                    if(data != null){
                        return '<img src="'+data+'" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                    }
                    return `<img src="{{asset('dist/img/user.jpg')}}" alt="" sizes="40" srcset="" style="height:100px;width:100px">`;
                    } },
                { data: 'name', name: 'name'},
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning editBtn  " value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                                +'<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                    }
                },
            ],
        });
        var formDataCreate = new FormData();
        var formDataEdit = new FormData();
        //create image
        $('#storeAvatar').change(function (e) {
            var input = e.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    formDataCreate.set("avatar", input.files[0]);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        //create image
        $('#updateAvatar').change(function (e) {
            var input = e.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    formDataEdit.set("avatar", input.files[0]);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        //store
        $('#addBtn').click(function(){
            var description = $('#storeDescription').val();
            var name = $('#storeName').val();
            formDataCreate.append("_token", "{{csrf_token()}}");
            formDataCreate.append("name", name);
            formDataCreate.append("description", description);
            $.ajax({
                url: "{{route('author.store')}}",
                method: "post",
                data: formDataCreate,
                contentType: false,
                processData: false
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide'); //ẩn model thêm mới
                    $('#storeName').val(''); 
                    $('#storeDescription').val(''); 
                    $('#storeAvatar').val('');
                    $('#blah2').attr('src', '');
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
                url: "/category/edit/" + id,
                method: "get",
            }).done(function(res){
                $('#updateId').val(id);
                $('#updateName').val(res.data.name);
                $('#updateDescription').summernote('code', res.data.description);
            });
        });
        //update
        $('#updateBtn').click(function(){
            var id = $('#updateId').val();
            var name = $('#updateName').val();
            var description = $('#updateDescription').val();
            formDataEdit.append("_token", "{{csrf_token()}}");
            formDataEdit.append("name", name);
            formDataEdit.append("description", description);
            $.ajax({
                url: 'author/update/' + id,
                method: "post",
                data: formDataEdit,
                contentType: false,
                processData: false
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide'); //ẩn model thêm mới
                    $('#blah').attr('src', '');
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
                url: "author/destroy/" + id,
                method : "post",
                data:{
                    "_token" : "{{csrf_token()}}"
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

    });

    $(function () {
        // Summernote thêm
        $('#storeDescription').summernote()
        // Summernote sửa
        $('#updateDescription').summernote()
    });
});
//review image create
storeAvatar.onchange = evt => {
    const [file] = storeAvatar.files
    if (file) {
        blah2.src = URL.createObjectURL(file)
    }
}
// review image edit
updateAvatar.onchange = evt => {
    const [file] = updateAvatar.files
    if (file) {
        blah.src = URL.createObjectURL(file)
    }
}
</script>



@endsection

@section('content')
<!-- Them -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Tác giả</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div style="text-align:center">
                        <img id="blah2" src="#"  style="height:150px;width:150px" />
                    </div>
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" id="storeName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mô tả</label required>
                        <textarea  id="storeDescription" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Ảnh</label>
                        <input accept="image/*" type='file' id="storeAvatar" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="addBtn">Lưu</button>
                </div>
        </div>
    </div>
</div>
<!-- Sua -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa nhà Danh Mục</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
                <input type="text" id="updateId" hidden>
                <div class="modal-body">
                    <div style="text-align:center">
                        <img id="blah" src="#" alt="your image" style="height:150px;width:150px" />
                    </div>
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" id="updateName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mô tả</label required>
                        <textarea id="updateDescription" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                    <label for="inputProjectLeader">Ảnh</label>
                        <input accept="image/*" type='file' id="updateAvatar" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="updateBtn">Lưu thay đổi</button>
                </div>
        </div>
    </div>
</div>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách tác giả</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('author.trash')}}" class="btn btn-warning">
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
                        <h3 class="card-title">Danh sách tác giả</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Ảnh</th>
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
