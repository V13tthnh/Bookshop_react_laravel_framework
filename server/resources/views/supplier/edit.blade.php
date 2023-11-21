@extends('layout')
@section('js')
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection
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
            <form action="{{route('supplier.update', $editSuppliers->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên</label>
                    <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$editSuppliers->name}}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Địa chỉ</label>
                    <input name="address" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$editSuppliers->address}}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Điện thoại</label>
                    <input name="phone" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$editSuppliers->phone}}">
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Mô tả</label>
                    <textarea name="description" id="editor" cols="30" rows="10">{{$editSuppliers->description}}</textarea>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Slug</label>
                    <input class="form-control bg-dark" name="slug" type="text" id="exampleInputEmail1" value="{{$editSuppliers->slug}}">
                </div>
             

                <button type="submit" class="btn btn-success mt-2">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection