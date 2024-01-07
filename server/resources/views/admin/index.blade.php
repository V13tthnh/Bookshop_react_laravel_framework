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
        //clear create form trong modal sau khi thêm hoàn tất
        function createFormClear() {
            $("#storeName").val($("#storeName option:first").val());
            $("#storeEmail").val($("#storeEmail option:first").val());
            $("#storeAddress").val("");
            $("#storePhone").val("");
            $("#storePassword").val("");
            $('#storeAvatar').val('');
            $('#blah2').attr('src', '');
            $("#storeRole").val("");
        }
        //clear edit form trong modal sau khi cập nhật hoàn tất
        function editFormClear() {
            $('#updateAvatar').val('');
            $('#blah').attr('src', '');
        }
        //Ẩn modal create thì reset các trường validate rỗng
        $('#modal-create').on('hidden.bs.modal', function(){
            $('#createFormValidate').removeClass('was-validated');
            $('.create_name_error').text('');
            $('.create_address_error').text('');
            $('.create_phone_error').text('');
            $('.create_email_error').text('');
            $('.create_password_error').text('');
            $('.create_avatar_error').text('');
            $('.create_role_error').text('');
        });
        //Ẩn modal edit thì reset các trường validate rỗng
        $('#modal-edit').on('hidden.bs.modal', function(){
            $('#updateFormValidate').removeClass('was-validated');
            $('.update_name_error').text('');
            $('.update_address_error').text('');
            $('.update_phone_error').text('');
            $('.update_email_error').text('');
            $('.update_password_error').text('');
            $('.update_avatar_error').text('');
            $('.update_role_error').text('')
        });
        //tạo 2 đối tượng formData để lưu  giá trị các trường trong modal thêm mới cập nhật
        var formDataCreate = new FormData();
        var formDataEdit = new FormData();
        //xử lý sự kiện change khi người dùng chọn file từ hộp thoại tìm kiếm file
        $('#storeAvatar').change(function (e) {
            var input = e.target; //gán file vừa chọn vào biến input
            //điều kiện kiểm tra input có tồn tại ko
            if (input.files && input.files[0]) {
                //nếu có tồn tại tạo đối tượng FileReader() để đọc file
                var reader = new FileReader();
                //sau đó 1 hàm callback được đặt cho sự kiện onload của FileReader()
                reader.onload = function (e) {
                    //sau khi file đã đọc thành công, hàm callback sẽ đc gọi và thiết lập
                    //giá trị cho formDataCreate
                    formDataCreate.set("avatar", input.files[0]);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        //tương tự ở trên
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
        //Xử lý sự kiện click khi nhấn nào button lưu của modal create
        $('#addBtn').click(function (e) {
            e.preventDefault(); //Chỉ focus vào sự kiện click, ngăn ko thực thi sự kiện khác
            //Thêm các giá trị các trường vào formData
            formDataCreate.append("_token", "{{csrf_token()}}");
            formDataCreate.append("name", $('#storeName').val());
            formDataCreate.append("address", $('#storeAddress').val());
            formDataCreate.append("phone", $('#storePhone').val());
            formDataCreate.append("email", $('#storeEmail').val());
            formDataCreate.append("password", $('#storePassword').val());
            formDataCreate.append("role",  $('#storeRole').find(':selected').val());
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
            }).fail(function(res){
                //Hàm fail() được gọi khi có bất kỳ lỗi nào xảy ra trong quá trình thực hiện yêu cầu Ajax.
                var errors = res.responseJSON.errors; //Lưu 1 mảng các đối tượng lỗi vào biến errors
                //console.log(errors);
                $('#createFormValidate').addClass('was-validated'); //Thêm lớp css was-validate của bootstrap để hiển thị lỗi trên input
                $.each(errors, function(key, value){  //Duyệt mảng errors và gán các giá trị lỗi phía dưới các trường input
                    $('.create_' + key + '_error').text(value[0]);
                    $('.create_' + key + '_error').text(value[1]);
                    $('.create_' + key + '_error').text(value[2]);
                    $('.create_' + key + '_error').text(value[3]);
                    $('.create_' + key + '_error').text(value[4]);
                    $('.create_' + key + '_error').text(value[5]);
                    $('.create_' + key + '_error').text(value[6]);
                });
            });
        });
        //hiển thị modal edit và trả về giá trị cho các trường khi nhấn button chỉnh sửa
        $('#myTable').on('click', '.editBtn', function () {
            var id = $(this).val();
            $.ajax({
                url: "admin/edit/" + id,
                method: "get",
            }).done(function (res) {
                $('#modal-edit').modal('show');
                $('#updateId').val(res.data.id);
                $('#updateName').val(res.data.name);
                $('#updateAddress').val(res.data.address);
                $('#updatePhone').val(res.data.phone);
                $('#updateEmail').val(res.data.email);
                $('#updateRole').val(res.data.role);
                $('#blah').attr('src', res.data.avatar);
            });
        });
        //Xử lý sự kiện click khi nhấn vào button Lưu thay đổi trên modal edit 
        $('#updateBtn').click(function (e) {
            e.preventDefault(); //Ngăn không cho các sự kiện khác phát sinh
            var id = $('#updateId').val();
            //Thêm giá trị các trường vào formDataEdit
            formDataEdit.append("_token", "{{csrf_token()}}");
            formDataEdit.append("name", $('#updateName').val());
            formDataEdit.append("address", $('#updateAddress').val());
            formDataEdit.append("phone",  $('#updatePhone').val());
            formDataEdit.append("email", $('#updateEmail').val());
            formDataEdit.append("role", $('#updateRole').find(':selected').val());
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
            }).fail(function(res){
                var errors = res.responseJSON.errors;
                $('#updateFormValidate').addClass('was-validated');
                $.each(errors, function(key, value){
                    $('.update_' + key + '_error').text(value[0]);
                    $('.update_' + key + '_error').text(value[1]);
                    $('.update_' + key + '_error').text(value[2]);
                    $('.update_' + key + '_error').text(value[3]);
                    $('.update_' + key + '_error').text(value[4]);
                    $('.update_' + key + '_error').text(value[5]);
                    $('.update_' + key + '_error').text(value[6]);
                });
            });
        });
        //xử lý sự kiện click khi nhấn button delete
        $('#myTable').on('click', '.deleteBtn', function () {
            var id = $(this).val();
            //Thông báo xác nhận trước khi xóa
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: 'Đừng lo, bạn vẫn có thể khôi phục lại dữ liệu đã xóa!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result)=>{
                //Nấu click button Đồng ý trên thông báo thì giá trị result sẽ là true va ngược lại
                if(result.value){
                    //Nếu giá trị là true thực hiện ajax xóa admin
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
                }
            });
        });
        //import
        $('#importBtn').click(function () {
            $('#importErrors').empty();
            var formData = new FormData();
            var file = $('#importFile')[0].files[0];
            formData.append('_token', "{{csrf_token()}}");
            formData.append('file_excel', file);
            $.ajax({
                url: '{{route('author.import')}}',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    $('#modal-import').modal('hide');
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#importErrors').empty();
                    table.ajax.reload();
                }
                if (!res.success) {
                    //Xuất danh sách thông báo lỗi
                    $('#importErrors').append('<li>' + res.message + '</li>');
                    res.errors.map((e) => {
                        return $('#importErrors').append('<li>' + e.errors + '</li>');
                    });
                }
            });
        });
         //import
         $('#importBtn').click(function () {
            $('#importErrors').empty();
            var formData = new FormData();
            var file = $('#importFile')[0].files[0];
            formData.append('_token', "{{csrf_token()}}");
            formData.append('file_excel', file);
            $.ajax({
                url: '{{route('admin.import')}}',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    $('#modal-import').modal('hide');
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#importErrors').empty();
                    table.ajax.reload();
                }
                if (!res.success) {
                    //Xuất danh sách thông báo lỗi
                    $('#importErrors').append('<li>' + res.message + '</li>');
                    res.errors.map((e) => {
                        return $('#importErrors').append('<li>' + e.errors + '</li>');
                    });
                }
            });
        });
        //Clear các dòng thông báo lỗi của các modal khi ẩn hoặc tắt
        $('#modal-import').on('hidden.bs.modal', function () {
            $('#importErrors').empty();
            $('#importFile').val('');
        });
    });
    //Xử lý sự kiện onchange hiển thị hình ảnh khi chọn ảnh từ trường input cho modal create
    storeAvatar.onchange = evt => {
        const [file] = storeAvatar.files
        if (file) {
            blah2.src = URL.createObjectURL(file)
        }
    }
    //Xử lý sự kiện onchange hiển thị hình ảnh khi chọn ảnh từ trường input cho modal edit
    updateAvatar.onchange = evt => {
        const [file] = updateAvatar.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>
@endsection

@section('content')
<!-- Import File Excel -->
<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chọn file Excel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-danger">
                    <ul id="importErrors">
                    </ul>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">File Excel</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input id="importFile" type="file" name="file_excel" accept=".xls, .xlsx"
                                class="custom-file-input">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            <div class="text-danger create_avatar_error"></div>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" id="importBtn" class="btn btn-primary">Import</button>
            </div>

        </div>
    </div>
</div>
<!-- Them moi -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="createFormValidate">
            <div class="modal-body">
                <div style="text-align:center">
                    <img id="blah2" src="#"  style="height:150px;width:150px" />
                </div>
                <div class="form-group">
                    <label for="inputName">Tên</label>
                    <input type="text" id="storeName" class="form-control" placeholder="Nhập tên" required>
                    <div class="text-danger create_name_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Địa chỉ</label>
                    <input type="text" id="storeAddress" class="form-control" placeholder="Nhập địa chỉ" required>
                    <div class="text-danger create_address_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Số điện thoại</label>
                    <input type="phone" id="storePhone" class="form-control" placeholder="(+84)" required>
                    <div class="text-danger create_phone_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Email</label>
                    <input type="email" id="storeEmail" class="form-control" placeholder="Nhập email" required>
                    <div class="text-danger create_email_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Mật khẩu</label required>
                    <input type="password" id="storePassword" placeholder="Nhập mật khẩu" class="form-control">
                    <div class="text-danger create_password_error"></div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="storeAvatar">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        <div class="text-danger create_avatar_error"></div>
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
                    <div class="text-danger create_role_error"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="addBtn">Lưu</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Cap nhat -->
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
            <form action="" id="updateFormValidate">
            <div class="modal-body">
                <div style="text-align:center">
                    <img id="blah" src="#"  style="height:150px;width:150px" />
                </div>
                <div class="form-group">
                    <label for="inputName">Tên</label>
                    <input type="text" id="updateName" class="form-control" placeholder="Nhập tên" required>
                    <div class="text-danger update_name_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Email</label>
                    <input type="email" id="updateEmail" class="form-control" placeholder="Nhập email" required>
                    <div class="text-danger update_email_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Địa chỉ</label>
                    <input type="text" id="updateAddress" class="form-control" placeholder="Nhập địa chỉ" required>
                    <div class="text-danger update_address_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Số điện thoại</label>
                    <input type="phone" id="updatePhone" class="form-control" placeholder="Nhập Số điện thoại" required>
                    <div class="text-danger update_phone_error"></div>
                </div>
                <!-- <div class="form-group">
                    <label for="inputProjectLeader">Mật khẩu</label required>
                    <input type="password" id="updatePassword" name="password" placeholder="Nhập mật khẩu" class="form-control" required>
                    <div class="text-danger update_password_error"></div>
                </div> -->
                <div class="form-group">
                    <label for="inputProjectLeader">Ảnh</label>
                    <input accept="image/*" type='file' id="updateAvatar" class="form-control" />
                    <div class="text-danger update_avatar_error"></div>
                </div>
                <div class="form-group">
                    <label for="inputStatus">Quyền</label>
                    <select id="updateRole" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                        <option value="1">Super admin</option>
                        <option value="2">Admin</option>
                        <option value="3">Sales Agent</option>
                    </select>
                    <div class="text-danger update_role_error"></div>
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
                    <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modal-import">
                        <i class="nav-icon fa fa-plus"></i> Import
                    </button>
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-create">
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