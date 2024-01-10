@extends('layout')

@section('js')
<script>
    var count = 0;
    var total = 0;
    var price = 0;
    var book_id = [];
    $(document).ready(function () {
        $('.select2').select2();
        $('#showDetail').hide();
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: `<i class="fas fa-print"></i> In` },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('combo.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'price', render: $.fn.dataTable.render.number('.', 2, '') },
                { data: 'quantity', name: 'quantity' },
                {
                    data: 'image', render: function (data, type, row) {
                        if (data != null) {
                            return '<img src="' + data + '" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                        }
                        return "Không có ảnh";
                    }
                },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-info showDetail" value="' + data + '" data-toggle="modal" data-target="#modal-detail"><i class="nav-icon fa fa-eye"></i></button>'
                            + '<button class="btn btn-warning editBtn" value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                            + '<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteCombo" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                    }
                },
            ],
        });

        $('#myTable').on('click', '.showDetail', function () {
            var id = $(this).val();
            //alert(id);
            $.ajax({
                url: "combo/data-table-detail/" + id, method: "get", dataType: "json",
            }).done(function (res) {
                //console.log(res.data);
                res.data.map(item => {
                    $('#tableDetail').append(
                        `<tr> 
                            <td>${item.name}</td>
                            <td>${1}</td>
                        </tr>`);
                });
            })
        });
        //Xử lý đóng modal edit
        $('#modal-detail').on('hidden.bs.modal', function () {
            $('#tableDetail tbody').text('');
        });

        $('#myTable').on('click', '.editBtn', function () {
            var id = $(this).val();
            $.ajax({
                url: 'combo/edit/' + id,
                method: 'get',
            }).done(function (res) {
                if (res.success) {
                    total = res.combo.price;
                    $('#name').val(res.combo.name);
                    $('#supplier_id').val(res.combo.supplier_id);
                    $('#supplier_id').trigger('change');
                    $('#quantity').val(res.combo.quantity);
                    $('#combo_id').val(res.combo.id);
                    $('#discount_total').text("Tổng giá trị combo: " + res.combo.price + " đ");
                    res.books.map(item => {
                        $('#productTable tbody').append(
                            "<tr>" +
                            "<td>" + item.id + "</td>" +
                            "<td>" + `<input class="book_id" name="book_ids[]" value="${item.id}" type="hidden" /> ` + item.name + "</td>" +
                            "<td class='price' >" + item.unit_price + "</td>" +
                            `<input  class="total" value="${res.combo.price}" type="hidden"/>` +
                            "<td>" +
                            `<button type='button' class='btn btn-danger deleteBtn' key="${item.id}" value="${price}">` + `<i class="fas fa-trash"></i>`
                            + "Xóa" + "<span class='glyphicon glyphicon-remove' />" +
                            "</button>" +
                            "</td>" +
                            "</tr>"
                        );
                    })
                }
            });
        });
        
        //Hiển thị input nhập giảm giá
        $('#discount').change(function () {
            var id = $(this).find(':selected').val();
            if (id == 1) {
                $('#percent_group').attr("hidden", false);
                $('#price_group').attr("hidden", true);
            }
            if (id == 2) {
                $('#percent_group').attr("hidden", true);
                $('#price_group').attr("hidden", false);
            }
        });
        //reset dữ liệu sau khi update
        function reset() {
            $('#createFormValidate').removeClass('was-validated');
            $('#name').val('');
            $('#quantity').val('');
            $('#supplier_id').val($('#supplier_id option:first').val());
            $('#combo_info').attr("hidden", true);
            $('#discount').val($('#discount option:first').val());
            $('#percent_group').attr("hidden", true);
            $('#price_group').attr("hidden", true);
            $('#percent').val('');
            $('#price').val('');
            $('#image').val('');
            $('#productTable tbody tr').remove();
        }

        //reset modal-edit sau khi đóng
        $('#modal-edit').on('hidden.bs.modal', function () {
            reset();
        });

        //Hủy modal edit
        $('#cancelBtn').click(function () {
            Swal.fire({ 
                title: 'Bạn có muốn hủy cập nhật combo?',
                text: 'Tiến trình hiện tại của bạn sẽ bị xóa!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.value) {
                    $('#modal-edit').modal('hide');
                }
            });

        });

        //Xử lý lưu combo
        $('#saveBtn').click(function () {
            var id =  $('#combo_id').val();
            var discountTotal = total; //discountTotal lưu tổng tiền
            var reducedValue = 0; //reducedValue lưu giá trị giảm            
            if ($('#discount').val() === "1") { //nếu chọn giảm theo giá trị %
                reducedValue = $('#percent').val() + "%";
                var result = $('#percent').val() / 100;
                discountTotal -= (total * result);
            }
            if ($('#discount').val() === "2") {
                reducedValue = $('#price').val() + "đ";
                discountTotal -= ($('#price').val() * count);
            }
            total = discountTotal;
            var formData = new FormData();
            formData.append('_token', '{{csrf_token()}}');
            formData.append('image', $('#image')[0].files[0]);
            formData.append('name', $('#name').val());
            formData.append('price', total);
            formData.append('quantity', $('#quantity').val());
            formData.append('book_ids', book_id);
            formData.append('supplier_id', $('#supplier_id').val());
            $.ajax({
                method: 'post',
                url: 'combo/update/' + id,
                data: formData,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide');
                    table.ajax.reload();
                }else{
                    Swal.fire({ title: "Tạo combo không thành công", icon: 'error', confirmButtonText: 'OK' });
                }
            }).fail(function (res) {
                $('#createFormValidate').addClass('was-validated');
                $.each(res.responseJSON.errors, function (key, value) {
                    $('.create_' + key + '_error').text(value[0]);
                    $('.create_' + key + '_error').text(value[1]);
                    $('.create_' + key + '_error').text(value[2]);
                });
            });
        });
        //xử lý btn Xem sản phẩm trong combo
        $('#showBtn').click(function () {
            if ($('#name').val() === "") {
                Swal.fire({ title: "Cần nhập đầy đủ thông tin khuyến mãi!", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            //Tính toán nếu giá trị giảm
            var discountTotal = total; //discountTotal lưu tổng tiền
            var reducedValue = 0; //reducedValue lưu giá trị giảm
            if ($('#discount').val() === "1") { //nếu chọn giảm theo giá trị %
                reducedValue = $('#percent').val() + "%";
                var result = $('#percent').val() / 100;
                discountTotal -= (total * result);
            }
            if ($('#discount').val() === "2") {
                reducedValue = $('#price').val() + "đ";
                discountTotal -= ($('#price').val() * count);
            }
            //Hiển thị tổng quan combo sau khi tính toán và gán giá trị đã tính vào tổng quan
            $('#combo_info').attr("hidden", false);
            $('#show_combo_name').text($('#name').val());
            $('#show_combo_discount').text("Giảm " + reducedValue + " cho " + count + " sản phẩm");
            $('#discount_total').text("Tổng giá trị combo đã giảm giá: " + discountTotal + " đ");
            //Gán giá trị cho input trước khi gửi request về controller để xử lý thêm mới
            $('#combo_name').val($('#name').val());
            $('#combo_supplier_id').val($('#supplier_id').val());
            $('#combo_quantity').val($('#quantity').val());
        });

        $('#productTable').on('click', '.deleteBtn', function () {
            //Trừ tiền của sản phẩm vừa xóa khỏi tổng tiền
            console.log()
            total -= $(this).val();
            count -= 1;
            book_id = book_id.filter(item => item !== Number($(this).attr('key')));
            $('#total').val(total);
            $('#total').text("Tổng giá trị combo: " + total + " đ");
            $('#combo_total').val(total);
            $(this).closest('tr').remove();
        });
         //xử lý sự kiện click khi nhấn vào button xóa
         $('#myTable').on('click', '.deleteCombo', function(){
            var id = $(this).val();
             Swal.fire({ //Thông báo xác nhận trước khi xóa
                title: 'Bạn chắc chắn chứ?',
                text: 'Đừng lo, bạn vẫn có thể khôi phục lại dữ liệu đã xóa!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result)=>{
                //Nấu click button Đồng ý trên thông báo thì giá trị result sẽ là true va ngược lại
                if(result.value){
                    //Nếu giá trị là true thực hiện ajax xóa sách
                    $.ajax({
                        url: "combo/destroy/" + id,
                        method: "post",
                        data:{"_token" : "{{csrf_token()}}"}
                    }).done(function(res){
                        Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                        table.ajax.reload();
                    });
                }
            });
        });
    });
    //Hàm xử lý thêm dòng 1 sản phẩm vào table
    function addToTable() {
        if ($("#book_id").val() === null) {
            Swal.fire({ title: "Bạn chưa chọn sản phẩm", icon: 'error', confirmButtonText: 'OK' });
            return;
        }
        if ($('#productTable tbody').length === 0) {
            $("#productTable").append("<tbody></tbody>");
        }
        count += 1; //biến count đếm số lượng mỗi khi ble
        $('#combo_total').val(total);
        let id = $('#productTable tbody tr').length + 1;
        //Tính tổng tiền
        total += Number($('#book_id').find(':selected').attr('price'));
        price = Number(($('#book_id').find(':selected').attr('price')));
        book_id.push(Number($("#book_id").find(':selected').val()));

        $('#productTable tbody').append(
            "<tr>" +
            "<td>" + id + "</td>" +
            "<td>" + `<input class="book_id" name="book_ids[]" value="${$("#book_id").find(':selected').val()}" type="hidden" /> ` + $("#book_id").find(':selected').text() + "</td>" +
            "<td class='price1' >" + price + "</td>" +
            `<input  class="total" value="${total}" type="hidden"/>` +
            "<td>" +
            `<button type='button' class='btn btn-danger deleteBtn' key="${$("#book_id").find(':selected').val()}" value="${price}">` + `<i class="fas fa-trash"></i>`
            + "Xóa" + "<span class='glyphicon glyphicon-remove' />" +
            "</button>" +
            "</td>" +
            "</tr>"
        );
        $('#total').val(total);
        $('#total').text("Tổng giá trị combo: " + total + " đ");
        //reset select chọn sản phẩm
        $("#book_id").val($("#book_id option:first").val());
        $('#book_id').trigger('change');
    }   
</script>
@endsection

@section('content')
<div class="modal fade" id="modal-detail" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi tiết combo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tên sách</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="text" id="idDetail" hidden>

<section class="content-header">
    <div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa combo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Chọn sản phẩm</h3>
                                        </div>
                                        <div class="card-body">
                                            <input type="number" id="combo_id" hidden>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Chọn sản phẩm</label>
                                                <select id="book_id" name="name" class="form-control select2">
                                                    <option value=0 selected disabled>Chọn sản phẩm</option>
                                                    @foreach($books as $item)
                                                    <option value="{{$item->id}}" price="{{$item->unit_price}}">
                                                        {{$item->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button onclick="addToTable()" class="btn btn-primary">Thêm</button>
                                        </div>
                                    </div>
                                    <!-- general form elements -->
                                    <div class="card card-info" id="combo_info" hidden>
                                        <div class="card-header">
                                            <h3 class="card-title">Tổng quan combo</h3>
                                        </div>
                                        <div class="card-body">
                                            <h2 id="show_combo_name"></h2>
                                            <ul>
                                                <li id="show_combo_discount"></li>
                                                <li id="total"></li>
                                                <li id="discount_total"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông tin combo sách</h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="createFormValidate">
                                                <div class="form-group">
                                                    <label for="supplier_id">Nhà cung cấp</label>
                                                    <select id="supplier_id" name="name" class="form-control select2">
                                                        <option selected disabled value="0">Chọn nhà cung cấp</option>
                                                        @foreach($suppliers as $items)
                                                        <option value="{{$items->id}}">{{$items->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger create_supplier_id_error"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Tên combo</label>
                                                    <input type="text" id="name" class="form-control"
                                                        placeholder="Tên combo">
                                                    <div class="text-danger create_name_error"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputStatus">Số lượng</label>
                                                    <input type="number" id="quantity" class="form-control"
                                                        placeholder="Số lượng combo">
                                                    <div class="text-danger create_quantity_error"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputStatus">Giảm giá theo</label>
                                                    <select id="discount" class="form-control custom-select">
                                                        <option selected disabled>Select one</option>
                                                        <option value="1">Phần trăm mỗi sản phẩm</option>
                                                        <option value="2">Giá trị giảm giá toàn bộ combo</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="percent_group" hidden>
                                                    <label for="inputStatus">Giá trị khuyến mãi</label>
                                                    <input type="number" id="percent" class="form-control"
                                                        placeholder="Theo %" required>
                                                </div>
                                                <div class="form-group" id="price_group" hidden>
                                                    <label for="inputStatus">Giá trị khuyến mãi</label>
                                                    <input type="number" id="price" class="form-control"
                                                        placeholder="Theo giá tiền" required>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="card-footer">
                                            <button id="showBtn" class="btn btn-primary">Xem combo</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12  ">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Danh sách sản phẩm</h3>
                                                    </div>


                                                    <div class="card-body">
                                                        <table id="productTable"
                                                            class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Tên sản phẩm</th>
                                                                    <th>Giá</th>
                                                                    <th>Thao tác</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <input type="text" name="name" id="combo_name" hidden />
                                                        <input type="number" name="quantity" id="combo_quantity"
                                                            hidden />
                                                        <input type="number" name="price" id="combo_price" hidden />
                                                        <input type="number" name="supplier_id" id="combo_supplier_id"
                                                            hidden />
                                                        <div class="card-footer">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="storeImage">Ảnh</label>
                                                            <div class="custom-file">
                                                                <input type="file" name="image" accept="image/*"
                                                                    id="image" class="custom-file-input">
                                                                <label class="custom-file-label" for="customFile">Chọn
                                                                    ảnh</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="cancelBtn"
                                                            class="btn btn-secondary mt-3">Hủy</button>
                                                        <button type="submit" id="saveBtn"
                                                            class="btn btn-primary mt-3">Lưu combo</button>

                                                    </div>
                                                </div>
                                            </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách Combo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a type="button" href="{{route('combo.create')}}" class="btn btn-success">
                        <i class="nav-icon fas fa-edit"></i> Thêm Combo
                    </a>
                    <a href="{{route('combo.trash')}}" class="btn btn-warning ml-2">
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
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Tổng tiền</th>
                                    <th>Số lượng</th>
                                    <th>Ảnh</th>
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