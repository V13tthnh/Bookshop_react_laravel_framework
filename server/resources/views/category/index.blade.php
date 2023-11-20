@extends('layout')



@section('content')

@if(session('errorMsg'))
    <script>
    Swal.fire({
        title: '{{session('errorMsg')}}',
        icon: 'error',
        confirmButtonText: 'OK'
    })
    </script>
@endif

@if(session('successMsg'))
    <script>
    Swal.fire({
        title: '{{session('successMsg')}}',
        icon: 'success',
        confirmButtonText: 'OK'
    })
    </script>
@endif

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="m-n2">
                    <div class="btn-group" role="group">
                        <a href="#">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">Import Excel</label>
                        </a>

                        <a href="#">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">Export Excel</label>
                        </a>

                        <a href="#">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio3">Export PDF</label>
                        </a>
                        <a href="">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio4">Refresh</label>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="m-n2">
                    <a href="{{route('category.create')}}">
                        <button type="button" class="btn btn-success m-2"><i class="fa fa-plus me-2"></i>Thêm</button>
                    </a>
                    <a href="{{route('category.trash')}}">
                        <button type="button" class="btn btn-warning m-2"><i class="fa fa-list me-2"></i>Danh sách đã xóa</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Danh Muc</h6>
            <a href="">Show All</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col"><input class="form-check-input" type="checkbox"></th>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse($listCategories as $item)
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>{{$id+=1}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->slug}}</td>
                            <td>   
                            
                            <a type="button" href="{{route('category.edit', $item->id)}}" class="btn btn-rectangle btn-warning m-2"><i class="fa fa-edit"></i></a>
                                <form class="d-inline" action="{{route('category.destroy', $item->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-rectangle btn-primary m-2"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr colspan=4>Không có dữ liệu!</tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-4 mt-3 ">
        {{$listCategories->links()}}
    </div>
</div>
@endsection