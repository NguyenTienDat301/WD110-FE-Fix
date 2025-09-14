@extends('user.master')

@section('title', 'Danh sách Đơn hàng')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-id" content="{{ $orders->first()->user_id ?? auth()->id() }}">

<script>
    window.CURRENT_USER_ID = '{{ $orders->first()->user_id ?? auth()->id() }}';
    console.log('Global User ID:', window.CURRENT_USER_ID);
</script>

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/realtime-orders.css') }}">

<!-- External JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js" defer></script>
<script src="{{ asset('js/realtime-user-orders.js') }}" defer></script>
<script src="{{ asset('js/debug-user-realtime.js') }}" defer></script>

<div class="container my-5">
    <h1 class="text-center mb-5 text-primary fw-bold">
        <i class="fa fa-shopping-cart me-2"></i>Danh sách Đơn hàng
    </h1>

    {{-- Navigation Tabs --}}
    <ul class="nav nav-tabs justify-content-center mb-5" role="tablist">
        @php
            $statusTabs = [
                null => 'Tất cả',
                0 => 'Chờ Xử lí',
                1 => 'Đã xử lý',
                2 => 'Vận chuyển',
                3 => 'Hoàn thành',
                4 => 'Đã hủy',
                //5 => 'Trả hàng/Hoàn tiền', // Uncomment if needed
            ];
            $currentStatus = request()->get('status');
        @endphp

        @foreach ($statusTabs as $key => $label)
            <li class="nav-item" role="presentation">
                <a 
                    class="nav-link {{ (string)$currentStatus === (string)$key ? 'active' : '' }}" 
                    href="{{ route('userorder.index', $key !== null ? ['status' => $key] : []) }}" 
                    role="tab"
                >
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- Orders List --}}
    @if ($orders->isEmpty())
        <div class="alert alert-info text-center py-5 rounded shadow-sm">
            <i class="fa fa-box-open fa-3x mb-3"></i><br>
            <h4>Không có đơn hàng nào.</h4>
            <p>Hãy tiếp tục mua sắm để tạo đơn hàng mới!</p>
        </div>
    @else
        @foreach ($orders as $order)
            @php
                // Badge & color mappings
                $statusColor = match ($order->status) {
                    3 => ['bg' => 'bg-success', 'text' => 'text-white', 'label' => 'Giao hàng thành công', 'headerBg' => '#e6f9ed'],
                    4 => ['bg' => 'bg-danger', 'text' => 'text-white', 'label' => 'Đã hủy', 'headerBg' => '#fdeaea'],
                    2 => ['bg' => 'bg-primary', 'text' => 'text-white', 'label' => 'Đang vận chuyển', 'headerBg' => '#eaf1fd'],
                    default => ['bg' => 'bg-info', 'text' => 'text-dark', 'label' => 'Đang xử lý', 'headerBg' => '#f0f4f8'],
                };
            @endphp

            <div class="card shadow-sm mb-4 border-0" data-order-id="{{ $order->id }}" data-user-id="{{ $order->user_id }}">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: {{ $statusColor['headerBg'] }};">
                    <span class="fw-bold text-secondary"><i class="fa fa-receipt me-2"></i>ID đơn hàng: #{{ $order->id }}</span>
                    <span class="fw-semibold {{ $order->status == 3 ? 'text-success' : ($order->status == 4 ? 'text-danger' : 'text-primary') }}">
                        {{ $order->message }}
                    </span>
                    <span class="badge {{ $statusColor['bg'] }} {{ $statusColor['text'] }} px-3 py-2 fs-6 rounded-pill">
                        {{ $statusColor['label'] }}
                    </span>
                </div>

                <div class="card-body bg-white">
                    @foreach ($order->orderDetails as $detail)
                        <div class="d-flex align-items-center mb-4 border-bottom pb-3 gap-3">
                            @if ($detail->product)
                                <a href="{{ url('/product-detail/' . $detail->product->id) }}" class="d-block flex-shrink-0" style="width: 90px; height: 90px;">
                                    <img src="{{ Storage::url($detail->product->img_thumb) }}" alt="{{ $detail->product->name }}" class="img-fluid rounded" style="object-fit: cover; width: 100%; height: 100%;">
                                </a>
                                <div class="flex-grow-1 d-flex flex-column justify-content-center">
                                    <h5 class="fw-bold text-primary mb-1">{{ $detail->product->name }}</h5>
                                    <small class="text-muted"><i class="fa fa-list me-1"></i>Danh mục: {{ $detail->product->categories->name ?? 'Không rõ' }}</small>
                                    <small class="text-muted"><i class="fa fa-palette me-1"></i>Màu: {{ $detail->color->name_color ?? 'Không rõ' }}</small>
                                    <small class="text-muted"><i class="fa fa-ruler-combined me-1"></i>Kích cỡ: {{ $detail->size->size ?? 'Không rõ' }}</small>
                                    <small class="text-muted"><i class="fa fa-sort-numeric-up me-1"></i>Số lượng: <strong>x{{ $detail->quantity }}</strong></small>
                                </div>
                                <div class="text-end" style="min-width: 140px;">
                                    <div><small class="d-block mb-1"><i class="fa fa-money-bill-wave me-1"></i>Đơn giá:</small>
                                        @if (isset($detail->price) && $detail->price > 0)
                                            <span class="fw-bold text-success">₫{{ number_format($detail->price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-danger">Không có</span>
                                        @endif
                                    </div>
                                    <div><small class="d-block mb-1"><i class="fa fa-calculator me-1"></i>Tổng:</small>
                                        <span class="fw-bold text-danger">₫{{ number_format($detail->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-danger fw-semibold">Sản phẩm đã bị xóa bởi hệ thống</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="card-footer bg-light d-flex justify-content-between align-items-center border-top py-3 flex-wrap gap-3">
                    <div>
                        <h5 class="mb-1">Thành tiền: <span class="text-danger fw-bold fs-5">₫{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span></h5>
                        <p class="mb-1 text-warning fw-semibold">Đã giảm giá: {{ number_format($order->discount_value ?? 0, 0, ',', '.') }} VNĐ</p>
                        <small class="text-success">Đã tạo lúc: {{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('userorder.show', $order->id) }}" class="btn btn-info btn-sm text-white d-flex align-items-center gap-1">
                            <i class="fa fa-eye"></i> Xem chi tiết
                        </a>

                        @if ($order->status == 0)
                            <button class="btn btn-danger btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#cancelOrderModal-{{ $order->id }}">
                                <i class="fa fa-times"></i> Hủy Đơn Hàng
                            </button>
                        @elseif ($order->status == 1)
                            <button class="btn btn-secondary btn-sm d-flex align-items-center gap-1" disabled data-bs-toggle="tooltip" title="Không thể hủy khi đơn hàng đã được xử lý">
                                <i class="fa fa-ban"></i> Hủy Đơn Hàng
                            </button>
                        @endif

                        {{-- Đã nhận hàng (bị ẩn theo yêu cầu)
                        @if ($order->status == 2)
                            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#confirmReceiptModal-{{ $order->id }}">
                                Đã nhận hàng
                            </button>
                        @endif --}}

                        @if ($order->status == 3)
                            @php
                                $reviewExists = \App\Models\Review::where('order_id', $order->id)->exists();
                            @endphp
                            @if ($reviewExists)
                                <button class="btn btn-warning btn-sm text-white" onclick="alert('Bạn đã đánh giá đơn hàng này rồi.')">
                                    <i class="fa fa-star"></i> Đã đánh giá
                                </button>
                            @else
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $order->id }}">
                                    <i class="fa fa-star"></i> Đánh giá
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Cancel Order Modal --}}
            <div class="modal fade" id="cancelOrderModal-{{ $order->id }}" tabindex="-1" aria-labelledby="cancelOrderModalLabel-{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('userorder.update', $order->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PATCH')
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelOrderModalLabel-{{ $order->id }}">Lý do hủy đơn hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="cancelReason-{{ $order->id }}" class="form-label">Chọn lý do hủy đơn hàng:</label>
                                    <select class="form-select" id="cancelReason-{{ $order->id }}" name="cancel_reason" required>
                                        <option value="" disabled selected>-- Chọn lý do --</option>
                                        <option value="Tôi không muốn đặt hàng nữa">Tôi không muốn đặt hàng nữa</option>
                                        <option value="Mặt hàng quá đắt">Mặt hàng quá đắt</option>
                                        <option value="Thời gian giao hàng quá lâu">Thời gian giao hàng quá lâu</option>
                                        <option value="Other">Khác</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn lý do hủy đơn hàng.
                                    </div>
                                </div>
                                <div class="mb-3 d-none" id="otherReasonInput-{{ $order->id }}">
                                    <label for="otherReason-{{ $order->id }}" class="form-label">Nhập lý do khác:</label>
                                    <input type="text" class="form-control" id="otherReason-{{ $order->id }}" name="other_reason" maxlength="255" placeholder="Nhập lý do của bạn">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-danger">Xác nhận hủy đơn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Review Modal --}}
            <div class="modal fade" id="reviewModal-{{ $order->id }}" tabindex="-1" aria-labelledby="reviewModalLabel-{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('review.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel-{{ $order->id }}">Đánh giá Đơn Hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="rating-{{ $order->id }}" class="form-label">Đánh giá sao:</label>
                                    <select name="rating" id="rating-{{ $order->id }}" class="form-select" required>
                                        <option value="" disabled>Chọn số sao</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $i == 5 ? 'selected' : '' }}>{{ $i }} Sao</option>
                                        @endfor
                                    </select>
                                    <div class="invalid-feedback">Vui lòng chọn đánh giá sao.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="comment-{{ $order->id }}" class="form-label">Bình luận:</label>
                                    <textarea name="comment" id="comment-{{ $order->id }}" class="form-control" rows="4" maxlength="1000" placeholder="Viết bình luận của bạn..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image-{{ $order->id }}" class="form-label">Ảnh minh họa (nếu có):</label>
                                    <input type="file" name="image" id="image-{{ $order->id }}" class="form-control" accept="image/*" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-primary">Gửi Đánh Giá</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $orders->appends(['status' => request()->get('status')])->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Handle "Other" reason toggle for all cancel modals
        @foreach ($orders as $order)
            const select{{ $order->id }} = document.getElementById('cancelReason-{{ $order->id }}');
            const otherInput{{ $order->id }} = document.getElementById('otherReasonInput-{{ $order->id }}');

            if (select{{ $order->id }}) {
                select{{ $order->id }}.addEventListener('change', function() {
                    if (this.value === 'Other') {
                        otherInput{{ $order->id }}.classList.remove('d-none');
                        otherInput{{ $order->id }}.querySelector('input').setAttribute('required', 'required');
                    } else {
                        otherInput{{ $order->id }}.classList.add('d-none');
                        const input = otherInput{{ $order->id }}.querySelector('input');
                        input.removeAttribute('required');
                        input.value = '';
                        input.classList.remove('is-invalid');
                    }
                    this.classList.remove('is-invalid');
                });
            }

            // Bootstrap form validation on submit
            const formCancel{{ $order->id }} = document.querySelector('#cancelOrderModal-{{ $order->id }} form');
            if (formCancel{{ $order->id }}) {
                formCancel{{ $order->id }}.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    this.classList.add('was-validated');
                });
            }

            // Reset modal on close
            const modalCancel{{ $order->id }} = document.getElementById('cancelOrderModal-{{ $order->id }}');
            if (modalCancel{{ $order->id }}) {
                modalCancel{{ $order->id }}.addEventListener('hidden.bs.modal', function () {
                    const form = this.querySelector('form');
                    form.reset();
                    form.classList.remove('was-validated');
                    otherInput{{ $order->id }}.classList.add('d-none');
                });
            }

            // Review modal validation (optional)
            const formReview{{ $order->id }} = document.querySelector('#reviewModal-{{ $order->id }} form');
            if (formReview{{ $order->id }}) {
                formReview{{ $order->id }}.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    this.classList.add('was-validated');
                });
            }

        @endforeach

        // Initialize Bootstrap tooltips for disabled buttons
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('button[disabled][data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

@endsection
