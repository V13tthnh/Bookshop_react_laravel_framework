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
    //Edit ajax
    $(document).ready(function () {
        $(document).on('click', '.editBtn', function () {
            var id = $(this).val();
            $('#modal-edit').modal('show');
            $.ajax({
                url: '/admin/edit/' + id,
                type: "get",
                success: function (result) {
                    //console.log(result.admin);
                    $('#id').val(result.admin.id);
                    $('#name').val(result.admin.name);
                    $('#email').val(result.admin.email);
                    $("#role").val(result.admin.role);
                }
            });
        });
        
    });

    // DataTable setting
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": true,
            "paging": false, "ordering": true, "searching": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    //Xem trước ảnh create
    imgInp2.onchange = evt => {
        const [file] = imgInp2.files
        if (file) {
            blah2.src = URL.createObjectURL(file)
        }
    }
    // Xem trước ảnh edit
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
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
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" name="name" id="inputName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mật khẩu</label required>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Ảnh</label>
                        <input accept="image/*" type='file' name="avatar" id="imgInp2" class="form-control" />
                        <label>Xem trước: </label>
                        <img id="blah2" src="#" alt="your image" style="with: 70px; height: 70px" />
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Quyền</label>
                        <select id="inputStatus" name="role" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            <option value="1">Super admin</option>
                            <option value="2">Admin</option>
                            <option value="3">Sales Agent</option>
                        </select>
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

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input id="name" type="text" name="name" id="inputName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Email</label>
                        <input id="email" type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Mật khẩu</label required>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Ảnh</label>
                        <input accept="image/*" type='file' name="avatar" id="imgInp" class="form-control" />
                        <label>Ảnh của bạn: </label>
                        <img id="blah" src="#" alt="your image" style="with: 70px; height: 70px" />
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Quyền</label>
                        <select id="role" name="role" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            <option value="1">Super admin</option>
                            <option value="2">Admin</option>
                            <option value="3">Sales Agent</option>
                        </select>
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
                <h1>Danh sách admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('admin.trash')}}" class="btn btn-warning">
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
                                    <th>Avatar</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $item)
                                <tr>
                                    <td style="text-align:center;">{{$id++}}</td>
                                    <td style="text-align:center;">
                                        @if($item->avatar != null)
                                        <img src="{{asset('/'.$item->avatar)}}" alt="" sizes="40" srcset=""
                                            style="height:100px;width:100px">
                                        @else
                                        <img src="{{asset('dist/img/user.jpg')}}" alt="" sizes="40" srcset=""
                                            style="height:100px;width:100px">
                                        @endif
                                    </td>
                                    <td style="text-align:center;">{{$item->name}}</td>
                                    <td style="text-align:center;">{{$item->email}}</td>
                                    <td style="text-align:center;">
                                        <button class="btn btn-warning editBtn" value="{{$item->id}}">
                                            <i class="nav-icon fa fa-edit"></i>
                                        </button>
                                        <div class="btn-group btn-group-toggle">
                                            <form class="d-line" action="{{route('admin.destroy', $item->id)}}"
                                                onsubmit="return confirm('Xác nhận xóa?');" method="post">
                                                @csrf
                                                <button class="btn btn-danger">
                                                    <i class="nav-icon fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=5>Không có dữ liệu!</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan=5>
                                        {{$admins->links()}}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection