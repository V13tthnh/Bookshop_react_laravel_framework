@extends('layout')

@section('js')

<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
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
                <h1>Chi tiết admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="{{route('admin.index')}}" class="btn btn-warning">
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
                        <h3 class="card-title">Danh sách admin</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Avatar</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$admin->id}}</td>
                                    <td><img src="{{asset('/'.'$item->avatar')}}" alt="" sizes="40" srcset=""></td>
                                    <td><a href="">{{$admin->name}}</a></td>
                                    <td>{{$admin->email}}</td>
                                    <td>
                                        <form action="{{route('admin.destroy', $admin->id)}}" type="post">
                                            <a href="{{route('admin.edit', $admin->id)}}" class="btn btn-warning"
                                                type="submit"><i class="nav-icon fa fa-edit"></i></a>
                                            <button class="btn btn-danger" type="submit"><i
                                                    class="nav-icon fa fa-trash"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection