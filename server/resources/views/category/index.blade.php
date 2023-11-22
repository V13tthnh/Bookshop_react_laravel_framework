@extends('layout')

@section('js')
<!-- SUMMERNOTE THEM -->
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
// SUMMERNOTE SUA
  $(function () {
    // Summernote
    $('#summernote1').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
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
    //Edit ajax
    $(document).ready(function () {
        $(document).on('click', '.editBtn', function () {
            var id = $(this).val();
            $('#modal-edit').modal('show');
            $.ajax({
                url: '/category/edit/' + id,
                type: "get",
                success: function (result) {
                    //console.log(result.supplier);
                    $('#id').val(result.category.id)
                    $('#name').val(result.category.name);   
                    $('#summernote1').summernote('code', result.category.description);
                    $('#slug').val(result.category.slug);
                }
            });
        });
    });

   // DataTable setting
   $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
<!-- Them -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Nhà Danh Mục</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" name="name" id="inputName" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="inputProjectLeader">Mô tả</label required>
                        <textarea name="description" id="summernote" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Slug</label required>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                   
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Sua -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa nhà Danh Mục</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('category.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body">
                <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mô tả</label required>
                        <textarea name="description" id="summernote1" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Slug</label required>
                        <input type="text" name="slug" id="slug" class="form-control" required>
                    </div>
                   
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách Danh Mục</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('category.trash')}}" class="btn btn-warning">
                        <i class="nav-icon fa fa-list"></i> Danh sách đã xóa
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
                                    <th>Tên</th>   
                                    <th>Mô tả</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($listCategories as $item)
                                <tr>
                                    <td>{{$id++ }}</td>
                                  
                                    <td><a href="">{{$item->name}}</a></td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->description}}</td>
                              
                                    <td>
                                        <button class="btn btn-warning editBtn" value="{{$item->id}}"><i
                                                class="nav-icon fa fa-edit"></i></a>
                                            <form action="{{route('category.destroy', $item->id)}}" method="post">
                                                @csrf
                                                <button class="btn btn-danger" type="submit"><i
                                                        class="nav-icon fa fa-trash"></i></a>
                                            </form>
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
                    {{$listCategories->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
