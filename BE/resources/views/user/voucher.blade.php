
@extends('user.master')

@section('title')
    Danh sách Voucher
@endsection

@section('content')
<h4 class="mb-3">Voucher có thể sử dụng</h4>
                <div class="row align-items-center mb-3">
                    <div class="col-md-12 text-end">
                        <form action="" method="GET" class="d-flex justify-content-end">
                            <input type="text" name="search" class="form-control w-50 me-2" placeholder="Tìm kiếm theo mã voucher..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    @forelse ($usableVouchers as $voucher)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-success">Có thể sử dụng</span>
                                        <span class="badge bg-danger">{{ $voucher->type == 0 ? 'Shop Mall' : 'Voucher Độc Quyền' }}</span>
                                    </div>
                                    <h5 class="card-title mt-2">Giảm {{ number_format($voucher->discount_value) }} đ</h5>
                                    <p class="card-text mb-1">Mã voucher: <span class="fw-bold text-primary">{{ $voucher->code }}</span></p>
                                    <p class="card-text mb-1">Đơn tối thiểu: {{ number_format($voucher->total_min) }}đ</p>
                                    <p class="card-text mb-1">Đơn tối đa: {{ number_format($voucher->total_max) }}đ</p>
                                    <p class="card-text mb-1">Số lượng: {{ $voucher->quantity }}</p>
                                    <p class="card-text mb-1">Đã dùng: {{ $voucher->used_times }}</p>
                                    <p class="card-text mb-1">Mô tả: {{ $voucher->description ?? 'Không có' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Bắt đầu: {{ $voucher->start_day->format('d/m/Y') }}</small>
                                        <small class="text-muted">Kết thúc: {{ $voucher->end_day->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-5">Không có voucher nào có thể sử dụng.</div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $usableVouchers->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>

                <hr class="my-4">
                <h4 class="mb-3">Voucher không thể sử dụng</h4>
                <div class="row align-items-center mb-3">
                    <div class="col-md-12 text-end">
                        <form action="" method="GET" class="d-flex justify-content-end">
                            <input type="text" name="search" class="form-control w-50 me-2" placeholder="Tìm kiếm theo mã voucher..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    @forelse ($unusableVouchers as $voucher)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border-secondary" style="opacity:0.6;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-secondary">Không thể sử dụng</span>
                                        <span class="badge bg-danger">{{ $voucher->type == 0 ? 'Shop Mall' : 'Voucher Độc Quyền' }}</span>
                                    </div>
                                    <h5 class="card-title mt-2">Giảm {{ number_format($voucher->discount_value) }} đ</h5>
                                    <p class="card-text mb-1">Mã voucher: <span class="fw-bold text-secondary">{{ $voucher->code }}</span></p>
                                    <p class="card-text mb-1">Đơn tối thiểu: {{ number_format($voucher->total_min) }}đ</p>
                                    <p class="card-text mb-1">Đơn tối đa: {{ number_format($voucher->total_max) }}đ</p>
                                    <p class="card-text mb-1">Số lượng: {{ $voucher->quantity }}</p>
                                    <p class="card-text mb-1">Đã dùng: {{ $voucher->used_times }}</p>
                                    <p class="card-text mb-1">Mô tả: {{ $voucher->description ?? 'Không có' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Bắt đầu: {{ $voucher->start_day->format('d/m/Y') }}</small>
                                        <small class="text-muted">Kết thúc: {{ $voucher->end_day->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-5">Không có voucher nào không thể sử dụng.</div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $unusableVouchers->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>  
    </div>
@endsection

