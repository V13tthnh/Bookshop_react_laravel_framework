@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        var idImage = 0;
        $(function () {
            // Summernote
            $('#storeDescription').summernote();
            $('#updateDescription').summernote()
        });
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
                { data: 'supplier_name', name: 'supplier.name' },
                { data: 'images', render: function(data, type, row){
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
        //xử lý sự kiện ẩn modal edit thì reset các trường validate modal create
        $('#modal-create').on('hidden.bs.modal', function(){
            $('#createFormValidate').removeClass('was-validated');
            $('.create_name_error').text('');
            $('.create_code_error').text('');
            $('.create_description_error').text('');
            $('.create_weight_error').text('');
            $('.create_format_error').text('');
            $('.create_year_error').text('');
            $('.create_language_error').text('');
            $('.create_size_error').text('');
            $('.create_num_pages_error').text('');
            $('.create_translator_error').text('');
            $('.create_publisher_id_error').text('');
            $('.create_supplier_id_error').text('');
        });
        //xử lý sự kiện ẩn modal edit thì reset các trường validate modal edit
        $('#modal-edit').on('hidden.bs.modal', function(){
            $('#listFile').text(''); //Sau khi tắt modal-edit thì danh sách hình ảnh về rỗng
            $('#updateFormValidate').removeClass('was-validated');
            $('.update_name_error').text('');
            $('.update_code_error').text('');
            $('.update_description_error').text('');
            $('.update_weight_error').text('');
            $('.update_format_error').text('');
            $('.update_year_error').text('');
            $('.update_language_error').text('');
            $('.update_size_error').text('');
            $('.update_num_pages_error').text('');
            $('.update_translator_error').text('');
            $('.update_supplier_id_error').text('');
            $('.update_publisher_id_error').text('');
        });
        //xử lý sự kiêm thêm mới
        $('#addBtn').click(function (e) {
            e.preventDefault(); //Ngăn không cho sự kiện khác ngoài sự kiện click phát sinh
            var formData = new FormData(); //Tạo form data
            var files = $('#storeImages')[0].files; //gán danh sách ảnh đã chọn vào biến files
            for (var i = 0; i < files.length; i++) { //Duyệt ảnh
                formData.append('images[]', files[i]); //Thêm từng files[i] vào $request->images[]
            }
            formData.append("_token", "{{csrf_token()}}"); //@csrf
            formData.append("name", $('#storeName').val()); //$request->name = giá trị #storeName
            formData.append("code", $('#storeCode').val()); //$request->code = giá trị #storeCode
            formData.append("translator", $('#storeTranslator').val()); //...phía dưới tương tự
            formData.append("year", $('#storeYear').val());
            formData.append("language", $('#storeLanguage').val());
            formData.append("weight", $('#storeWeight').val());
            formData.append("size", $('#storeSize').val());
            formData.append("num_pages", $('#storeNumPages').val());
            formData.append("format", $('#storeFormat').val());
            formData.append("publisher_id", $('#storePublisherId').val());
            formData.append("supplier_id", $('#storeSupplierId').val());
            formData.append("category_ids", $('#storeCategoryId').val());
            formData.append("author_ids", $('#storeAuthorId').val());
            formData.append("description", $('#storeDescription').val());
            $.ajax({ //Xử lý ajax sau khi thêm hoàn tất toàn bộ dữ liệu cần thiết vào formdata
                url: "{{route('book.store')}}",
                method: "post",
                data: formData, //Lúc này formData chứa 1 mảng các giá trị [$request->name = 'abc', $request->code = '123',...]
                contentType: false, //Trình duyệt tự động đặt content-type phù hợp với dữ liệu đầu vào
                processData: false, //JQuery sẽ không chuyển dữ liệu đổi thành dạng chuỗi 'application/x-www-form-urlencoded'
            }).done(function(res){
                if (res.success) { //Thêm hoàn tất
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' }); //Thông báo thêm hoàn tất
                    $('#modal-create').modal('hide'); //ẩn model thêm mới sau khi thêm xong
                    createFormClear(); //clear dữ liệu input sau khi thêm thành công
                    table.ajax.reload(); //refresh bảng để tải dữ liệu mới
                }
                if(!res.success) { //Thêm thất bại
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' }); //Thông báo thất bại
                    return; //Thoát hàm
                }
            }).fail(function(res){ //Hàm fail() đc gọi khi xử lý ajax bị bất cứ lỗi gì 
                var errors = res.responseJSON.errors; //Gán mảng các đối tượng lỗi vào biến errors
                //console.log(errors); //có thể console ra để xem lỗi
                $('#createFormValidate').addClass('was-validated'); //Thêm lớp css was-validate của bootstrap để hiển thị lỗi trên input
                $.each(errors, function(key, value){  //Duyệt mảng errors và gán các giá trị lỗi phía dưới các trường input
                    $('.create_' + key + '_error').text(value[0]);
                    $('.create_' + key + '_error').text(value[1]);
                    $('.create_' + key + '_error').text(value[2]);
                    $('.create_' + key + '_error').text(value[3]);
                    $('.create_' + key + '_error').text(value[4]);
                    $('.create_' + key + '_error').text(value[5]);
                    $('.create_' + key + '_error').text(value[6]);
                    $('.create_' + key + '_error').text(value[7]);
                    $('.create_' + key + '_error').text(value[8]);
                    $('.create_' + key + '_error').text(value[9]);
                    $('.create_' + key + '_error').text(value[10]);
                    $('.create_' + key + '_error').text(value[11]);
                });
            });
        });
        //xử lý sự kiện gán giá trị vào modal-edit
        $('#myTable').on('click', '.editBtn', function(){
            var id = $(this).val(); //Lấy giá trị từ button sửa 
            $.ajax({ //Xử lý lấy giá trị 1 cuốn sách
                url: "book/edit/" + id,
                method: "get",
            }).done(function(res){ 
                //Sau khi modal-edit đc bật thì duyệt lấy danh sách hình ảnh
                for(let i = 0; i < res.data.images.length; i++){
                    //Thêm 1 dòng vào table listFile
                    $('#listFile').append(`<tr class="data_${res.data.images[i].id}"> 
                                        <td style="font-size:12px">${res.data.images[i].front_cover}</td>
                                        <td><img src="${res.data.images[i].front_cover}" sizes="40" srcset="" style="height:70px;width:70px"/></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <button href="#" value="${res.data.images[i].id}" class="btn btn-danger deleteImgBtn"><i
                                                    class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>`); 
                }
                //Gán giá trị cho các trường input trong edit
                $('#updateName').val(res.data.name); $('#updateCode').val(res.data.code); 
                $('#updateTranslator').val(res.data.translator); $('#updateYear').val(res.data.year);
                $('#updateLanguage').val(res.data.language); $('#updateWeight').val(res.data.weight);
                $('#updateSize').val(res.data.size); $('#updateNumPages').val(res.data.num_pages); 
                $('#updateFormat').val(res.data.format); 
                //lấy các giá trị của publisher và gán vào select2
                $('#updatePublisherId').val(res.data.publisher_id);
                $('#updatePublisherId').trigger('change');  
                //lấy các giá trị của supplier và gán vào select2 
                $('#updateSupplierId').val(res.data.supplier_id); 
                $('#updateSupplierId').trigger('change');
                //duyệt lấy các giá trị của categories và gán vào select2 multiple
                var categories = res.data.categories.map(item => item.id);
                $('#updateCategoryId').val(categories);
                $('#updateCategoryId').trigger('change');
                //duyệt lấy các giá trị của authors và gán vào select2 multiple
                var authors = res.data.authors.map(item => item.id);
                $('#updateAuthorId').val(authors);
                $('#updateAuthorId').trigger('change');
                $('#updateDescription').summernote('code', res.data.description); $('#updateId').val(res.data.id)
            });
        });
        //xử lý sự kiện xóa ảnh thuộc table listFile trong modal edit
        $('#listFile').on('click', '.deleteImgBtn', function(){
            var id = $(this).val(); //lấy giá trị đc gắn vào button deleteImgBtn
            $.ajax({ //Xử lý xóa ảnh
                url: "book/delete-image/" + id,
                method: "get",
            }).done(function(res){
                if (res.success) {
                    //Xóa thành công ảnh nào thì remove dòng chứa ảnh đó trong table listFile
                    $('.deleteImgBtn').parents(".data_" + id).remove(); 
                    table.ajax.reload(); //load lại trang
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                }
            });
        });
        //Xử lý sự kiện cập nhật 
        $('#updateBtn').click(function(e){
            e.preventDefault();
            var id = $('#updateId').val();
            var formData = new FormData(); //phần này giống sự kiện thêm mới ở trên
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
            formData.append("supplier_id", $('#updateSupplierId').val());
            formData.append("category_ids", $('#updateCategoryId').val());
            formData.append("author_ids", $('#updateAuthorId').val());
            formData.append("description", $('#updateDescription').val());
            $.ajax({ //xử lý cập nhật
                url: "book/update/" + id,
                method: "post", 
                data: formData,
                contentType: false,
                processData: false,
            }).done(function(res){
                if (res.success) {
                    Swal.fire({ title: res.message, icon: 'success', confirmButtonText: 'OK' });
                    $('#modal-edit').modal('hide'); //ẩn model edit
                    table.ajax.reload(); //refresh bảng 
                }
                if(!res.success) {
                    Swal.fire({ title: res.message, icon: 'error', confirmButtonText: 'OK' });
                    return;
                }
            }).fail(function(res){ //Hàm fail() được gọi khi có bất kỳ lỗi nào xảy ra trong quá trình thực hiện yêu cầu Ajax.
                var errors = res.responseJSON.errors; //Lưu 1 mảng các đối tượng lỗi vào biến errors
                $('#updateFormValidate').addClass('was-validated'); //Thêm lớp css was-validate của bootstrap để hiển thị lỗi trên input
                $.each(errors, function(key, value){                //Duyệt mảng errors và gán các giá trị lỗi phía dưới các trường input
                    $('.update_' + key + '_error').text(value[0]);
                    $('.update_' + key + '_error').text(value[1]);
                    $('.update_' + key + '_error').text(value[2]);
                    $('.update_' + key + '_error').text(value[3]);
                    $('.update_' + key + '_error').text(value[4]);
                    $('.update_' + key + '_error').text(value[5]);
                    $('.update_' + key + '_error').text(value[6]);
                    $('.update_' + key + '_error').text(value[7]);
                    $('.update_' + key + '_error').text(value[8]);
                    $('.update_' + key + '_error').text(value[9]);
                    $('.update_' + key + '_error').text(value[10]);
                    $('.update_' + key + '_error').text(value[11]);
                });
            });;
        });
        //xử lý sự kiện click khi nhấn vào button xóa
        $('#myTable').on('click', '.deleteBtn', function(){
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
                        url: "book/destroy/" + id,
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
</script>
@endsection

@section('content')
<!-- Thêm sách xl-->
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
                <form action="" id="createFormValidate">
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
                                        <div class="text-danger create_name_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeCode">Mã hàng</label>
                                        <input type="text" id="storeCode" class="form-control" placeholder="Mã hàng">
                                        <div class="text-danger create_code_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeTranslator">Người dịch</label>
                                        <input type="text" id="storeTranslator" class="form-control"
                                            placeholder="Người dịch">
                                        <div class="text-danger create_translator_error"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="storeYear">Năm xuất bản</label>
                                        <input type="number" id="storeYear" class="form-control"
                                            placeholder="Năm xuất bản">
                                        <div class="text-danger create_year_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeLanguage">Ngôn ngữ</label>
                                        <input type="text" id="storeLanguage" class="form-control"
                                            placeholder="Ngôn ngữ">
                                        <div class="text-danger create_language_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeWeight">Trọng lượng</label>
                                        <input type="number" id="storeWeight" class="form-control"
                                            placeholder="Trọng lượng">
                                        <div class="text-danger create_weight_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeSize">kích thước</label>
                                        <input type="text" id="storeSize" class="form-control" placeholder="kích thước">
                                        <div class="text-danger create_size_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeNumPages">Số trang</label>
                                        <input type="number" id="storeNumPages" class="form-control"
                                            placeholder="Số trang">
                                        <div class="text-danger create_num_pages_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeFormat">Hình thức</label>
                                        <input type="text" id="storeFormat" class="form-control"
                                            placeholder="Hình thức">
                                        <div class="text-danger create_format_error"></div>
                                    </div>
                                </div>
                            </div>
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
                                        <select id="storePublisherId" class="form-control select2" data-placeholder="Chọn nhà xuất bản" style="width: 100%;">
                                            <option value="0" selected disabled>Chọn 1 NXB</option>
                                            @forelse($listPublisher as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                        <div class="text-danger create_publisher_id_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nhà cung cấp</label>
                                        <select id="storeSupplierId" class="form-control select2" data-placeholder="Chọn nhà xuất bản" style="width: 100%;">
                                            <option value="0" selected disabled>Chọn 1 NXB</option>
                                            @forelse($listSupplier as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                        <div class="text-danger create_supplier_id_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Thể loại</label>
                                        <div class="select2-purple">
                                            <select id="storeCategoryId" class="select2" multiple="multiple" data-placeholder="Có thể chọn nhiều thể loại" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                @forelse($listCategory as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @empty
                                                <option value="null">Không có dữ liệu!</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tác giả</label>
                                        <div class="select2-purple">
                                            <select id="storeAuthorId" class="select2" multiple="multiple" data-placeholder="Có thể chọn nhiều tác giả" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                @forelse($listAuthor as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @empty
                                                <option value="null">Không có dữ liệu!</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">Mô tả</label>
                                        <textarea id="storeDescription" type="text" name="description"
                                            class="form-control"></textarea>
                                        <div class="text-danger create_description_error"></div>
                                    </div>
                                </div>
                            </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <input type="submit" id="addBtn" value="Lưu thông tin" class="btn btn-success float-right">
                        </div>
                    </div>
                </section>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sửa thông tin sách xl-->
<div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa sách</h4>
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
                                        <div class="text-danger update_name_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeCode">Mã hàng</label>
                                        <input type="text" id="updateCode" class="form-control" placeholder="Mã hàng">
                                        <div class="text-danger update_code_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeTranslator">Người dịch</label>
                                        <input type="text" id="updateTranslator" class="form-control"
                                            placeholder="Người dịch">
                                        <div class="text-danger update_translator_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeYear">Năm xuất bản</label>
                                        <input type="number" id="updateYear" class="form-control"
                                            placeholder="Năm xuất bản">
                                        <div class="text-danger update_year_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeLanguage">Ngôn ngữ</label>
                                        <input type="text" id="updateLanguage" class="form-control"
                                            placeholder="Ngôn ngữ">
                                        <div class="text-danger update_language_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeWeight">Trọng lượng</label>
                                        <input type="number" id="updateWeight" class="form-control"
                                            placeholder="Trọng lượng">
                                        <div class="text-danger update_weight_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeSize">kích thước</label>
                                        <input type="text" id="updateSize" class="form-control" placeholder="kích thước">
                                        <div class="text-danger update_size_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeNumPages">Số trang</label>
                                        <input type="number" id="updateNumPages" class="form-control"
                                            placeholder="Số trang">
                                        <div class="text-danger update_num_pages_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="storeFormat">Hình thức</label>
                                        <input type="text" id="updateFormat" class="form-control"
                                            placeholder="Hình thức">
                                        <div class="text-danger update_format_error"></div>
                                    </div>
                                </div>
                            </div>
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
                                        <select id="updatePublisherId" class="form-control select2" data-placeholder="Chọn nhà xuất bản" style="width: 100%;">
                                            <option value="0" selected disabled>Chọn 1 NXB</option>
                                            @forelse($listPublisher as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="0">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                        <div class="text-danger update_publisher_id_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nhà cung cấp</label>
                                        <select id="updateSupplierId" class="form-control select2" data-placeholder="Chọn nhà xuất bản" style="width: 100%;">
                                            <option value="0" selected disabled>Chọn 1 NCC</option>
                                            @forelse($listSupplier as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @empty
                                            <option value="0">Không có dữ liệu!</option>
                                            @endforelse
                                        </select>
                                        <div class="text-danger update_supplier_id_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Thể loại</label>
                                        <div class="select2-purple">
                                            <select id="updateCategoryId" class="select2" multiple="multiple" data-placeholder="Có thể chọn nhiều thể loại" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                @forelse($listCategory as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @empty
                                                <option value="null">Không có dữ liệu!</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tác giả</label>
                                        <div class="select2-purple">
                                            <select id="updateAuthorId" class="select2" multiple="multiple" data-placeholder="Có thể chọn nhiều tác giả" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                @forelse($listAuthor as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @empty
                                                <option value="null">Không có dữ liệu!</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">Mô tả</label>
                                        <textarea id="updateDescription" type="text" name="description"
                                            class="form-control"></textarea>
                                        <div class="text-danger update_description_error"></div>
                                    </div>
                                </div>
                            </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-secondary" data-dismiss="modal" >Hủy</button>
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
                <h1>Danh sách</h1>
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