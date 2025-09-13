<div class="sidebar bg-white border-end h-100 p-4 shadow-sm" style="min-height:100vh;">
    <div class="nav-profile-text d-flex align-items-center mb-4">
        <a href="{{ route('user.dashboard') }}">
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="60" height="60" alt="profile" class="img-profile rounded-circle border border-primary" />
        </a>
        <div class="ms-3">
            <span class="fw-bold text-primary">{{ Auth::user()->fullname ?? (Auth::user()->email ?? Auth::user()->username) }}</span><br>
            <span class="text-muted small">{{ Auth::user()->email }}</span>
        </div>
        <i class="fa-solid fa-circle ms-2 mt-4" style="color: green; font-size: 10px;"></i>
    </div>
    <ul class="menu list-unstyled">
    <li class="mb-3"><a href="http://localhost:3000" class="d-flex align-items-center text-dark text-decoration-none"><i class="fa fa-home me-2"></i>Quay lại trang chủ</a></li>
        <li class="mb-3">
            <div class="fw-bold mb-2 text-secondary"><i class="fa fa-user me-2"></i> Tài Khoản Của Tôi</div>
            <ul class="dropdown-content list-unstyled ps-3">
                <li class="mb-2"><a href="{{ route('user.edit') }}" class="text-dark"><i class="fa fa-id-card me-2"></i>Hồ Sơ</a></li>
                <li class="mb-2"><a href="{{ route('address.index') }}" class="text-dark"><i class="fa fa-map-marker-alt me-2"></i>Địa Chỉ</a></li>
                <li class="mb-2"><a href="{{ route('user.changepass.form') }}" class="text-dark"><i class="fa fa-key me-2"></i>Đổi Mật Khẩu</a></li>
            </ul>
        </li>
    <li class="mb-3"><a href="{{ route('userorder.index') }}" class="d-flex align-items-center text-dark text-decoration-none"><i class="fa fa-shopping-cart me-2"></i>Đơn Mua</a></li>
    <li class="mb-3"><a href="{{ route('uservouchers.index') }}" class="d-flex align-items-center text-dark text-decoration-none"><i class="fa fa-ticket-alt me-2"></i>Kho Voucher</a></li>
        <li class="mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')"><i class="fa fa-sign-out-alt me-2"></i>Đăng xuất</button>
            </form>
        </li>
    </ul>
</div>
