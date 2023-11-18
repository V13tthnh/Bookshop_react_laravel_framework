

<?php $__env->startSection('content'); ?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="m-n2">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary">Export Excel</button>
                        <button type="button" class="btn btn-outline-primary">Export PDF</button>
                        <button type="button" class="btn btn-outline-primary">Import Excel</button>
                        <button type="button" class="btn btn-outline-primary">Refresh</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="m-n2">
                    <button type="button" class="btn btn-success m-2"><i class="fa fa-plus me-2"></i>Thêm</button>
                    <button type="button" class="btn btn-light m-2"><i class="fa fa-list me-2"></i>Danh sách đã xóa</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Recent Salse</h6>
            <a href="">Show All</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col"><input class="form-check-input" type="checkbox"></th>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input class="form-check-input" type="checkbox"></td>
                        <td>01 Jan 2045</td>
                        <td>INV-0123</td>
                        <td>Jhon Doe</td>
                        <td>$123</td>
                        <td>Paid</td>
                        <td>
                            <button type="button" class="btn btn-lg btn-lg-rectangle btn-warning m-2">
                                <a href=""><i class="fa fa-edit"></i></a>
                            </button>
                            <button type="button" class="btn btn-lg btn-lg-rectangle btn-primary m-2"><i class="fa fa-trash"></i></button>    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>;
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\laravel\ung_dung_laravel_react_vao_do_an_ban_sach\client\resources\views/book/index.blade.php ENDPATH**/ ?>