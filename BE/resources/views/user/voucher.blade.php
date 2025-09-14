@extends('user.master')

@section('title', 'Danh sách Voucher')

@section('content')
<div class="container mt-4">

    <h1 class="display-5 fw-bold text-primary mb-4 d-flex align-items-center gap-3">
        <i class="bi bi-ticket-perforated-fill" style="font-size: 1.5rem; color: #0d6efd;"></i>
        Danh sách Voucher
    </h1>

    {{-- Form tìm kiếm chung cho cả 2 bảng --}}
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-end">
            <form action="" method="GET" class="d-flex w-100 justify-content-end gap-2" style="max-width: 500px;">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã voucher..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
    </div>

    {{-- Voucher có thể sử dụng --}}
    <h5 class="mb-3 text-success fw-bold">Voucher có thể sử dụng</h5>
    <div class="row">
        @forelse ($usableVouchers as $voucher)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-success h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-success">Có thể sử dụng</span>
                            <span class="badge bg-danger">{{ $voucher->type == 0 ? 'Shop Mall' : 'Voucher Độc Quyền' }}</span>
                        </div>
                        <h5 class="card-title text-danger mb-3">Giảm {{ number_format($voucher->discount_value) }} đ</h5>

                        <p class="mb-1">Mã voucher: <span class="fw-semibold text-primary">{{ $voucher->code }}</span></p>
                        <p class="mb-1">Đơn tối thiểu: <strong>{{ number_format($voucher->total_min) }}đ</strong></p>
                        <p class="mb-1">Đơn tối đa: <strong>{{ number_format($voucher->total_max) }}đ</strong></p>
                        <p class="mb-1">Số lượng: {{ $voucher->quantity }}</p>
                        <p class="mb-1">Đã dùng: {{ $voucher->used_times }}</p>
                        <p class="mb-3 mb-md-4 flex-grow-1">Mô tả: {{ $voucher->description ?? 'Không có' }}</p>

                        <div class="d-flex justify-content-between text-muted small">
                            <div>Bắt đầu: {{ $voucher->start_day->format('d/m/Y') }}</div>
                            <div>Kết thúc: {{ $voucher->end_day->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">Không có voucher nào có thể sử dụng.</div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mb-5">
        {{ $usableVouchers->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
    </div>

    <hr>

    {{-- Voucher không thể sử dụng --}}
    <h5 class="mb-3 text-secondary fw-bold">Voucher không thể sử dụng</h5>
    <div class="row">
        @forelse ($unusableVouchers as $voucher)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-secondary h-100" style="opacity: 0.6;">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-secondary">Không thể sử dụng</span>
                            <span class="badge bg-danger">{{ $voucher->type == 0 ? 'Shop Mall' : 'Voucher Độc Quyền' }}</span>
                        </div>
                        <h5 class="card-title text-muted mb-3">Giảm {{ number_format($voucher->discount_value) }} đ</h5>

                        <p class="mb-1">Mã voucher: <span class="fw-semibold text-secondary">{{ $voucher->code }}</span></p>
                        <p class="mb-1">Đơn tối thiểu: <strong>{{ number_format($voucher->total_min) }}đ</strong></p>
                        <p class="mb-1">Đơn tối đa: <strong>{{ number_format($voucher->total_max) }}đ</strong></p>
                        <p class="mb-1">Số lượng: {{ $voucher->quantity }}</p>
                        <p class="mb-1">Đã dùng: {{ $voucher->used_times }}</p>
                        <p class="mb-3 mb-md-4 flex-grow-1">Mô tả: {{ $voucher->description ?? 'Không có' }}</p>

                        <div class="d-flex justify-content-between text-muted small">
                            <div>Bắt đầu: {{ $voucher->start_day->format('d/m/Y') }}</div>
                            <div>Kết thúc: {{ $voucher->end_day->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">Không có voucher nào không thể sử dụng.</div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $unusableVouchers->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
    </div>

</div>
@endsection
