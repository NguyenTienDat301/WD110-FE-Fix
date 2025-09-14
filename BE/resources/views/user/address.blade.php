@extends('user.master')

@section('title')
    Địa chỉ
@endsection

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3 px-4">
                <h4 class="mb-0"><i class="fa fa-address-book me-2"></i>Địa chỉ của tôi</h4>
                <a href="{{ route('address.create') }}" class="btn btn-success fw-bold">
                    <i class="fa fa-plus me-2"></i>Thêm mới
                </a>
            </div>
            <div class="card-body p-4 bg-light">
                <div class="row g-4">
                    @forelse ($addresses as $address)
                        <div class="col-md-6">
                            <div class="card h-100 border border-2 shadow-sm 
                                {{ $address->is_default ? 'border-primary' : 'border-secondary' }}">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-2">
                                        <i class="fa fa-user me-2 text-primary"></i>{{ $address->recipient_name }}
                                        @if ($address->is_default)
                                            <span class="badge bg-primary ms-2">Mặc định</span>
                                        @endif
                                    </h5>
                                    <p class="mb-1"><i class="fa fa-user-circle me-2 text-secondary"></i><strong>Người gửi:</strong> {{ $address->sender_name }}</p>
                                    <p class="mb-1"><i class="fa fa-home me-2 text-secondary"></i><strong>Địa chỉ:</strong> {{ $address->ship_address }}</p>
                                    <p class="mb-1"><i class="fa fa-phone me-2 text-secondary"></i><strong>SĐT:</strong> {{ $address->phone_number }}</p>

                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        @if (!$address->is_default)
                                            <form action="{{ route('address.set-default', $address->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-star me-1"></i>Đặt làm mặc định
                                                </button>
                                            </form>
                                        @endif

                                        <div class="d-flex">
                                            <a href="{{ route('address.edit', $address->id) }}" class="btn btn-warning btn-sm me-2">
                                                <i class="fa fa-edit me-1"></i>Cập nhật
                                            </a>
                                            <form action="{{ route('address.destroy', $address->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fa fa-trash me-1"></i>Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fa fa-info-circle me-2"></i>Bạn chưa có địa chỉ nào. Nhấn <strong>Thêm mới</strong> để tạo địa chỉ giao hàng.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $addresses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
