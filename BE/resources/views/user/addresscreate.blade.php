@extends('user.master')

@section('title')
    Thêm mới địa chỉ
@endsection

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h4 class="mb-0"><i class="fa fa-map-marker-alt me-2"></i>Thêm mới địa chỉ</h4>
                </div>
                <div class="card-body p-4 bg-light">
                    <form action="{{ route('address.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row g-3">

                            <!-- Tên người nhận -->
                            <div class="col-md-6">
                                <label for="recipient_name" class="form-label fw-bold text-dark">
                                    <i class="fa fa-user me-2"></i>Tên người nhận
                                </label>
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name"
                                    value="{{ old('recipient_name') }}" required>
                                @error('recipient_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Người gửi -->
                            <div class="col-md-6">
                                <label for="sender_name" class="form-label fw-bold text-dark">
                                    <i class="fa fa-user-circle me-2"></i>Người gửi
                                </label>
                                <input type="text" class="form-control" name="sender_name" id="sender_name"
                                    value="{{ old('sender_name') }}">
                                @error('sender_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Địa chỉ -->
                            <div class="col-md-12">
                                <label for="ship_address" class="form-label fw-bold text-dark">
                                    <i class="fa fa-home me-2"></i>Địa chỉ
                                </label>
                                <input type="text" class="form-control" id="ship_address" name="ship_address"
                                    value="{{ old('ship_address') }}" required>
                                @error('ship_address')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-12">
                                <label for="phone_number" class="form-label fw-bold text-dark">
                                    <i class="fa fa-phone me-2"></i>Số điện thoại
                                </label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="fa fa-save me-2"></i>Thêm địa chỉ
                            </button>
                            <a href="{{ route('address.index') }}" class="btn btn-secondary px-4">
                                <i class="fa fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
