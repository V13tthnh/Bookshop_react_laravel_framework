@extends('layout')
@section('content')
<form method="POST"  enctype="multipart/form-data" action="{{route('author.update', ['id' => $author->id ])}}">
   @csrf
    <table border=0>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Sửa</h6>
                            <form>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Tên</label>
                                    <div class="col-sm-10">
                                        <input type="text" name='name' class="form-control" id="name" value="{{$author->name}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-sm-2 col-form-label">Thông tin</label>
                                    <div class="col-sm-10">
                                        <input type="text" name='description' class="form-control" id="description" value="{{$author->description}}"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="slug" class="col-sm-2 col-form-label">URL</label>
                                    <div class="col-sm-10">
                                        <input type="text" name='slug' class="form-control" id="slug" value="{{$author->slug}}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                <label for="formFile" class="form-label">Default file input example</label>
                                <input class="form-control bg-dark" type="file"  name="image" id="formFile">
                            </div>
                                <div class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Checkbox</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck1">
                                            <label class="form-check-label" for="gridCheck1">
                                                Check me out
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </form>
                        </div>
                    </div>
    </table>
</form>
@endsection