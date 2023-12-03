@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        $(function () {
            // Summernote
            $('#storeDescription').summernote();
            $('#updateDescription').summernote()
        });
        // $('.select2').select2();
        //book datatable
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: "In" },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('book.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'unit_price', name: 'unit_price' },
                { data: 'quantity', name: 'quantity' },
                { data: 'publisher_name', name: 'publisher.name' },
                { data: 'author_name', name: 'author.name' },
                { data: 'image_list', render: function(data, type, row){
                    if(data != null){
                        return '<img src="' + data[0]?.front_cover + '" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                    }
                    return "Không có ảnh";
                     
                } },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning editBtn  " value="' + data + '" data-toggle="modal" data-target="#modal-edit"><i class="nav-icon fa fa-edit"></i></button>'
                            + '<div class="btn-group btn-group-toggle"><button class="btn btn-danger deleteBtn" value="' + data + '"><i class="nav-icon fa fa-trash"></i></button></div>'
                    }
                },
            ],
        });

   

        //clear create form
        function createFormClear(){
            $('#storeName').val(''); $('#storeYear').val(''); $('#storeSize').val('');
            $('#storeCode').val('');  $('#storeLanguage').val(''); $('#storeNumPages').val('');
            $('#storeTranslator').val('');  $('#storeWeight').val(''); $('#storeFormat').val('');
            $("#storePublisherId").val($("#storePublisherId option:first").val());
            $("#storeCategoryId").val($("#storeCategoryId option:first").val());
            $("#storeAuthorId").val($("#storeAuthorId option:first").val());
            $('#storeDescription').summernote('code', "");
        }

        //store
        $('#addBtn').click(function () {
            var formData = new FormData();
            var files = $('#storeImages')[0].files;
            for (var i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }
            formData.append("_token", "{{csrf_token()}}");
            formData.append("name", $('#storeName').val());
            formData.append("code", $('#storeCode').val());
            formData.append("translator", $('#storeTranslator').val());
            formData.append("year", $('#storeYear').val());
            formData.append("language", $('#storeLanguage').val());
            formData.append("weight", $('#storeWeight').val());
            formData.append("size", $('#storeSize').val());
            formData.append("num_pages", $('#storeNumPages').val());
            formData.append("format", $('#storeFormat').val());
            formData.append("publisher_id", $('#storePublisherId').val());
            formData.append("category_id", $('#storeCategoryId').val());
            formData.append("author_id", $('#storeAuthorId').val());
            formData.append("description", $('#storeDescription').val());
            $.ajax({
                url: "{{route('book.store')}}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-create').modal('hide'); //ẩn model thêm mới
                    createFormClear(); //clear dữ liệu input sau khi thêm thành công
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            });
        });
        
        //edit
        $('#myTable').on('click', '.editBtn', function(){
            var id = $(this).val();
            $.ajax({
                url: "book/edit/" + id,
                method: "get",
            }).done(function(res){
                //Duyệt ảnh 
                for(let i = 0; i < res.data.image_list.length; i++){
                    //Thêm dòng vào table listFile
                    $('#listFile').append(`<tr class="data"> 
                                        <td style="font-size:12px">${res.data.image_list[i].front_cover}</td>
                                        <td><img src="${res.data.image_list[i].front_cover}" sizes="40" srcset="" style="height:70px;width:70px"/></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <button href="#" value="${res.data.image_list[i].id}" class="btn btn-danger deleteImgBtn"><i
                                                    class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>`);
                }
                
                $('#updateName').val(res.data.name); $('#updateCode').val(res.data.code); 
                $('#updateTranslator').val(res.data.translator); $('#updateYear').val(res.data.year);
                $('#updateLanguage').val(res.data.language); $('#updateWeight').val(res.data.weight);
                $('#updateSize').val(res.data.size); $('#updateNumPages').val(res.data.num_pages); 
                $('#updateFormat').val(res.data.format); $('#updatePublisherId').val(res.data.publisher_id); 
                $('#updateCategoryId').val(res.data.category_id); $('#updateAuthorId').val(res.data.author_id);
                $('#updateDescription').summernote('code', res.data.description); $('#updateId').val(res.data.id)
            });
        });
        //Khi nhấn tắt modal edit thì reset data trong table listFile
        $('.btnCancel').click(function(){
            $('.data').remove();
        });
        //xóa ảnh trong table listFile
        $('#listFile').on('click', '.deleteImgBtn', function(){
            var id = $(this).val();
            $.ajax({
                url: "book/delete-image/" + id,
                method: "get",
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                }
            });
        });
        //update
        $('#updateBtn').click(function(){
            var id = $('#updateId').val();
            var formData = new FormData();
            var files = $('#updateImages')[0].files;
            for (var i = 0; i < files.length; i++) {
                formData.append('updateImages[]', files[i]);
            }
            formData.append("_token", "{{csrf_token()}}");
            formData.append("name", $('#updateName').val());
            formData.append("code", $('#updateCode').val());
            formData.append("translator", $('#updateTranslator').val());
            formData.append("year", $('#updateYear').val());
            formData.append("language", $('#updateLanguage').val());
            formData.append("weight", $('#updateWeight').val());
            formData.append("size", $('#updateSize').val());
            formData.append("num_pages", $('#updateNumPages').val());
            formData.append("format", $('#updateFormat').val());
            formData.append("publisher_id", $('#updatePublisherId').val());
            formData.append("category_id", $('#updateCategoryId').val());
            formData.append("author_id", $('#updateAuthorId').val());
            formData.append("description", $('#updateDescription').val());
            $.ajax({
                url: "book/update/" + id,
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide'); //ẩn model thêm mới
                    $('.data').remove();
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            });
        });
    });
</script>
@endsection

@section('content')

<!-- Them sach xl-->
<div class="modal fade" id="modal-create" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm sách</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin sách</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="storeName">Tên</label>
                                        <input type="text" id="storeName" class="form-control" placeholder="Tên sách">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeCode">Mã hàng</label>
                                        <input type="text" id="storeCode" class="form-control" placeholder="Mã hàng">
                                    </div>

                                    <div class="form-group">
                                        <label for="storeTranslator">Người dịch</label>
                                        <input type="text" id="storeTranslator" class="form-control"
                                            placeholder="Người dịch">
                                    </div>

                                    <div class="form-group">
                                        <label for="storeYear">Năm xuất bản</label>
                                        <input type="number" id="storeYear" class="form-control"
                                            placeholder="Năm xuất bản">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeLanguage">Ngôn ngữ</label>
                                        <input type="text" id="storeLanguage" class="form-control"
                                            placeholder="Ngôn ngữ">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeWeight">Trọng lượng</label>
                                        <input type="number" id="storeWeight" class="form-control"
                                            placeholder="Trọng lượng">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeSize">kích thước</label>
                                        <input type="text" id="storeSize" class="form-control" placeholder="kích thước">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeNumPages">Số trang</label>
                                        <input type="number" id="storeNumPages" class="form-control"
                                            placeholder="Số trang">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeFormat">Hình thức</label>
                                        <input type="text" id="storeFormat" class="form-control"
                                            placeholder="Hình thức">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Mô tả</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nhà xuất bản</label>
                                        <select class="form-control select2" id="storePublisherId" style="width: 100%;">
                                            <option selected="selected" value="null" disabled>Select one</option>
                                            @forelse($listPublisher as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="null">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeCategory">Thể loại</label>
                                        <select class="form-control select2" id="storeCategoryId" style="width: 100%;">
                                            <option selected="selected" value="null" disabled>Select one</option>
                                            @forelse($listCategory as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="null">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeAuthor">Tác giả</label>
                                        <select class="form-control select2" id="storeAuthorId" style="width: 100%;">
                                            <option selected="selected" value="null" disabled>Select one</option>
                                            @forelse($listAuthor as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="null">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">Mô tả</label>
                                        <textarea id="storeDescription" type="text" name="description"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Ảnh sản phẩm</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="storeImage">Ảnh</label>

                                        <div class="custom-file">
                                        <input type="file" accept="image/*" id="storeImages" class="custom-file-input" multiple>
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <input type="submit" id="addBtn" value="Lưu thông tin" class="btn btn-success float-right">
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Sua sach xl-->
<div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa sách</h4>
                <button type="button" class="close btnCancel" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin sách</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool " data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                <input type="text" id="updateId" class="form-control" hidden>
                                    <div class="form-group">
                                        <label for="storeName">Tên</label>
                                        <input type="text" id="updateName" class="form-control" placeholder="Tên sách">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeCode">Mã hàng</label>
                                        <input type="text" id="updateCode" class="form-control" placeholder="Mã hàng">
                                    </div>

                                    <div class="form-group">
                                        <label for="storeTranslator">Người dịch</label>
                                        <input type="text" id="updateTranslator" class="form-control"
                                            placeholder="Người dịch">
                                    </div>

                                    <div class="form-group">
                                        <label for="storeYear">Năm xuất bản</label>
                                        <input type="number" id="updateYear" class="form-control"
                                            placeholder="Năm xuất bản">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeLanguage">Ngôn ngữ</label>
                                        <input type="text" id="updateLanguage" class="form-control"
                                            placeholder="Ngôn ngữ">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeWeight">Trọng lượng</label>
                                        <input type="number" id="updateWeight" class="form-control"
                                            placeholder="Trọng lượng">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeSize">kích thước</label>
                                        <input type="text" id="updateSize" class="form-control" placeholder="kích thước">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeNumPages">Số trang</label>
                                        <input type="number" id="updateNumPages" class="form-control"
                                            placeholder="Số trang">
                                    </div>
                                    <div class="form-group">
                                        <label for="storeFormat">Hình thức</label>
                                        <input type="text" id="updateFormat" class="form-control"
                                            placeholder="Hình thức">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Mô tả</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nhà xuất bản</label>
                                        <select class="form-control select2" id="updatePublisherId" style="width: 100%;">
                                            <option selected="selected" value="null" disabled>Select one</option>
                                            @forelse($listPublisher as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="null">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeCategory">Thể loại</label>
                                        <select class="form-control select2" id="updateCategoryId" style="width: 100%;">
                                            <option selected="selected" value="null" disabled>Select one</option>
                                            @forelse($listCategory as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="null">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeAuthor">Tác giả</label>
                                        <select class="form-control select2" id="updateAuthorId" style="width: 100%;">
                                            <option selected="selected" value="null" disabled>Select one</option>
                                            @forelse($listAuthor as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="null">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">Mô tả</label>
                                        <textarea id="updateDescription" type="text" name="description"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Ảnh sản phẩm</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="storeImage">Ảnh</label>

                                        <div class="custom-file">
                                        <input type="file" accept="image/*" id="updateImages" class="custom-file-input" multiple>
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <table class="table" id="filesTable">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listFile">
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-secondary btnCancel" data-dismiss="modal" >Hủy</button>
                            <input type="submit" id="updateBtn" value="Lưu thông tin" class="btn btn-success float-right">
                        </div>
                    </div>
                </section>
            </div>
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
                        <table id="myTable" class="table table-bordered table-striped">
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection