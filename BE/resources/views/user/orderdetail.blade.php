@extends('user.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary fw-bold">Chi tiết đơn hàng #{{ $order->id }}</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <strong>Trạng thái:</strong>
                @php
                    $statusLabels = [
                        0 => ['label' => 'Đang xử lý', 'class' => 'bg-info text-white'],
                        2 => ['label' => 'Đang vận chuyển', 'class' => 'bg-primary text-white'],
                        3 => ['label' => 'Giao hàng thành công', 'class' => 'bg-success text-white'],
                        4 => ['label' => 'Đã hủy', 'class' => 'bg-danger text-white'],
                    ];
                    $status = $order->status;
                    $statusInfo = $statusLabels[$status] ?? ['label' => 'Không rõ', 'class' => 'bg-secondary text-white'];
                @endphp
                <span class="badge {{ $statusInfo['class'] }} py-2 px-3 fs-6">{{ $statusInfo['label'] }}</span>
            </div>
            <div class="text-muted fst-italic">
                Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Thành tiền:</strong> <span class="text-danger fs-5 fw-bold">₫{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span></p>
                    <p><strong>Giá gốc (chưa giảm):</strong> <span class="text-muted">₫{{ number_format(($order->total_amount ?? 0) + ($order->discount_value ?? 0), 0, ',', '.') }}</span></p>
                    <p><strong>Đã giảm giá:</strong> <span class="text-warning fw-semibold">₫{{ number_format($order->discount_value ?? 0, 0, ',', '.') }}</span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Địa chỉ nhận hàng:</strong><br> {{ $order->shipAddress->ship_address ?? 'Không có' }}</p>
                    <p><strong>Người nhận:</strong> {{ $order->shipAddress->recipient_name ?? 'Không có' }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->shipAddress->phone_number ?? 'Không có' }}</p>
                    <p><strong>Người gửi:</strong> {{ $order->shipAddress->sender_name ?? 'Không có' }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3 text-secondary">Sản phẩm trong đơn hàng</h4>
    <div class="card shadow-sm">
        <div class="card-body p-3">
            @foreach ($order->orderDetails as $detail)
                <div class="row align-items-center mb-4 border-bottom pb-3">
                    <div class="col-md-2">
                        <img 
                            src="{{ Storage::url($detail->product->img_thumb ?? '') }}" 
                            alt="{{ $detail->product->name ?? 'Sản phẩm đã bị xóa' }}" 
                            class="img-fluid rounded"
                            style="max-height: 100px; object-fit: cover;"
                        >
                    </div>
                    <div class="col-md-5">
                        <h6 class="fw-semibold mb-1">{{ $detail->product->name ?? 'Sản phẩm đã bị xóa' }}</h6>
                        <small class="text-muted d-block mb-1">Danh mục: {{ $detail->product->categories->name ?? 'Không rõ' }}</small>
                        <small class="text-muted d-block mb-1">Màu sắc: {{ $detail->color->name_color ?? 'Không rõ' }}</small>
                        <small class="text-muted d-block">Kích cỡ: {{ $detail->size->size ?? 'Không rõ' }}</small>
                    </div>
                    <div class="col-md-2 text-center">
                        <p class="mb-0">Số lượng:</p>
                        <span class="badge bg-secondary px-3 py-2">x{{ $detail->quantity }}</span>
                    </div>
                    <div class="col-md-3 text-end">
                        <p class="mb-1">Đơn giá:</p>
                        <span class="text-success fs-5 fw-bold">₫{{ number_format($detail->price, 0, ',', '.') }}</span>
                        <p class="mb-1 mt-2">Tổng:</p>
                        <span class="text-danger fs-5 fw-bold">₫{{ number_format($detail->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('userorder.index') }}" class="btn btn-outline-primary">
            <i class="fa fa-arrow-left me-2"></i> Quay lại danh sách đơn hàng
        </a>
    </div>
</div>
@endsection
