@extends('layout')

@if(session('errorMsg'))
    <script>
    Swal.fire({
        title: '{{session('errorMsg')}}',
        icon: 'error',
        confirmButtonText: 'OK'
    })
    </script>
@endif


@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Sửa admin</h6>
            <form action="{{route('admin.update', $admin->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên</label>
                    <input name="name" value="{{$admin->name}}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input name="email" value="{{$admin->email}}" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="text" name="password" class="form-control" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Avatar</label>
                    <input class="form-control bg-dark" name="avatar" type="file" id="formFile">
                </div>

                <div class="mb-3">
                <label for="formFile" class="form-label">Quyền</label>
                    <select name="role" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        <option value="1" @if($admin->role === 1) selected @endif>Super admin</option>
                        <option value="2" @if($admin->role === 2) selected @endif>admin</option>
                        <option value="3" @if($admin->role === 3) selected @endif>sales agent</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-2">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection