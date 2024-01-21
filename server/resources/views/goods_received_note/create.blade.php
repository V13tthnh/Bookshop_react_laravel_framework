@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('#supplier').change(function () {
            $('#rq_supplier').val(this.value);
        });
        //set cost_price
        $('#book').change(function () {
            var price = $(this).find(":selected").attr("price");
            $('#export_unit_price').val(price);
        });

        // Increment next ID to use
        function formClear() {
            $("#book").val($("#book option:first").val());
            $('#book').trigger('change');
            $("#quantity").val('');
            $("#export_unit_price").val('');
            $("#import_unit_price").val('');
            $("#formality").val($("#formality option:first").val());
            $(".create_book_id_error").text('');
            $(".create_supplier_id_error").text('');
            $(".create_quantity_error").text('');
            $(".create_import_unit_price_error").text('');
            $(".create_export_unit_price_error").text('');
            $(".create_range_error_error ul").text('');

        }

        function addToTableProduct() {
            // First check if a <tbody> tag exists, add one if not
            if ($("#myTable tbody").length == 0) {
                $("#myTable").append("<tbody></tbody>");
                //$("#table tbody").append(productBuildTableRow(_nextId));
            }
            let total = 0;
            total = Number($("#quantity").val()) * Number($("#import_unit_price").val());
            let id = $('#myTable tbody tr').length + 1;
            // Append product to the table
            $("#myTable tbody").append(
                "<tr>" +
                "<td>" + id + "</td>" +
                "<td hidden>" + $("#book").find(':selected').val() + "</td>" +
                "<td>" + `<input class="book_id"  name="book_id[]" value="${$("#book").find(':selected').val()}" type="hidden" /> ` + $("#book").find(':selected').text() + "</td>" +
                "<td>" + `<input class="quantity" name="quantity[]" value="${$("#quantity").val()}" type="hidden" /> ` + $("#quantity").val() + "</td>" +
                "<td>" + `<input class="import_unit_price" name="import_unit_price[]" value="${$("#import_unit_price").val()}" type="hidden" /> ` + $("#import_unit_price").val() + "</td>" +
                "<td>" + `<input class="export_unit_price"  name="export_unit_price[]" value="${$("#export_unit_price").val()}" type="hidden" /> ` + $("#export_unit_price").val() + "</td>" +
                "<td>" + `<input class="total" name="total[]" value="${total}" type="hidden"/> ` + total + "</td>" +
                "<td>" +
                "<button type='button' class='btn btn-danger productDelete'>" + `<i class="fas fa-trash"></i>` + " Xóa" +
                "<span class='glyphicon glyphicon-remove' />" +
                "</button>" +
                "<button type='button' id='display_" + id + "' class='btn btn-info productDisplay'>" + `<i class="fas fa-edit"></i>` + "Sửa" +
                "<span class='glyphicon glyphicon-edit' />" +
                "</button>" +
                "</td>" +
                "</tr>");
            formClear();
        }

        function updateToTableProduct(id) {
            var _row = $('#display_' + id).parents('tr');
            //console.log($('#display_' + id).after('tr'));
            $(_row).after(productBuildTableRow(id));
            // // Remove old product rows
            $(_row).remove();
            // // Clear form fields                
            $("#addButton").text("Thêm");
            formClear();
        }

        //Thêm sản phẩm vào bảng danh sách
        $('#addButton').click(function () {
            if ($('#supplier').find(':selected').val() === "0") {
                Swal.fire({ title: "Chưa chọn nhà cung cấp", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            if ($('#book').find(':selected').val() === "0") {
                Swal.fire({ title: "Chưa chọn sản phẩm", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            if ($('#quantity').val() === '') {
                Swal.fire({ title: "Chưa nhập số lượng", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            if ($('#import_unit_price').val() === '') {
                Swal.fire({ title: "Chưa nhập giá nhập", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            if ($('#export_unit_price').val() === '') {
                Swal.fire({ title: "Chưa nhập giá bán", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            if ($(this).text() === "Thêm") {
                addToTableProduct();
            }
            if ($(this).text() === "Cập nhật") {
                var id = $(this).val();
                updateToTableProduct(id);
            }
        });

        $('#myTable tbody').on('click', '.productDelete', function () {
            $(this).parents("tr").remove();
        });
        //Hiển thị thông tin dòng vừa chọn để sửa lên phiếu nhập
        $('#myTable tbody').on('click', '.productDisplay', function () {
            var _row = $(this).parents("tr");
            var cols = _row.children("td");
            var id = Number($(cols[0]).text())
            //Gán lại giá trị cho các trường bên phiếu nhập
            $("#book").val(Number($(cols[1]).text()));
            $("#book").trigger('change');
            $("#quantity").val(Number($(cols[3]).text()));
            $("#import_unit_price").val(Number($(cols[4]).text()));
            $("#export_unit_price").val(Number($(cols[5]).text()));
            //Đổi text button sang cập nhật
            $('#addButton').val(id);
            $('#addButton').text("Cập nhật");
        });

        function productBuildTableRow(id) {
            let total = 0;
            total = Number($("#quantity").val()) * Number($("#import_unit_price").val())
            var ret = "<tr>" +
                "<td>" + id + "</td>" +
                "<td hidden>" + $("#book").find(':selected').val() + "</td>" +
                "<td>" + `<input class="book_id"  name="book_id[]" value="${$("#book").find(':selected').val()}" type="hidden" /> ` + $("#book").find(':selected').text() + "</td>" +
                "<td>" + `<input class="quantity" name="quantity[]" value="${$("#quantity").val()}" type="hidden" /> ` + $("#quantity").val() + "</td>" +
                "<td>" + `<input class="import_unit_price" name="import_unit_price[]" value="${$("#import_unit_price").val()}" type="hidden" /> ` + $("#import_unit_price").val() + "</td>" +
                "<td>" + `<input class="export_unit_price"  name="export_unit_price[]" value="${$("#export_unit_price").val()}" type="hidden" /> ` + $("#export_unit_price").val() + "</td>" +
                "<td>" + `<input class="total" name="total[]" value="${total}" type="hidden"/> ` + total + "</td>" +
                "<td>" +
                "<button type='button' class='btn btn-danger productDelete'>" + `<i class="fas fa-trash"></i>` + " Xóa" +
                "<span class='glyphicon glyphicon-remove' />" +
                "</button>" +
                "<button type='button' id='display_" + id + "' class='btn btn-info productDisplay'>" + `<i class="fas fa-edit"></i>` + "Sửa" +
                "<span class='glyphicon glyphicon-edit' />" +
                "</button>" +
                "</td>" +
                "</tr>"
            return ret;
        }
        //Thêm phiếu nhập
        $('#addFormCreate').click(function (e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('_token', "{{csrf_token()}}");
            formData.append('supplier_id', $('#supplier').val());
            formData.append('formality', $('#formality').val());
            // Lặp qua từng hàng trong tbody
            $('#myTable tbody tr').each(function () {
                // Lấy giá trị từ ô input trong cột 'Name'
                var bookIdValue = $(this).find('td:eq(2) input').val();
                var quantityValue = $(this).find('td:eq(3) input').val();
                var importUnitPriceValue = $(this).find('td:eq(4) input').val();
                var exportUnitPriceValue = $(this).find('td:eq(5) input').val();
                var totalValue = $(this).find('td:eq(6) input').val();
                // Thêm giá trị vào FormData
                formData.append('book_id[]', bookIdValue);
                formData.append('quantity[]', quantityValue);
                formData.append('import_unit_price[]', importUnitPriceValue);
                formData.append('export_unit_price[]', exportUnitPriceValue);
                formData.append('total[]', totalValue);
            });

            $.ajax({
                url: "{{route('goods-received-note.store')}}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $("#supplier").val($("#supplier option:first").val());
                    $('#supplier').trigger('change');
                    $("#myTable tbody").remove();
                }
                if (!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            }).fail(function (res) {
                console.log(res.responseJSON.errors);
                $.each(res.responseJSON.errors, function (key, value) {  //Duyệt mảng errors và gán các giá trị lỗi phía dưới các trường input
                    $('.create_' + key + '_error').text(value[0]);
                    $('.create_' + key + '_error').text(value[1]);
                    $('.create_' + key + '_error').text(value[2]);
                    $('.create_' + key + '_error').text(value[3]);
                    $('.create_' + key + '_error').text(value[4]);
                    $('.create_' + key + '_error').text(value[5]);

                    $('.create_range_error_error ul').append('<li>'+value+'</li>');
                });
            });
            formClear();
        });
    });
</script>
@endsection

@section('content')
<!-- Import File Excel -->
<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nhập hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Chọn nhà cung cấp</label>
                        <select name="name" class="form-control select2" style="width: 100%;">
                            <option selected disabled value="0">Chọn nhà cung cấp</option>
                            @foreach($listSupplier as $items)
                            <option value="{{$items->id}}">{{$items->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Chọn hình thức thanh toán</label>
                        <select name="formality" class="form-control custom-select">
                            <option selected disabled value="0">Hình thức thanh toán</option>
                            <option value="Chuyển khoản">Chuyển khoản</option>
                            <option value="Tiền mặt">Tiền mặt</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Chọn file excel sản phẩm</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file_excel" accept=".xls, .xlsx" class="custom-file-input">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                <div class="text-danger create_avatar_error"></div>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Nhập hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nhập hàng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modal-import">
                        <i class="nav-icon fa fa-plus"></i> Import
                    </button>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Phiếu nhập</h3>
                    </div>
                    <div class="card-body">
                    <div class="text-danger create_range_error_error"><ul></ul></div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nhà cung cấp</label>
                            <select id="supplier" name="name" class="form-control select2">
                                <option selected disabled value="0">Chọn nhà cung cấp</option>
                                @foreach($listSupplier as $items)
                                <option value="{{$items->id}}">{{$items->name}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger create_supplier_id_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Sách</label>
                            <select id="book" name="name" class="form-control select2">
                                <option selected disabled value="0">Chọn sản phẩm</option>
                                @foreach($listbook as $items)
                                <option value="{{$items->id}}" price="{{$items->unit_price}}">{{$items->name}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger create_book_id_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng</label>
                            <input type="number" min="1" id="quantity" class="form-control" placeholder="Số lượng"
                                required>
                            <div class="text-danger create_quantity_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Giá nhập</label>
                            <input type="number" id="import_unit_price" class="form-control" placeholder="Giá nhập"
                                required>
                            <div class="text-danger create_import_unit_price_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Giá bán</label>
                            <input type="number" id="export_unit_price" class="form-control" placeholder="Giá bán"
                                required>
                            <div class="text-danger create_export_unit_price_error"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="addButton" class="btn btn-primary" value="">Thêm</button>
                    </div>
                </div>
            </div>

            <div class="col-md-8    ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12  ">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách sản phẩm</h3>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>

                                                <th>Id</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Giá nhập</th>
                                                <th>Giá bán</th>
                                                <th>Tổng tiền</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <input type="number" id="rq_supplier" name="supplier" hidden />
                                    <div class="card-footer">
                                        <select id="formality" name="formality" class="form-control custom-select">
                                            <option selected disabled value="0">Hình thức thanh toán</option>
                                            <option value="Chuyển khoản">Chuyển khoản</option>
                                            <option value="Tiền mặt">Tiền mặt</option>
                                        </select>
                                        <div class="text-danger create_formality_error"></div>
                                    </div>
                                    <button id="addFormCreate" class="btn btn-primary mt-3">Lưu</button>
                                </div>
                            </div>
                        </div>
</section>
@endsection