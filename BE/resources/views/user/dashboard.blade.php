@extends('user.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="card shadow-lg border-0 mt-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #fff 100%);">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('user.dashboard') }}">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname ?? Auth::user()->email) }}" class="rounded-circle border border-3 border-primary shadow object-fit-cover" style="width:100px; height:100px; object-fit:cover;" alt="Avatar">
                </a>
                <div class="ms-4">
                    <h3 class="mb-0 fw-bold text-primary"><i class="fa fa-user-circle me-2"></i>{{ Auth::user()->fullname ?? Auth::user()->email }}</h3>
                    <span class="text-muted"><i class="fa fa-envelope me-2"></i>{{ Auth::user()->email }}</span><br>
                    <span class="text-muted"><i class="fa fa-phone me-2"></i>{{ Auth::user()->phone ?? 'Chưa cập nhật' }}</span>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fa fa-calendar-alt me-2"></i>Ngày tạo tài khoản:</strong> <span class="text-primary fw-bold">{{ Auth::user()->created_at->format('d/m/Y') }}</span></p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fa fa-user-tag me-2"></i>Vai trò:</strong> <span class="badge bg-primary">Thành viên</span></p>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-primary fw-bold"><i class="fa fa-smile-beam me-2"></i>Chúc bạn một ngày mua sắm thật vui vẻ!</span>
                <a href="{{ route('user.edit') }}" class="btn btn-primary shadow"><i class="fa fa-edit me-2"></i>Chỉnh sửa thông tin</a>
            </div>
        </div>
    </div>
@endsection
