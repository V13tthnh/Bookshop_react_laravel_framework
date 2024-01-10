@extends('layout')

@section('js')
<script>
    var count = 0;
    var total = 0;
    var price = 0;
    var book_id = [];
    $(document).ready(function () {
        $('.select2').select2();
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

        function reset() {
            $('#createFormValidate').removeClass('was-validated');
            $('#name').val('');
            $('#quantity').val('');
            $('#supplier_id').val($('#supplier_id option:first').val());
            $('#productTable tbody').remove();
            $('#combo_info').attr("hidden", true);
            $('#discount').val($('#discount option:first').val());
            $('#percent_group').attr("hidden", true);
            $('#price_group').attr("hidden", true);
            $('#percent').val('');
            $('#price').val('');
            $('#image').val('');
        }

        $('#cancelBtn').click(function () {
            Swal.fire({ //Thông báo xác nhận trước khi xóa
                title: 'Bạn có muốn hủy tạo combo?',
                text: 'Tiến trình hiện tại của bạn sẽ bị xóa!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                //Nấu click button Đồng ý trên thông báo thì giá trị result sẽ là true va ngược lại
                if (result.value) {
                    reset();
                }
            });

        });

        //Xử lý lưu combo
        $('#saveBtn').click(function () {
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
                url: '{{route('combo.store')}}',
                data: formData,
                contentType: false,
                processData: false,
            }).done(function (res) {
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    reset();
                }else{
                    Swal.fire({ title: "Tạo combo không thành công!", icon: 'error', confirmButtonText: 'OK' });
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
        //console.log(document.getElementsByClassName("deleteBtn")[0].val);
    }   
</script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tạo combo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Tạo combo</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Chọn sản phẩm</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn sản phẩm</label>
                            <select id="book_id" name="name" class="form-control select2">
                                <option value=0 selected disabled>Chọn sản phẩm</option>
                                @foreach($books as $item)
                                <option value="{{$item->id}}" price="{{$item->unit_price}}">{{$item->name}}</option>
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
                                <input type="text" id="name" class="form-control" placeholder="Tên combo">
                                <div class="text-danger create_name_error"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Số lượng</label>
                                <input type="number" id="quantity" class="form-control" placeholder="Số lượng combo">
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
                                <input type="number" id="percent" class="form-control" placeholder="Theo %" required>
                            </div>
                            <div class="form-group" id="price_group" hidden>
                                <label for="inputStatus">Giá trị khuyến mãi</label>
                                <input type="number" id="price" class="form-control" placeholder="Theo giá tiền"
                                    required>
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
                                    <table id="productTable" class="table table-bordered table-striped">
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
                                    <input type="number" name="quantity" id="combo_quantity" hidden />
                                    <input type="number" name="price" id="combo_price" hidden />
                                    <input type="number" name="supplier_id" id="combo_supplier_id" hidden />
                                    <div class="card-footer">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeImage">Ảnh</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" accept="image/*" id="image"
                                                class="custom-file-input">
                                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                        </div>
                                    </div>
                                    <button type="submit" id="cancelBtn" class="btn btn-secondary mt-3">Hủy</button>
                                    <button type="submit" id="saveBtn" class="btn btn-primary mt-3">Lưu combo</button>

                                </div>
                            </div>
                        </div>
</section>
@endsection