@extends('layout')

@section('js')
<script>
    var count = 0;
    $(document).ready(function () {
        $('.select2').select2();
        //Hiển thị input nhập giảm giá
        $('#discount').change(function(){
            var id = $(this).find(':selected').val();
            if(id == 1){
                $('#percent_group').attr("hidden", false);
                $('#price_group').attr("hidden", true);
            }
            if(id == 2){
                $('#percent_group').attr("hidden", true);
                $('#price_group').attr("hidden", false);
            }
        });

        $('#showBtn').click(function(){
            if($('#name').val() === null && $('#quantity').val() === null && $('#percent').val() === null){
                Swal.fire({ title: "Cần nhập đầy đủ thông tin khuyến mãi!", icon: 'error', confirmButtonText: 'OK' });
                return;
            }
            //Hiển thị tổng quan combo
            let discount_total = total - (Number($('#price').val()) * count);
            $('#combo_info').attr("hidden", false);
            $('#show_combo_name').text($('#name').val());
            $('#show_combo_discount').text("Giảm " + $('#price').val() + " đ cho " + count + " sản phẩm");
            
            $('#discount_total').text("Tổng giá trị combo sau giảm giá: " + discount_total + " đ");
            //Gán giá trị cho input request
            $('#combo_name').val($('#name').val());
            $('#combo_quantity').val($('#quantity').val());
            $('#combo_percent').val($('#price').val());
        });
    });

    var total = 0;
    var price = 0;
    function addToTable(){
        count += 1;
        if($("#book_id").val() === null){
            Swal.fire({ title: "Chưa chọn sản phẩm", icon: 'error', confirmButtonText: 'OK' });
            return;
        }
        if($('#productTable tbody').length === 0){
            $("#productTable").append("<tbody></tbody>");
        }
        $('#combo_name').val($('#name').val());
        $('#combo_quantity').val($('#quantity').val());
        $('#combo_total').val(total);
        let id = $('#productTable tbody tr').length + 1;
        //Tính tổng tiền
        total += Number($('#book_id').find(':selected').attr('price'));
        price = Number(($('#book_id').find(':selected').attr('price'))); 

        $('#productTable tbody').append(
            "<tr>" +
                "<td>" + id + "</td>" +
                "<td>" + `<input class="book_id" name="book_id[]" value="${$("#book_id").find(':selected').val()}" type="hidden" /> `+ $("#book_id").find(':selected').text() + "</td>" +
                "<td class='price1' >" + price + "</td>" +
                `<input  class="total" value="${total}" type="hidden"/>`  +
                "<td>" +
                `<button type='button' onclick='productDelete(this)' class='btn btn-danger deleteBtn' value="${price}">` + `<i class="fas fa-trash"></i>` 
                    +"Xóa" +"<span class='glyphicon glyphicon-remove' />" +
                "</button>" +
                "</td>" +
            "</tr>"     
        );
        $('#total').val(total);
        $('#total').text("Tổng giá trị combo: " + total + " đ");
        $('#combo_total').val(total);
        $("#book_id").val($("#book_id option:first").val());
        console.log(document.getElementsByClassName("deleteBtn")[0].val);
        
    }   

    function add(accumulator, a) {
        return accumulator +  a;
    }

    function productDelete(ctl) {
        //Trừ tiền của sản phẩm vừa xóa khỏi tổng tiền
        total -= Number($('.deleteBtn').val());
        $('#total').val(total);
        $('#total').text("Tổng giá trị combo: " + total + " đ");    
        $('#combo_total').val(total);
        $(ctl).parents("tr").remove();  
    }
</script>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
             <!-- left column -->
             <div class="col-md-6">
                <!-- general form elements -->
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
    
                
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Khuyến mãi</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tên combo</label>
                            <input type="text" id="name" class="form-control" placeholder="Tên combo" required>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Số lượng</label>
                            <input type="number" id="quantity" class="form-control" placeholder="Số lượng combo" required>
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
                            <input type="number" id="price" class="form-control" placeholder="Theo giá tiền" required>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button id="showBtn" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
            <!--/.col (left) -->
             
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12  ">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách sản phẩm</h3>
                                </div>
                                <form action="" method="post">
                                    @csrf
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
                                        <input type="text" name="name" id="combo_name"  />
                                        <input type="number" name="quantity" id="combo_quantity"  />
                                        <input type="number" name="price" id="combo_total"  />
                                        <input type="number" name="percent" id="combo_percent"  />
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Lưu combo</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
</section>
@endsection