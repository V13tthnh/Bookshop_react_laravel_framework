@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('#date_range_store').daterangepicker({
            startDate: moment().add(5, 'day'),
            minDate: moment(),
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        $('#date_range_update').daterangepicker({
            startDate: moment().add(5, 'day'),
            minDate: moment(),
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" },
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: "In" },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('discount.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'book_name', name: 'book.name' },
                { data: 'percent', name: 'percent' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning editBtn" value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i> Sửa</button>';
                           
                    },
                }
            ],
        });
        //Xử lý gán ngày bắt đầu và ngày kết thúc vào input trong mo dal create
        $('#date_range_store').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');
            $('#store_start_date').val(startDate);
            $('#store_end_date').val(endDate);
        });
        //Xử lý gán ngày bắt đầu và ngày kết thúc vào input trong modal update
        $('#date_range_update').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');
            $('#update_start_date').val(startDate);
            $('#update_end_date').val(endDate);
        });
        //Thực hiện thêm mới
        $('#addBtn').click(function () {
            $.ajax({
                url: '{{route('discount.store')}}',
                method: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    'book_id': $(' #store_book_id').val(),
                    'percent': $('#store_percent').val(),
                    'start_date': $('#store_start_date').val(),
                    'end_date': $('#store_end_date').val()
                }
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide');
                    table.ajax.reload();
                } else {
                    Swal.fire({ titlage, icon: 'success', confirmButtonText: 'OK' });
                }
            }).fail(function (res) {
                $('#createFormValidate').addClass('was-validated');
                $.each(res.responseJSON.errors, function (key, value) {
                    $('.create_' + key + '_error').text(value[0]);
                    $('.create_' + key + '_error').text(value[1]);
                    $('.create_' + key + '_error').text(value[2]);
                    $('.create_' + key + '_error').text(value[3]);
                });
            });
        });
        //Lấy chi tiết gán lại vào modal edit
        $('#myTable').on('click', '.editBtn', function () {
            var id = $(this).val();
            $.ajax({
                url: "discount/edit/" + id,
                method: 'get',
            }).done(function (res) {
                if (res.success) {
                    $('#discount_id').val(res.data.id);
                    $('#update_book_id').val(res.data.book_id);
                    $('#update_book_id').trigger('change');
                    $('#update_percent').val(res.data.percent);
                    $('#update_start_date').val(res.data.start_date);
                    $('#update_end_date').val(res.data.end_date);
                    $('#old_date_range').val(res.data.start_date + ' - ' + res.data.end_date);
                } else {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                }
            });
        });
        // Xử lý cập nhật
        $('#updateBtn').click(function () {
            var id = $('#discount_id').val();
            $.ajax({
                url: "discount/update/" + id,
                method: "post",
                data: {
                    '_token': "{{csrf_token()}}",
                    'book_id': $('#update_book_id').val(),
                    'percent': $('#update_percent').val(),
                    'start_date': $('#update_start_date').val(),
                    'end_date': $('#update_end_date').val(),
                }
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide');
                    table.ajax.reload();
                } else {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                }
            }).fail(function (res) {
                $('#updateFormValidate').addClass('was-validated');
                $.each(res.responseJSON.errors, function (key, value) {
                    $('.update_' + key + '_error').text(value[0]);
                    $('.update_' + key + '_error').text(value[1]);
                    $('.update_' + key + '_error').text(value[2]);
                    $('.update_' + key + '_error').text(value[3]);
                });
            });
        });

        $('#modal-create').on('hidden.bs.modal', function () {
            $('#createFormValidate').removeClass('was-validated');
            $('.create_percent_error').text('');
            $('.create_book_id_error').text('');
            $('.create_start_date_error').text('');
            $('.create_end_date_error').text('');
        })

        $('#modal-edit').on('hidden.bs.modal', function () {
            $('#updateFormValidate').removeClass('was-validated');
            $('.update_percent_error').text('');
            $('.update_book_id_error').text('');
            $('.update_start_date_error').text('');
            $('.update_end_date_error').text('');
        })
    });
</script>
@endsection

@section('content')
<!-- Them -->
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm giảm giá</h4>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createFormValidate">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Sách</label>
                        <select id="store_book_id" class="form-control select2" data-placeholder="Chọn sách"
                            style="width: 100%;">
                            <option value="0" selected disabled>Chọn sách cần giảm giá</option>
                            @forelse($books as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="">Không có dữ liệu!</option>
                            @endforelse
                        </select>
                        <div class="text-danger create_book_id_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Phần trăm giảm giá</label required>
                        <input type='number' id="store_percent" class="form-control" />
                        <div class="text-danger create_percent_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu - Ngày kết thúc:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="date_range_store">
                            <input type="date" id="store_start_date" class="form-control" hidden>
                            <input type="date" id="store_end_date" class="form-control" hidden>
                            <div class="text-danger store_start_date_error"></div>
                            <div class="text-danger store_end_date_error"></div>
                        </div>
                    </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
            <button class="btn btn-primary" id="addBtn">Lưu</button>
        </div>

    </div>
</div>
</div>
<!-- Sua -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa giảm giá</h4>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" id="updateId" hidden>
            <form id="updateFormValidate">
                <div class="modal-body">
                    <input type="number" id='discount_id' hidden>
                    <div class="form-group">
                        <label>Sách</label>
                        <select id="update_book_id" class="form-control select2" data-placeholder="Chọn sách"
                            style="width: 100%;">
                            <option value="0" selected disabled>Chọn sách cần giảm giá</option>
                            @forelse($books as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="">Không có dữ liệu!</option>
                            @endforelse
                        </select>
                        <div class="text-danger update_book_id_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputProjectLeader">Phần trăm giảm giá</label required>
                        <input type='number' id="update_percent" class="form-control" />
                        <div class="text-danger update_percent_error"></div>
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu - Ngày kết thúc(Cũ)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" id="old_date_range" class="form-control float-right" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu - Ngày kết thúc(Mới):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="date_range_update">
                            <input type="date" id="update_start_date" class="form-control" hidden>
                            <input type="date" id="update_end_date" class="form-control" hidden>
                            <div class="text-danger update_start_date_error"></div>
                            <div class="text-danger update_end_date_error"></div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary" id="updateBtn">Lưu thay đổi</button>
            </div>

        </div>
    </div>
</div>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách sản phẩm giảm giá</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-create">
                        <i class="nav-icon fa fa-plus"></i> Thêm
                    </button>
                    <a href="" class="btn btn-warning">
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
                        <h3 class="card-title">Danh sách giảm giá</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Tên sách</td>
                                    <td>Giảm giá(%)</td>
                                    <td>Ngày bắt đầu</td>
                                    <td>Ngày kết thúc</td>
                                    <td>Thao tác</td>
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