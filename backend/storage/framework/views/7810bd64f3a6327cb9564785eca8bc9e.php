<?php $__env->startSection('title', 'Sửa Blog'); ?>

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
            <h1 class="m-0 text-center">Sửa bài viết</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <form action="<?php echo e(route('blog.update', $blog->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e($category->id == $blog->category_id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category_id'];
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
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo e(old('title', $blog->title)); ?>" required>
                        <?php $__errorArgs = ['title'];
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
                    <div class="mb-3">
                        <label for="description" class="form-label">Tóm tắt</label>
                        <textarea name="description" id="description" class="form-control" required><?php echo e(old('description', $blog->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
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
                    <div class="mb-3">
                        <label for="content" class="form-label">Mô tả</label>
                        <textarea name="content" id="content" class="form-control" required><?php echo e(old('content', $blog->content)); ?></textarea>
                        <?php $__errorArgs = ['content'];
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
                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <?php if($blog->image): ?>
                            <div class="mt-2">
                                <img src="<?php echo e(asset('storage/' . $blog->image)); ?>" alt="Current Image" style="max-width: 200px;" class="rounded">
                            </div>
                        <?php endif; ?>
                        <?php $__errorArgs = ['image'];
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
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Trạng thái</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" <?php echo e($blog->is_active == 1 ? 'selected' : ''); ?>>Hoạt động</option>
                            <option value="0" <?php echo e($blog->is_active == 0 ? 'selected' : ''); ?>>Không hoạt động</option>
                        </select>
                        <?php $__errorArgs = ['is_active'];
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
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/blog/edit.blade.php ENDPATH**/ ?>