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
    $("#supplier").val($("#supplier option:first").val());
    $("#book").val($("#book option:first").val());
    $("#quantity").val("");
    $("#export_unit_price").val("");
    $("#import_unit_price").val("");
}

function  productBuildTableRow(){
    let total=0;
    total = Number( $("#quantity").val()) * Number( $("#export_unit_price").val())
    var ret="<tr>" +
        "<td>" +`<input  name="book_id[]" value="${$("#book").find(':selected').val()}" type="hidden" /> `+ $("#book").find(':selected').text()+ "</td>" +
        
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
        "</tr>"
        return ret;
}

    let _row = null;
    _row = $(ctl).parents("tr");
    var cols = _row.children("td");

function productDisplay(ctl) {
     _row = $(ctl).parents("tr");
    var cols =_row.children("td");
    $("#su  pplier").val($(cols[0]).val());
    $("#book").val($(cols[1]).val());
    $("#quantity").val($(cols[2]).text());
    $("#import_unit_price").val($(cols[3]).text());
    $("#export_unit_price").val($(cols[4]).text());
    
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
    $("#book").focus();
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
                <form action="{{route('goods-received-note.store')}}" method="post">
                    @csrf
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
                    <input type="number" id="rq_supplier" name="supplier" hidden/>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
            </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection