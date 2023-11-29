@extends('layout')

@section('js')
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection

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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách slider</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{route('slider.index')}}" class="btn btn-warning">
                        <i class="nav-icon fa fa-list"></i> Danh sách
                    </a>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách slider</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Sách</th>
                                    <th>Hình ảnh</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trash as $item)
                                <tr>
                                <td>{{$id++}}</td>
                                    <td><a href="">{{$item->name}}</a></td>
                                    <td>{{$item->start_date}}</td>
                                    <td>{{$item->end_date}}</td>
                                    <td>{{$item->book->name}}</td>
                                    <td style="text-align:center;">
                                        @if($item->image != null)
                                        <img src="{{asset('/'.$item->image)}}" alt="" sizes="40" srcset=""
                                            style="height:100px;width:140px">
                                        @else
                                        <img src="{{asset('dist/img/user.jpg')}}" alt="" sizes="40" srcset=""
                                            style="height:100px;width:140px">
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="{{route('slider.untrash', $item->id)}}" class="btn btn-info"
                                            type="submit"><i class="nav-icon fa fa-trash-restore-alt"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=5>Không có dữ liệu!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection