@extends('layout')

@section('content')
 <!-- Sale & Revenue Start -->
@if(session('notification'))
    <div class="alert alert-success me-2">
        <p>{{session('notification')}}</p>
    </div>
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
                    <a href="{{route('admin.create')}}">
                        <button type="button" class="btn btn-success m-2"><i class="fa fa-plus me-2"></i>Thêm</button>
                    </a>
                    <a href="">
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
            <h6 class="mb-0">All Admin</h6>
            <a href="">Show All</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col"><input class="form-check-input" type="checkbox"></th>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    {{$id = 1}}
                    @forelse($admins as $item)
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>{{$id++}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>    
                            <button type="button" class="btn btn-rectangle btn-warning m-2"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-rectangle btn-primary m-2"><i class="fa fa-trash"></i></button>
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
        {{$admins->links()}}
    </div>
</div>
@endsection