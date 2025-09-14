<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .navbar-custom {
            background-color: #002244; /* Màu xanh navy thể thao */
        }

        .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom span {
            color: #ffffff !important;
        }

        .btn-logout {
            background-color: #FF3B3F; /* Màu đỏ nổi bật */
            color: #fff;
            border: none;
        }

        .btn-logout:hover {
            background-color: #cc2f32;
        }

        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="admin-template-bg" style="min-height: 100vh;">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-4">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="fa fa-user-circle me-2"></i>Thông Tin Thành Viên
                </a>
                <div class="d-flex align-items-center">
                    <span class="me-3">{{ Auth::user()->fullname ?? Auth::user()->email }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-logout">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar trái -->
                <div class="col-lg-3">
                    @include('user.sidebar')
                </div>

                <!-- Nội dung chính -->
                <div class="col-lg-9">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
