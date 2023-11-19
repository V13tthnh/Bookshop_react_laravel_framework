@extends('layout')
@section('content')
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Salse</h6>
                        <a href="">Show All</a>
                        <a class="btn btn-sm btn-primary" href="{{route('author.create')}}">Thêm mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Thông tin</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($ListAuthor as $author)
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>{{ $author->id}}</td>
                                    <td>{{ $author->name}}</td>
                                    <td>{{$author->description}}</td>
                                    <td>{{$author->slug}}</td>
                                    <td>{{$author->image}}</td>
                                    <td><a class="btn btn-sm btn-info" href="{{route('author.edit', ['id' => $author->id ])}}">Sửa</a>|<a class="btn btn-sm btn-primary" href="">Detail</a>
                                    |<a class="btn btn-sm btn-danger" href="{{route('author.delete',['id' => $author->id ])}}">Xóa</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

 @endsection