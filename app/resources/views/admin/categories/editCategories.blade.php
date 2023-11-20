@extends('layout')
@section('content')

<form action="{{route('admin.categories.edit',['id'=>$editCategories->id])}}" method="POST">
    @csrf
<div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">DANH MỤC</h6>
                            <label for="basic-url" class="form-label">TÊN DANH MỤC</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"  aria-label="TÊN DANH MỤC"
                                    aria-describedby="basic-addon1" name="ten_danh_muc" value= "{{$editCategories->name}}">
                            </div>
                            <label for="basic-url" class="form-label">MÔ TẢ</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" aria-label="With textarea" name="mo_ta" >{{$editCategories->description}}</textarea>
                            </div>

                            <label for="basic-url" class="form-label">BOOK SLUG</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="book_slug" value="{{$editCategories->slug}}">
                            </div>

                            <button type="submit" class="btn btn-primary">Xac Nhan</button>
                         
                          
                           
                        </div>
                    </div>
</form>

@endsection