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
    
    $(document).ready(function () {
        $('#supplier').change(function(){
            $('#rq_supplier').val(this.value);
        });
    });

    function productAddToTable() {
        // First check if a <tbody> tag exists, add one if not
        if ($("#example1 tbody").length == 0) {
            $("#example1").append("<tbody></tbody>");
            //$("#table tbody").append(productBuildTableRow(_nextId));
        }

        let total=0;
        total= Number( $("#quantity").val()) * Number( $("#export_unit_price").val());
        let id = $('#example1 tbody tr').length + 1;
        // Increment next ID to use
        
        // Append product to the table
        $("#example1 tbody").append(
            "<tr>" +
                "<td>" + id + "</td>" +
                "<td>" + `<input  name="book_id[]" value="${$("#book").find(':selected').val()}" type="hidden" /> `+ $("#book").find(':selected').text() + "</td>" +
                "<td>" + `<input name="quantity[]" value="${$("#quantity").val()}" type="hidden" /> `+ $("#quantity").val() + "</td>" +
                "<td>" + `<input  name="import_unit_price[]" value="${$("#import_unit_price").val()}" type="hidden" /> `+ $("#import_unit_price").val() + "</td>" +
                "<td>" + `<input  name="export_unit_price[]" value="${$("#export_unit_price").val()}" type="hidden" /> `+ $("#export_unit_price").val() + "</td>" +
                "<td>" + `<input  name="total[]" value="${total}" type="hidden"/> `+ total + "</td>" +
                "<td>" +
                "<button type='button' onclick='productDelete(this)'class='btn btn-default'>" + "Xóa" +
                    "<span class='glyphicon glyphicon-remove' />" +
                "</button>" +
            
                "<button type='button' onclick='productDisplay(this);' class='btn btn-default'>" +"Sửa"+
                    "<span class='glyphicon glyphicon-edit' />" +
                "</button>" +
                "</td>" +
            "</tr>");   

            formClear();
    }

function productDelete(ctl) {
    $(ctl).parents("tr").remove();  
}

function formClear() {
    $("#supplier").find("option:first-child");
    $("#book").find("option:first-child");
    $("#quantity").val("");
    $("#export_unit_price").val("");
    $("#import_unit_price").val("");
}

function  productBuildTableRow(id){
    let tt=0;
    tt = Number( $("#sl").val()) * Number( $("#gb").val())
    var ret="<tr>" +
        "<td>" +`<input type="text" name="san_pham_id[]" value="${$("#book").val()}" /> ` + $("#sp").val() + "</td>" +
        "<td>" + `<input type="text" name="so_luong[]" value="${$("#sl").val()}" /> `+ $("#sl").val() + "</td>" +
        "<td>" + `<input type="text" name="gia_nhap[]" value="${$("#gn").val()}" /> `+ $("#gn").val() + "</td>" +
        "<td>" + `<input type="text" name="gia_ban[]" value="${$("#gb").val()}" /> `+ $("#gb").val() + "</td>" +
        "<td>" + `<input type="number" name="tong_tien[]" value="${tt}" /> `+tt + "</td>" +
        "<td>" +
        "<button type='button' onclick='productDelete(this)'class='btn btn-default'>" + "Xóa" +
        "<span class='glyphicon glyphicon-remove' />" +
        "</button>" +
       
        "<button type='button' onclick='productDisplay(this);' class='btn btn-default'>" +"Sửa"+
        "<span class='glyphicon glyphicon-edit' />" +
        "</button>" +
        "</td>" +
        "</tr>"
        return ret;
}

    var _row = null;
    _row = $(ctl).parents("tr");
    var cols = _row.children("td");

function productDisplay(ctl) {
    _row = $(ctl).parents("tr");
    var cols =_row.children("td");
    $("#sp").val($(cols[0]).text());
    $("#sl").val($(cols[1]).text());
    $("#gn").val($(cols[2]).text());
    $("#gb").val($(cols[3]).text());
    
    // Change Update Button Text
    $("#updateButton").text("Update");
}


function productUpdate() {
    if ($("#updateButton").text() == "Update") {
        productUpdateInTable();
    }
    else {
        productAddToTable();
    }
    
    // Clear form fields
    formClear();
    
    // Focus to product name field
    $("#sp").focus();
}

    
function productUpdateInTable() {
    // Add changed product to table
    $(_row).after(productBuildTableRow());  
    
    // Remove old product row
    $(_row).remove();
    
    // Clear form fields
    formClear();
    
    // Change Update Button Text
    $("#updateButton").text("Add");
}

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
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Phiếu nhập</h3>
              </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nhà xuất bản</label>
                    <select id="supplier" name="name" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            @foreach($listSupplier as $items)
                                <option value="{{$items->id}}">{{$items->name}}</option>
                            @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Sản phẩm</label>
                    <select id="book" name="name" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            @foreach($listbook as $items)
                                <option value="{{$items->id}}">{{$items->name}}</option>
                            @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Số lượng</label>
                    <input type="number" id="quantity" class="form-control" placeholder="Số lượng" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Giá nhập</label>
                    <input type="number" id="import_unit_price" class="form-control" placeholder="Giá nhập" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Giá bán</label>
                    <input type="number" id="export_unit_price" class="form-control" placeholder="Giá bán" required>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button onclick="productAddToTable()" class="btn btn-primary">Thêm</button>
                </div>
            </div>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
    <div class="col-md-8    ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12  ">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách sản phẩm</h3>
                    </div>
                <form action="">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
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
                    <input type="number" id="rq_supplier" hidden/>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
            </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection