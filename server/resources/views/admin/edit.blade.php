<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.update', $admin->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="number" id="id" value="{{$admin->id}}" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input id="name" type="text" value="{{$admin->name}}" name="name" id="inputName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Email</label>
                        <input id="email" type="email" value="{{$admin->email}}" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mật khẩu</label required>
                        <input id="password" type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Ảnh</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="avatar" type="file" name="avatar" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Quyền</label>
                        <select id="role" name="role" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            <option value="1" @if($admin->role === 1) selected @endif>Super admin</option>
                            <option value="2" @if($admin->role === 2) selected @endif>Admin</option>
                            <option value="3" @if($admin->role === 3) selected @endif>Sales Agent</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>