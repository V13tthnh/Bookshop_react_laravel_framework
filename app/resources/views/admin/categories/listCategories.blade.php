@extends('layout')
@section('content')
<div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-9">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Danh Sach Danh Muc</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ten Danh Muc</th>
                                        <th scope="col">Mo Ta</th>
                                        <th scope="col">Slug</th>
                                    </tr>
                                </thead> 
                               
                                <tbody>
                                @forelse($listCategories as $category)
                                    <tr> 
                                        <th scope="row">{{$category->id}}</th>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->description}}</td>
                                        <td>{{$category->slug}}</td>
                                        <td><a href="{{ route('admin.categories.edit', ['id' => $category->id ])}}" class="btn btn-primary">Sua</a>  /   <a href="{{ route('admin.categories.delete', ['id' => $category->id ])}}" class="btn btn-primary">Xoa</a></td>
                                    </tr>
                                  @endforeach
                                </tbody>
                                 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection