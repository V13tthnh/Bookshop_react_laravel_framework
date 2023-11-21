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
@section('content')

@if(session('errorMsg'))
    <script>
        Swal.fire({
            title: 'Thêm không thành công!',
            text: '{{session('errorMsg')}}',
            icon: 'error',
            confirmButtonText: 'OK'
        })
    </script>
@endif

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">NHẬP HÀNG</h6>
            <form action="{{route('supplier.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên</label>
                    <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Địa chỉ</label>
                    <input name="address" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Điện thoại</label>
                    <input name="phone" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Mô tả</label>
                    <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Slug</label>
                    <input class="form-control bg-dark" name="slug" type="text" id="exampleInputEmail1">
                </div>

                

                <button type="submit" class="btn btn-success mt-2">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection