@extends('user.master')

@section('title')
    Đổi mật khẩu
@endsection

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fa fa-key me-2"></i>Đổi mật khẩu</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.password.change') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold"><i class="fa fa-lock me-2"></i>Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" required value="{{old('current_password')}}">
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold"><i class="fa fa-unlock-alt me-2"></i>Mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                            @error('new_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-bold"><i class="fa fa-check-circle me-2"></i>Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required>
                            @error('new_password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success px-4"><i class="fa fa-save me-2"></i>Đổi mật khẩu</button>
                            <a href="{{route('user.dashboard')}}" class="btn btn-secondary px-4"><i class="fa fa-arrow-left me-2"></i>Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
