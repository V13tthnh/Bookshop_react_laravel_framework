@extends('layout')

@section('js')

<script>
    $(document).ready(function () {
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
            "ajax": { url: "{{route('admin.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'avatar', render: function(data, type, row){ 
                    if(data != null){
                        return '<img src="'+data+'" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                    }
                    return `<img src="{{asset('dist/img/user.jpg')}}" alt="" sizes="40" srcset="" style="height:100px;width:100px">`;
                    } 
                },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning editBtn  " value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                                +'<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                    }
                },
            ],
        });

        //clear create form
        function createFormClear() {
            $("#storeName").val($("#storeName option:first").val());
            $("#storeEmail").val($("#storeEmail option:first").val());
            $("#storePassword").val("");
            $("#storeAvatar").val("");
            $("#storeRole").val("");
        }
        //clear edit form
        function editFormClear() {
            $("#updatePassword").val("");
            $("#updateAvatar").val("");
        }

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
        $('#addBtn').click(function () {
            var name = $('#storeName').val();
            var email = $('#storeEmail').val();
            var password = $('#storePassword').val();
            //var avatar = $('#storeAvatar').val().replace("C:\\fakepath\\", "");
            var role = $('#storeRole').find(':selected').val();
            formDataCreate.append("_token", "{{csrf_token()}}");
            formDataCreate.append("name", name);
            formDataCreate.append("email", email);
            formDataCreate.append("password", password);
            formDataCreate.append("role", role);
            $.ajax({
                url: "{{route('admin.store')}}",
                method: "post",
                data: formDataCreate,
                contentType: false,
                processData: false,

            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide'); //ẩn model thêm mới
                    createFormClear(); //clear dữ liệu input sau khi thêm thành công
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
                
            });
        });

        //edit
        $('#myTable').on('click', '.editBtn', function () {
            var id = $(this).val();
            //console.log(id);
            $.ajax({
                url: "admin/edit/" + id,
                method: "get",
            }).done(function (res) {
                $('#modal-edit').modal('show');
                $('#updateId').val(res.data.id);
                $('#updateName').val(res.data.name);
                $('#updateEmail').val(res.data.email);
                $('#updateRole').val(res.data.role);
            });
        });

        //update
        $('#updateBtn').click(function () {
            var id = $('#updateId').val();
            var name = $('#updateName').val();
            var email = $('#updateEmail').val();
            var password = $('#updatePassword').val();
            //var avatar = $('#updateAvatar').val().replace("C:\\fakepath\\", "");
            var role = $('#updateRole').find(':selected').val();
            formDataEdit.append("_token", "{{csrf_token()}}");
            formDataEdit.append("name", name);
            formDataEdit.append("email", email);
            formDataEdit.append("password", password);
            formDataEdit.append("role", role);
            $.ajax({
                url: "admin/update/" + id,
                method: "post",
                data: formDataEdit,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide');
                    editFormClear();
                    table.ajax.reload();
                } if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            });
        });
        
        //delete
        $('#myTable').on('click', '.deleteBtn', function () {
            var id = $(this).val();
            $.ajax({
                url: "admin/destroy/" + id,
                method: "post",
                data: {
                    "_token": "{{csrf_token()}}"
                }
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    table.ajax.reload();
                } 
            });
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
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm admin</h4>
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
                    <label for="inputProjectLeader">Email</label>
                    <input type="email" id="storeEmail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Mật khẩu</label required>
                    <input type="password" id="storePassword" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="storeAvatar">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                    </div>
                </div>
             
                <div class="form-group">
                    <label for="inputStatus">Quyền</label>
                    <select name="role" id="storeRole" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                        <option value="1">Super admin</option>
                        <option value="2">Admin</option>
                        <option value="3">Sales Agent</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="addBtn">Lưu</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa admin</h4>
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
                    <label for="inputProjectLeader">Email</label>
                    <input type="email" id="updateEmail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Mật khẩu</label required>
                    <input type="password" id="updatePassword" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Ảnh</label>
                    <input accept="image/*" type='file' id="updateAvatar" class="form-control" />
                    <label>Ảnh của bạn: </label>
                    <img id="blah" src="#" alt="your image" style="with: 70px; height: 70px" />
                </div>
                <div class="form-group">
                    <label for="inputStatus">Quyền</label>
                    <select id="updateRole" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                        <option value="1">Super admin</option>
                        <option value="2">Admin</option>
                        <option value="3">Sales Agent</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" id="updateBtn" class="btn btn-primary">Lưu</button>
            </div>
            </form>
        </div>
    </div>
</div>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('admin.trash')}}" class="btn btn-warning">
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
                                    <td>ID</td>
                                    <td>Avatar</td>
                                    <td>Tên</td>
                                    <td>Email</td>
                                    <td>Thao tác</td>
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