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
            <h6 class="mb-4">Thêm tac gia</h6>
            <form action="{{route('author.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tên</label>
                    <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Thong tin</label>
                    <textarea name="description" id="editor" cols="30" rows="10"></textarea>
                    
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Hinh anh</label>
                    <input class="form-control bg-dark" name="image" type="file" id="formFile">
                </div>

                
                <button type="submit" class="btn btn-success mt-2">Lưu</button>
            </form>
        </div>
    </div>
</div>
     
    </table>
</form>
@endsection