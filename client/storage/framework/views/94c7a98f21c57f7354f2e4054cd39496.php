

<?php $__env->startSection('js'); ?>
    <script>
        ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <form action="" method="post">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Thêm sách</h6>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Tên sách</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Code</label>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Trọng lượng</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Hình thức</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Năm XB</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Ngôn ngữ</label>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Kích thước bao bì</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Số trang</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Code">
                    <label for="floatingPassword">Người dịch</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        <option selected>Chọn tác giả</option>
                        <option value="1">Sasuke</option>
                        <option value="2">Naruto</option>
                        <option value="3">Luffy</option>
                    </select>
                    <label for="floatingSelect">Tác giả</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        <option selected>Chọn nhà xuất bản</option>
                        <option value="1">Tuổi trẻ</option>
                        <option value="2">Kim Đồng</option>
                        <option value="3">Công thương</option>
                    </select>
                    <label for="floatingSelect">Nhà xuất bản</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Nhập mô tả"
                        id="editor" style="height: 150px;"></textarea>
                    <label for="floatingTextarea"></label>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-success me-2">Lưu</button>   
        </div>
    </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\laravel\ung_dung_laravel_react_vao_do_an_ban_sach\client\resources\views/book/create.blade.php ENDPATH**/ ?>