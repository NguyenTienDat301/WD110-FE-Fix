@extends('user.master')

@section('title')
    Cập nhật tài khoản
@endsection

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fa fa-user-edit me-2"></i>Cập nhật tài khoản</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fullname" class="form-label fw-bold"><i class="fa fa-user me-2"></i>Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" value="{{ old('fullname', Auth::user()->fullname) }}">
                                @error('fullname')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="birth_day" class="form-label fw-bold"><i class="fa fa-calendar-alt me-2"></i>Birth Day</label>
                                <input type="date" class="form-control" name="birth_day" id="birth_day" value="{{ old('birth_day', Auth::user()->birth_day) }}">
                                @error('birth_day')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold"><i class="fa fa-phone me-2"></i>Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                @error('phone')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold"><i class="fa fa-envelope me-2"></i>Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', Auth::user()->email) }}">
                            </div>
                        </div>
                        <div class="mt-3">
                            @if(!empty(Auth::user()->email))
                                @if(Auth::user()->email_verified_at == null)
                                    <span class="fw-bold"><i class="fa fa-exclamation-circle text-danger me-2"></i>Trạng thái:</span>
                                    <span class="badge bg-danger">Chưa xác thực</span>
                                    <a href="{{ route('verify') }}" class="btn btn-success btn-sm ms-3">Xác minh email</a>
                                @else
                                    <span class="fw-bold"><i class="fa fa-check-circle text-success me-2"></i>Trạng thái email:</span>
                                    <span class="badge bg-success">Đã xác thực</span>
                                @endif
                            @endif
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label for="address" class="form-label fw-bold"><i class="fa fa-map-marker-alt me-2"></i>Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{ old('address', Auth::user()->address) }}">
                                @error('address')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="ship_address" class="form-label fw-bold"><i class="fa fa-shipping-fast me-2"></i>Ship Default</label>
                                <a href="{{route('address.create')}}" class="btn btn-success btn-sm ms-3 mb-2">Thêm mới</a>
                                <select name="address_id" class="form-select">
                                    @if ($addresses->isNotEmpty())
                                        @php
                                            $defaultAddress = $addresses->firstWhere('is_default', 1);
                                        @endphp
                                        @if ($defaultAddress)
                                            <option value="{{ $defaultAddress->id }}">
                                                <strong>Địa chỉ:</strong> {{ $defaultAddress->ship_address }} - 
                                                <strong>Số điện thoại:</strong> {{ $defaultAddress->phone_number }} - 
                                                <strong>Tên người nhận:</strong> {{ $user->recipient_name ?? $user->fullname }}
                                            </option>
                                        @else
                                            <option value="">Chưa có địa chỉ mặc định, hãy thêm địa chỉ mới</option>
                                        @endif
                                        @foreach ($addresses as $address)
                                            <option value="{{ $address->id }}">
                                                {{ $address->ship_address }} - {{ $address->phone_number }} - {{ $user->fullname ?? $user->account }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Chưa có địa chỉ giao hàng nào, hãy thêm địa chỉ mới</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="avatar" class="form-label fw-bold mt-3"><i class="fa fa-image me-2"></i>Avatar</label>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="100" height="100" class="rounded-circle border border-primary me-3 object-fit-cover" style="object-fit:cover;">
                                    <input type="file" class="form-control w-50" name="avatar" id="avatar">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success px-4"><i class="fa fa-save me-2"></i>Cập nhật</button>
                            <a href="{{route('user.dashboard')}}" class="btn btn-secondary px-4"><i class="fa fa-arrow-left me-2"></i>Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
