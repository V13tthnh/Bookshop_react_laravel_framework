@extends('layout')

@section('js')
<script>
    //Edit ajax
    $(document).ready(function () {
        $('.select2').select2();
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: `<i class="fa fa-print"><i/> In` },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('slider.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'book_name', name: 'book.name' },
                {
                    data: 'image', render: function (data, type, row) {
                        if (data != null) {
                            return '<img src="' + data + '" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                        }
                        return "Không có hình ảnh";
                    }
                },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning editBtn  " value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                            + '<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                    }
                },
            ],
        });

        var formDataCreate = new FormData();
        var formDataEdit = new FormData();
        //create image
        $('#storeImage').change(function (e) {
            var input = e.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    formDataCreate.set("image", input.files[0]);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        //create image
        $('#updateImage').change(function (e) {
            var input = e.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    formDataEdit.set("image", input.files[0]);
                    console.log(input.files[0]);
                }
                reader.readAsDataURL(input.files[0]);
            }
            console.log(input.files[0]);
        });

        function createFormClear() {
            $('#storeName').val("");
            $('#storeStartDate').val("");
            $('#storeEndDate').val("");
            $("#storeBookId").val($("#storeBookId option:first").val());
            $('#storeImage').attr('src', '');
        }
        $('#modal-create').on('hidden.bs.modal', function () {
            $('#createFormValidate').removeClass('was-validated');
            $('.create_name_error').text('');
            $('.create_start_date_error').text('');
            $('.create_end_date_error').text('');
            $('.create_book_id_error').text('');
            $('.create_image_error').text('');
        });
        $('#modal-edit').on('hidden.bs.modal', function () {
            $('#updateFormValidate').removeClass('was-validated');
            $('.update_name_error').text('');
            $('.update_start_date_error').text('');
            $('.update_end_date_error').text('');
            $('.update_book_id_error').text('');
            $('.update_image_error').text('');
        });

        //store
        $('#addBtn').click(function (e) {
            e.preventDefault();
            var name = $('#storeName').val();
            var start_date = $('#storeStartDate').val();
            var end_date = $('#storeEndDate').val();
            var book_id = $('#storeBookId').find(':selected').val();
            formDataCreate.append("_token", "{{csrf_token()}}");
            formDataCreate.append("name", name);
            formDataCreate.append("start_date", start_date);
            formDataCreate.append("end_date", end_date);
            formDataCreate.append("book_id", book_id);
            $.ajax({
                url: "{{route('slider.store')}}",
                method: "post",
                data: formDataCreate,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide'); //ẩn model thêm mới
                    createFormClear();
                    table.ajax.reload(); //refresh bảng 
                }
                if (!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            }).fail(function (res) {
                $('#createFormValidate').addClass('was-validated');
                $.each(res.responseJSON.errors, function (key, value) {
                    $('.create_' + key + '_error').text(value[0]);
                    $('.create_' + key + '_error').text(value[1]);
                    $('.create_' + key + '_error').text(value[2]);
                    $('.create_' + key + '_error').text(value[3]);
                    $('.create_' + key + '_error').text(value[4]);
                });
            });
        });

        //edit
        $('#myTable').on('click', '.editBtn', function () {
            var id = $(this).val();
            $.ajax({
                url: "slider/edit/" + id,
                method: "get",
            }).done(function (res) {
                if (res.data == null) {
                    Swal.fire({ title: "Dữ liệu không tồn tại", icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
                $('#updateId').val(res.data.id);
                $('#updateName').val(res.data.name);
                $('#updateStartDate').val(res.data.start_date);
                $('#updateEndDate').val(res.data.end_date);
                $('#updateBookId').val(res.data.book_id);
                $('#updateBookId').trigger('change');
            })
        });

        //update
        $('#updateBtn').click(function (e) {
            e.preventDefault();
            var id = $('#updateId').val();
            var name = $('#updateName').val();
            var start_date = $('#updateStartDate').val();
            var end_date = $('#updateEndDate').val();
            var book_id = $('#updateBookId').find(':selected').val();
            formDataEdit.append("_token", "{{csrf_token()}}");
            formDataEdit.append("name", name);
            formDataEdit.append("start_date", start_date);
            formDataEdit.append("end_date", end_date);
            formDataEdit.append("book_id", book_id);
            $.ajax({
                url: "slider/update/" + id,
                method: "post",
                data: formDataEdit,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide'); //ẩn model thêm mới
                    table.ajax.reload(); //refresh bảng 
                }
            }).fail(function (res) {
                $('#updateFormValidate').addClass('was-validated');
                $.each(res.responseJSON.errors, function (key, value) {
                    $('.update_' + key + '_error').text(value[0]);
                    $('.update_' + key + '_error').text(value[1]);
                    $('.update_' + key + '_error').text(value[2]);
                    $('.update_' + key + '_error').text(value[3]);
                    $('.update_' + key + '_error').text(value[4]);
                });
            });
        });

        //delete
        $('#myTable').on('click', '.deleteBtn', function () {
            var id = $(this).val();
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: 'Đừng lo, bạn vẫn có thể khôi phục lại dữ liệu đã xóa!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: "slider/destroy/" + id,
                        method: "post",
                        data: { "_token": "{{csrf_token()}}" }
                    }).done(function (res) {
                        if (res.success) {
                            Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                            table.ajax.reload(); //refresh bảng 
                        }
                    });
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
            <form action="" id="createFormValidate">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tiêu đề</label>
                        <input type="text" id="storeName" class="form-control" required>
                        <div class="text-danger create_name_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày bắt đầu</label>
                        <input type="date" id="storeStartDate" class="form-control" required>
                        <div class="text-danger create_start_date_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày kết thúc</label>
                        <input type="date" id="storeEndDate" class="form-control" required>
                        <div class="text-danger create_end_date_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Sách</label>
                        <select id="storeBookId" class="form-control select2" style="width: 100%;">
                            <option selected disabled>Select one</option>
                            @foreach($listBook as $book)
                            <option value="{{$book->id}}">{{$book->name}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger create_book_id_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Hình ảnh</label>
                        <input type='file' id="storeImage" class="form-control" />
                        <div class="text-danger create_image_error"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="addBtn">Lưu</button>
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
            <form action="" id="updateFormValidate">
                <input type="text" id="updateId" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Tên</label>
                        <input type="text" id="updateName" class="form-control" required>
                        <div class="text-danger update_name_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày bắt đầu</label>
                        <input type="date" id="updateStartDate" class="form-control" required>
                        <div class="text-danger update_start_date_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Ngày kết thúc</label>
                        <input type="date" id="updateEndDate" class="form-control" required>
                        <div class="text-danger update_end_date_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Sách</label>
                        <select id="updateBookId" class="form-control select2" style="width: 100%;">
                            <option selected disabled>Select one</option>
                            @foreach($listBook as $book)
                            <option value="{{$book->id}}">{{$book->name}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger update_book_id_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Hình ảnh</label>
                        <input accept="image/*" type='file' id="updateImage" class="form-control" />
                        <div class="text-danger update_image_error"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="updateBtn">Lưu thay đổi</button>
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
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-create">
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
                        <table id="myTable" class="table table-bordered table-striped">
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection