@extends('layout')

@section('js')
<script>
    $(document).ready(function() {
        $('#updateInfoBtn').click(function(e) {
            e.preventDefault();
            var id = $('#adminId').val();
            var file = $('#avatar')[0].files;
            var formData = new FormData();
            formData.append('_token', "{{csrf_token()}}");
            formData.append('name', $('#name').val());
            formData.append('address', $('#address').val());
            formData.append('phone', $('#phone').val());
            formData.append('email', $('#email').val());
            formData.append('role', $('#role').find(':selected').val());
            formData.append('avatar', file[0]);
            $.ajax({
                url: "/admin/update/" + id,
                method: "post",
                data: formData;
                contentType: false,
                processData: false,
            }).done(function(res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' }); 
                }
                if (!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            })
        });
        $('#changePasswordBtn').click(function(e) {
            e.preventDefault();
            alert("abc");
        });
    });
</script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Trang cá nhân</h1>
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @auth
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if(Auth::user()->avatar != null)
                            <img class="profile-user-img img-fluid img-circle" src="{{asset('/'.Auth::user()->avatar)}}"
                                alt="User profile picture">
                            @else
                            <img class="profile-user-img img-fluid img-circle" src="{{asset('dist/img/user.jpg')}}"
                                alt="User profile picture">
                            @endif
                        </div>
                        <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>
                        @if(Auth::user()->role == 1)
                        <p class="text-muted text-center">Supper Admin</p>
                        @elseif(Auth::user()->role == 2)
                        <p class="text-muted text-center">Admin</p>
                        @else(Auth::user()->role == 3)
                        <p class="text-muted text-center">Sale</p>
                        @endif
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin cá nhân</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-envelope mr-1"></i>Email</strong>
                        <p class="text-muted">{{Auth::user()->email}}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>

                        <p class="text-muted">{{Auth::user()->address}}</p>
                        <hr>
                        <strong><i class="fas fa-phone-alt mr-1"></i>Số điện thoại</strong>
                        <p class="text-muted">{{Auth::user()->phone}}</p>
                        <hr>
                    </div>
                </div>
            </div>
            @endauth
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#update" data-toggle="tab">Cập nhật
                                    thông tin</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#resetPwd" data-toggle="tab">Đổi mật khẩu</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="update">
                                <form id="updateInfoForm">
                                    <input type="number" class="form-control" value="{{Auth::user()->id}}" id="adminId"
                                        hidden>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Họ Tên</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{Auth::user()->name}}"
                                                id="name" placeholder="Nhập họ tên">
                                        </div>
                                        <div class="text-danger name_error"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email"
                                                value="{{Auth::user()->email}}" placeholder="Email">
                                        </div>
                                        <div class="text-danger email_error"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Địa chỉ</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="address"
                                                value="{{Auth::user()->address}}" placeholder="Nhập địa chỉ">
                                        </div>
                                        <div class="text-danger address_error"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Số điện thoại</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone"
                                                value="{{Auth::user()->phone}}" placeholder="Nhập SĐT">
                                        </div>
                                        <div class="text-danger password_error"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputProjectLeader" class="col-sm-2 col-form-label">Ảnh</label>
                                        <div class="col-sm-10">
                                            <input accept="image/*" type='file' id="avatar" class="form-control" />
                                        </div>
                                        <div class="text-danger avatar_error"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputStatus" class="col-sm-2 col-form-label">Quyền</label>
                                        <div class="col-sm-10">
                                            <select name="role" id="role" class="form-control custom-select">
                                                <option selected disabled>Select one</option>
                                                <option value="1">Super admin</option>
                                                <option value="2">Admin</option>
                                                <option value="3">Sales Agent</option>
                                            </select>
                                        </div>
                                        <div class="text-danger role_error"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button id="updateInfoBtn" class="btn btn-danger">Lưu</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="resetPwd">
                                <form id="changePasswordForm">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Mật khẩu mới</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputName"
                                                placeholder="Nhập mật khẩu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button id="changePasswordBtn" class="btn btn-danger">Đổi mật khẩu</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection