<?php $__env->startSection('title', 'index Blog'); ?>

<?php $__env->startSection('content_admin'); ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-center">Danh sách bài viết</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('blog.create')); ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($blog->id); ?></td>
                                    <td><?php echo e($blog->title); ?></td>
                                    <td><?php echo e($blog->category->name ?? 'N/A'); ?></td>
                                    <td><img src="<?php echo e(asset('storage/' . $blog->image)); ?>" width="50" height="50" class="rounded"></td>
                                    <td>
                                        <?php if($blog->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('blog.edit', $blog->id)); ?>" class="btn btn-warning mb-1"><i class="fas fa-edit"></i> Cập nhật</a>
                                        <form action="<?php echo e(route('blog.destroy', $blog->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger mb-1" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/blog/index.blade.php ENDPATH**/ ?>