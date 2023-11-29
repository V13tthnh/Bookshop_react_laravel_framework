@extends('layout')

@section('js')
<script>
    //Edit ajax
    $(document).ready(function () {
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "paging":true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        
        $(document).on('click', '.editBtn', function () {
            var id = $(this).val();
            $('#modal-edit').modal('show');
            $.ajax({
                url: '/slider/edit/' + id,
                type: "get",
                success: function (result) {
                    console.log(result.data.year);
                    $('#id').val(result.data.id);
                    $('#name').val(result.data.name);
                    $('#start_date').val(result.data.start_date);
                    $('#end_date').val(result.data.end_date);
                    $('#book_id').val(result.data.book_id);
                    $('#image').val(result.data.image);
                }
            });
        });
    });

    

    $(function () {
        // Summernote
        $('#summernote').summernote();
        $('#summernote1').summernote();
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
<!-- Them sach -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Slider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Sách</label>
                        <select id="inputStatus" name="book_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listBook as $book)
                            <option value="{{$book->id}}">{{$book->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Hình ảnh</label>
                        <input accept="image/*" type='file' name="image" id="imgInp2" class="form-control" />
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

<!-- Sua sach -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa Slider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('slider.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input id="name" type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày bắt đầu</label>
                        <input id="start_date" type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày kết thúc</label>
                        <input id="end_date" type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Sách</label>
                        <select id="book_id" name="book_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listBook as $book)
                            <option value="{{$book->id}}">{{$book->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Hình ảnh</label>
                        <input accept="image/*" type='file' name="image" id="imgInp2" class="form-control" />
                      
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
                <h1>Danh sách slider</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('slider.trash')}}" class="btn btn-warning">
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
                        <h3 class="card-title">Danh sách sách</h3>
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
                                @forelse($listSlider as $item)
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
                                    <td>
                                
                                        <button class="btn btn-warning editBtn" value="{{$item->id}}">
                                            <i class="nav-icon fa fa-edit"></i>
                                        </button>
                                        <form class="d-line" action="{{route('slider.destroy', $item->id)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">
                                                <i class="nav-icon fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=7>Không có dữ liệu!</td>
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