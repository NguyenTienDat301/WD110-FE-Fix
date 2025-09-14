@extends('user.master')

@section('title', 'Sửa địa chỉ')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-dark text-white text-center">
                    <h3 class="mb-0"><i class="fa fa-edit me-2"></i>Sửa địa chỉ</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('address.update', $address->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="recipient_name" class="form-label fw-semibold text-dark">Tên người nhận <span class="text-danger">*</span></label>
                            <input type="text" name="recipient_name" id="recipient_name" 
                                   class="form-control @error('recipient_name') is-invalid @enderror" 
                                   value="{{ old('recipient_name', $address->recipient_name) }}" required>
                            @error('recipient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sender_name" class="form-label fw-semibold text-dark">Người gửi</label>
                            <input type="text" name="sender_name" id="sender_name" 
                                   class="form-control @error('sender_name') is-invalid @enderror" 
                                   value="{{ old('sender_name', $address->sender_name) }}">
                            @error('sender_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ship_address" class="form-label fw-semibold text-dark">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" name="ship_address" id="ship_address" 
                                   class="form-control @error('ship_address') is-invalid @enderror" 
                                   value="{{ old('ship_address', $address->ship_address) }}" required>
                            @error('ship_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label fw-semibold text-dark">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" name="phone_number" id="phone_number" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   value="{{ old('phone_number', $address->phone_number) }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" name="is_default" id="is_default" class="form-check-input"
                                {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                            <label for="is_default" class="form-check-label fw-semibold text-dark">Đặt làm địa chỉ mặc định</label>
                            @error('is_default')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-outline-primary px-4 fw-semibold">
                                <i class="fa fa-save me-2"></i>Cập nhật
                            </button>
                            <a href="{{ route('address.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">
                                <i class="fa fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
