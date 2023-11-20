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
            <h6 class="mb-4">EDIT CATEGORIES</h6>
            <form action="{{route('category.update', $editCategories->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên</label>
                    <input name="name" value="{{$editCategories->name}}" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="exampleInputPassword1" value="{{$editCategories->slug}}">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Mô Tả</label>
                    <textarea name="description" id="editor" cols="30" rows="10">{{$editCategories->description}}</textarea>
                </div>
                
              
               
               

                <button type="submit" class="btn btn-success mt-2">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection