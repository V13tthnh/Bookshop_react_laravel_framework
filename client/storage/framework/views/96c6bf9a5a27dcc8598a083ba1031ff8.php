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
                        <th scope="col">Email</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $admin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td><?php echo e($item->id); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->email); ?></td>
                            <td>
                                <button type="button" class="btn btn-lg btn-lg-rectangle btn-warning m-2">
                                    <a href=""><i class="fa fa-edit"></i></a>
                                </button>
                                <button type="button" class="btn btn-lg btn-lg-rectangle btn-primary m-2"><i class="fa fa-trash"></i></button>    
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr colspan=4>Không có dữ liệu!</tr>
                    <?php endif; ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\laravel\ung_dung_laravel_react_vao_do_an_ban_sach\client\resources\views/admin/index.blade.php ENDPATH**/ ?>