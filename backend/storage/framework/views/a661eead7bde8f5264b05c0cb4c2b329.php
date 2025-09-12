<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('storage/' . (Auth::user()->avatar ?? 'default-avatar.png'))); ?>" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>
    <div class="sidebar">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- User Info (optional, can be moved to dropdown in navbar if needed) -->

        <li class="nav-item">

            <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                <span class="menu-title">Trang chủ</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('products.index')); ?>">
                <span class="menu-title">Sản phẩm</span>
                <i class="mdi mdi-tshirt-crew menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('categories.index')); ?>">
                <span class="menu-title">Danh mục</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('orders.index')); ?>">
                <span class="menu-title">Đơn hàng</span>
                <i class="mdi mdi-clipboard menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('managers.index')); ?>">
                <span class="menu-title">người dùng</span>
                <i class="mdi mdi-account menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('review.index')); ?>">
                <span class="menu-title">Đánh giá</span>
                <i class="mdi mdi-comment menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('sizes.index')); ?>">
                <span class="menu-title">Kích cỡ</span>
                <i class="mdi mdi-format-size menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('colors.index')); ?>">
                <span class="menu-title">Màu sắc</span>
                <i class="mdi mdi-palette menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('vouchers.index')); ?>">
                <span class="menu-title">Phiếu giảm giá</span>
                <i class="mdi mdi-ticket-percent menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('logo_banners.index')); ?>">
                <span class="menu-title">Banner</span>
                <i class="mdi mdi-billboard menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('blog.index')); ?>">
                <span class="menu-title">Bài viết</span>
                <i class="mdi mdi-post menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('admin.edit')); ?>">
                <span class="menu-title">Hồ sơ</span>
                <i class="fas fa-user menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-link btn btn-danger w-100" onclick="return confirm('Chắc chắn đăng xuất?')">
                    <span class="menu-title">Đăng xuất</span>
                    <i class="fas fa-sign-out-alt menu-icon"></i>
                </button>
            </form>
        </li>
    </ul>
</aside>
</aside>
<?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/Layout/Sidebar.blade.php ENDPATH**/ ?>