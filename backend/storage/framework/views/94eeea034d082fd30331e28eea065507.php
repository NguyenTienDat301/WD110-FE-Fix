<?php $__env->startSection('title'); ?>
    Thêm mới danh mục
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-center">Thêm danh mục</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card card-outline card-success">
            <div class="card-body">
                <form action="<?php echo e(route('categories.store')); ?>" method="POST" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <input type="text" name="is_active" id="is_active" class="form-control" value="1" hidden>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Thêm mới</button>
                        <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/categories/create.blade.php ENDPATH**/ ?>