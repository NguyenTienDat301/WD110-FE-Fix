@extends('user.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname ?? Auth::user()->email) }}" class="rounded-circle border" width="100" height="100" alt="Avatar">
                            <div class="ms-4">
                                <h3 class="mb-0">{{ Auth::user()->fullname ?? Auth::user()->email }}</h3>
                                <span class="text-muted"><i class="fa fa-envelope me-2"></i>{{ Auth::user()->email }}</span><br>
                                <span class="text-muted"><i class="fa fa-phone me-2"></i>{{ Auth::user()->phone ?? 'Chưa cập nhật' }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Ngày tạo tài khoản:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Vai trò:</strong> Thành viên</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <marquee behavior="" direction="">Chúc bạn một ngày mua sắm thật vui vẻ!</marquee>
                            <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-edit me-2"></i>Chỉnh sửa thông tin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
