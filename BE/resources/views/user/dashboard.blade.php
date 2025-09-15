@extends('user.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="card shadow-lg border-0 mt-4 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
                <!-- Avatar -->
                <a href="{{ route('user.dashboard') }}">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname ?? Auth::user()->email) }}"
                        class="rounded-circle border border-3" 
                        style="width:100px; height:100px; object-fit:cover; border-color: #0d47a1;" alt="Avatar">
                </a>
                
                <!-- User Info -->
                <div class="ms-4">
                    <h3 class="mb-1 fw-bold" style="color: #0d47a1;">
                        <i class="fa fa-user-circle me-2"></i>{{ Auth::user()->fullname ?? Auth::user()->email }}
                    </h3>
                    <p class="mb-0 text-muted"><i class="fa fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                    <p class="mb-0 text-muted"><i class="fa fa-phone me-2"></i>{{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                </div>
            </div>

            <hr class="mb-4">

            <!-- Account Details -->
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <p class="mb-1 text-dark">
                        <strong><i class="fa fa-calendar-alt me-2"></i>Ngày tạo tài khoản:</strong>
                        <span class="fw-bold" style="color: #0d47a1;">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                    </p>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-1 text-dark">
                        <strong><i class="fa fa-user-tag me-2"></i>Vai trò:</strong>
                        <span class="badge" style="background-color: #0d47a1;">Thành viên</span>
                    </p>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <span class="fw-bold" style="color: #0d47a1;">
                    <i class="fa fa-smile-beam me-2"></i>Chúc bạn một ngày mua sắm thật vui vẻ!
                </span>
                <a href="{{ route('user.edit') }}" class="btn shadow-sm fw-bold" style="background-color: #0d47a1; color: #fff;">
                    <i class="fa fa-edit me-2"></i>Chỉnh sửa thông tin
                </a>
            </div>
        </div>
    </div>
@endsection
