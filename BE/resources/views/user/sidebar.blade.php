<div class="sidebar border-end h-100 p-4 shadow-lg rounded"
    style="background: linear-gradient(135deg, #667eea, #764ba2);">

    <!-- Profile -->
    <div class="nav-profile-text d-flex align-items-center mb-4">
        <a href="{{ route('user.dashboard') }}">
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="60" height="60" alt="profile"
                class="img-profile rounded-circle border border-3 border-white shadow" />
        </a>
        <div class="ms-3">
            <span class="fw-bold text-white fs-5">{{ Auth::user()->fullname ?? (Auth::user()->email ?? Auth::user()->username) }}</span><br>
            <span class="text-light small">{{ Auth::user()->email }}</span>
        </div>
        <!-- <i class="fa-solid fa-circle ms-2 mt-4" style="color: #4caf50; font-size: 10px;"></i> -->
    </div>

    <!-- Menu -->
    <ul class="menu list-unstyled">
        <li class="mb-3">
            <a href="http://localhost:3000" class="sidebar-link">
                <i class="fa fa-home me-2"></i>Quay lại trang chủ
            </a>
        </li>

        <li class="mb-3">
            <div class="fw-bold mb-2 text-white">
                <i class="fa fa-user me-2"></i> Tài Khoản Của Tôi
            </div>
            <ul class="dropdown-content list-unstyled ps-3">
                <li class="mb-2">
                    <a href="{{ route('user.edit') }}" class="sidebar-link">
                        <i class="fa fa-id-card me-2"></i>Hồ Sơ
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('address.index') }}" class="sidebar-link">
                        <i class="fa fa-map-marker-alt me-2"></i>Địa Chỉ
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.changepass.form') }}" class="sidebar-link">
                        <i class="fa fa-key me-2"></i>Đổi Mật Khẩu
                    </a>
                </li>
            </ul>
        </li>

        <li class="mb-3">
            <a href="{{ route('userorder.index') }}" class="sidebar-link">
                <i class="fa fa-shopping-cart me-2"></i>Đơn Mua
            </a>
        </li>
        <li class="mb-3">
            <a href="{{ route('uservouchers.index') }}" class="sidebar-link">
                <i class="fa fa-ticket-alt me-2"></i>Kho Voucher
            </a>
        </li>

        <!-- Logout -->
        <li class="mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 fw-bold py-2"
                    onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                    <i class="fa fa-sign-out-alt me-2"></i>Đăng xuất
                </button>
            </form>
        </li>
    </ul>
</div>

<!-- Custom hover styles -->
<style>
    .sidebar-link {
        display: block;
        color: #ffffff;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        padding-left: 16px;
        color: #ffffff;
        text-decoration: none;
    }

    .sidebar .dropdown-content .sidebar-link {
        padding-left: 20px;
        font-size: 15px;
    }

    .sidebar .dropdown-content .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
</style>
