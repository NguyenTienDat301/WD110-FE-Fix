<?php $__env->startSection('title'); ?>
    Danh sách danh mục
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-center">Danh sách danh mục</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Số lượng sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Tạo</th>
                                <th>Sửa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($category->id); ?></td>
                                    <td><?php echo e($category->name); ?></td>
                                    <td><?php echo e($category->products()->count()); ?></td>
                                    <td>
                                        <?php if($category->is_active): ?>
                                            <span class="badge bg-success">Hoạt động</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>
                                    <td><?php echo e($category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'N/A'); ?></td>
                                    <td>
                                        <a onclick="return confirm('Bạn có chắc muốn cập nhật trạng thái?')"
                                            href="<?php echo e(route('categories.index', ['toggle_active' => $category->id])); ?>"
                                            class="btn <?php echo e($category->is_active ? 'btn-outline-secondary' : 'btn-outline-success'); ?> mb-1">
                                            <?php echo e($category->is_active ? 'Ẩn' : 'Hiện'); ?>

                                        </a>
                                        <a href="<?php echo e(route('categories.edit', $category->id)); ?>" class="btn btn-warning mb-1"><i class="fas fa-edit"></i> Cập nhật</a>
                                        <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger mb-1" onclick="return confirm('Bạn có chắc muốn xóa không?')"><i class="fas fa-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    <?php echo e($categories->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/categories/index.blade.php ENDPATH**/ ?>