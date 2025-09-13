<div class="sidebar bg-gradient-primary-to-light border-end h-100 p-4 shadow-lg rounded" style="min-height:100vh; background: linear-gradient(135deg, #1976d2 0%, #90caf9 100%); color: #fff;">
    <div class="nav-profile-text d-flex align-items-center mb-4">
        <a href="{{ route('user.dashboard') }}">
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="60" height="60" alt="profile" class="img-profile rounded-circle border border-3 border-white shadow" />
        </a>
        <div class="ms-3">
            <span class="fw-bold text-white fs-5">{{ Auth::user()->fullname ?? (Auth::user()->email ?? Auth::user()->username) }}</span><br>
            <span class="text-light small">{{ Auth::user()->email }}</span>
        </div>
        <i class="fa-solid fa-circle ms-2 mt-4" style="color: #4caf50; font-size: 10px;"></i>
    </div>
    <ul class="menu list-unstyled">
    <li class="mb-3"><a href="http://localhost:3000" class="d-flex align-items-center text-white text-decoration-none"><i class="fa fa-home me-2"></i>Quay lại trang chủ</a></li>
        <li class="mb-3">
            <div class="fw-bold mb-2 text-white"><i class="fa fa-user me-2"></i> Tài Khoản Của Tôi</div>
            <ul class="dropdown-content list-unstyled ps-3">
                <li class="mb-2"><a href="{{ route('user.edit') }}" class="text-white"><i class="fa fa-id-card me-2"></i>Hồ Sơ</a></li>
                <li class="mb-2"><a href="{{ route('address.index') }}" class="text-white"><i class="fa fa-map-marker-alt me-2"></i>Địa Chỉ</a></li>
                <li class="mb-2"><a href="{{ route('user.changepass.form') }}" class="text-white"><i class="fa fa-key me-2"></i>Đổi Mật Khẩu</a></li>
            </ul>
        </li>
    <li class="mb-3"><a href="{{ route('userorder.index') }}" class="d-flex align-items-center text-white text-decoration-none"><i class="fa fa-shopping-cart me-2"></i>Đơn Mua</a></li>
    <li class="mb-3"><a href="{{ route('uservouchers.index') }}" class="d-flex align-items-center text-white text-decoration-none"><i class="fa fa-ticket-alt me-2"></i>Kho Voucher</a></li>
        <li class="mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light w-100 text-primary fw-bold" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')"><i class="fa fa-sign-out-alt me-2"></i>Đăng xuất</button>
            </form>
        </li>
    </ul>
</div>
