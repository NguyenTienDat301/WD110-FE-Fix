<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- AdminLTE JS & jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo e(asset('js/chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/fix-errors.js')); ?>"></script>

    <link rel="icon" href="<?php echo e(asset('110.jpg')); ?>" type="image/x-icon">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?php echo $__env->make('Layout.Nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </nav>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php echo $__env->make('Layout.Sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
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
                    <?php echo $__env->yieldContent('content_admin'); ?>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
    </div>

    <!-- Custom JS (nếu cần) -->
    <script src="<?php echo e(url('js/chart.umd.js')); ?>"></script>
    <script src="<?php echo e(url('js/dashboard.js')); ?>"></script>
    <script src="<?php echo e(url('js/vendor.bundle.base.js')); ?>"></script>
    <script src="<?php echo e(url('js/misc.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\New folder (2)\New folder (2)\backend\resources\views/Layout/Layout.blade.php ENDPATH**/ ?>