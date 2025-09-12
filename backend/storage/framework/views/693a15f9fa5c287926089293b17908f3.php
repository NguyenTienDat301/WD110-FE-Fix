<?php $__env->startSection('tiltle'); ?>
    Cập nhật tài khoản
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline mt-4">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="<?php echo e(route('admin.edit')); ?>" class="nav-link">Hồ sơ của tôi</a></li>
                    <li class="nav-item"><a href="<?php echo e(route('admin.changepass.form')); ?>" class="nav-link">Cập nhật mật khẩu</a></li>
                </ul>
            </div>
            <div class="card-body">
                <h3 class="text-center mb-4">Cập nhật tài khoản</h3>
                <form action="<?php echo e(route('admin.update')); ?>" method="POST" enctype="multipart/form-data" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-3">
                        <label for="fullname">Họ và tên</label>
                        <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo e(old('fullname', Auth::user()->fullname)); ?>">
                        <?php $__errorArgs = ['fullname'];
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
                    <div class="form-group mb-3">
                        <label for="birth_day">Sinh nhật</label>
                        <input type="date" class="form-control" name="birth_day" id="birth_day" value="<?php echo e(old('birth_day', Auth::user()->birth_day)); ?>">
                        <?php $__errorArgs = ['birth_day'];
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
                    <div class="form-group mb-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone', Auth::user()->phone)); ?>">
                        <?php $__errorArgs = ['phone'];
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
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo e(old('email', Auth::user()->email)); ?>" disabled>
                        <input type="hidden" name="email" value="<?php echo e(old('email', Auth::user()->email)); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo e(old('address', Auth::user()->address)); ?>">
                        <?php $__errorArgs = ['address'];
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
                    <div class="form-group mb-3">
                        <label for="avatar" class="mt-3">Ảnh đại diện</label><br>
                        <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" width="100px" class="mb-2 mt-2 rounded">
                        <input type="file" class="form-control mt-2" name="avatar" id="avatar">
                    </div>
                    <div class="text-center m-3">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Cập nhật</button>
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/admin/update.blade.php ENDPATH**/ ?>