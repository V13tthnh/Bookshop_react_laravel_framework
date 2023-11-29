@extends('layout')

@section('js')



<script>
    //Edit ajax
    $(document).ready(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $(document).on('click', '.editBtn', function () {
            var id = $(this).val();
            //alert(id)
            $('#modal-edit').modal('show');
            $.ajax({
                url: '/book/edit/' + id,
                type: "get",
                success: function (result) {
                    console.log(result.data.year);
                    $('#id').val(result.data.id);
                    $('#name').val(result.data.name);
                    $('#code').val(result.data.code);
                    $('#weight').val(result.data.weight);
                    $('#format').val(result.data.format);
                    $('#year').val(result.data.year);
                    $('#language').val(result.data.language);
                    $('#size').val(result.data.size);
                    $('#num_pages').val(result.data.num_pages);
                    $('#slug').val(result.data.slug);
                    $('#translator').val(result.data.translator);
                    $('#author_id').val(result.data.author_id);
                    $('#category_id').val(result.data.category_id);
                    $('#publisher_id').val(result.data.publisher_id);
                    $('#summernote1').summnernote('code',result.data.description);
                   
                }
            });
        });
    });

    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": true,
            "paging": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(function () {
        // Summernote
        $('#summernote').summernote();
        $('#summernote1').summernote()
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
                <h4 class="modal-title">Thêm sách</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('book.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Code</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Mô tả</label>
                        <textarea id="summernote" type="text" name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Trọng lượng</label>
                        <input  type="text" name="weight" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Hình thức</label>
                        <input type="text" name="format" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Năm xuất bản</label>
                        <input type="text" name="year" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngôn ngữ</label>
                        <input type="text" name="language" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Kích cỡ</label>
                        <input type="text" name="size" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Số trang</label>
                        <input type="text" name="num_pages" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Người phiên dịch</label>
                        <input type="text" name="translator" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Tác giả</label>
                        <select id="inputStatus" name="author_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listAuthor as $author)
                            <option value="{{$author->id}}">{{$author->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Nhà xuất bản</label>
                        <select id="inputStatus" name="publisher_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listPublisher as $publisher)
                            <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Thể loại</label>
                        <select id="inputStatus" name="category_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listCategory as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputStatus">Minimal</label>
                    <select class="form-control select2bs4" style="width: 100%;">
                        <option selected disabled>Select one</option>
                        <option>Alabama</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
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
                <h4 class="modal-title">Sửa sách</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('book.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input id="name" type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Code</label>
                        <input id="code" type="text" name="code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Mô tả</label>
                        <textarea id="summernote1" name="description" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Trọng lượng</label>
                        <input id="weight" type="text" name="weight" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="inputName">Hình thức</label>
                        <input id="format" type="text" name="format" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="inputName">Năm xuất bản</label>
                        <input id="year" type="text" name="year" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngôn ngữ</label>
                        <input id="language" type="text" name="language" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="inputName">Kích cỡ</label>
                        <input id="size" type="text" name="size" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Số trang</label>
                        <input id="num_pages" type="number" name="num_pages" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Người phiên dịch</label>
                        <input id="translator" type="text" name="translator" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Tác giả</label>
                        <select id="author_id" name="author_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listAuthor as $author)
                                <option value="{{$author->id}}">{{$author->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Nhà sản xuất</label>
                        <select id="publisher_id" name="publisher_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listPublisher as $publisher)
                                <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Thể loại</label>
                        <select id="category_id" name="category_id" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                            @foreach($listCategory as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
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
                <h1>Danh sách sách</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="{{route('book.trash')}}" class="btn btn-warning">
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
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Nhà xuất bản</th>
                                    <th>Tác giả</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($listBook as $item)
                                <tr>
                                    <td>{{$id++}}</td>
                                    <td><a href="">{{$item->name}}</a></td>
                                    <td>{{$item->unit_price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->supplier->name}}</td>
                                    <td>{{$item->publisher->name}}</td>
                                    <td>{{$item->author->name}}</td>
                                    <td>
                                        <button class="btn btn-warning editBtn" value="{{$item->id}}">
                                            <i class="nav-icon fa fa-edit"></i>
                                        </button>
                                        <form class="d-line" action="{{route('book.destroy',$item->id)}}" method="POST">
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