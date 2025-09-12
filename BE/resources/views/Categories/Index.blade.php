@extends('Layout.Layout')

@section('title')
    Danh sách danh mục
@endsection

@section('content_admin')
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-center">Danh sách danh mục</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('categories.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Số lượng sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Tạo</th>
                                <th>Sửa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products()->count() }}</td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a onclick="return confirm('Bạn có chắc muốn cập nhật trạng thái?')"
                                            href="{{ route('categories.index', ['toggle_active' => $category->id]) }}"
                                            class="btn {{ $category->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }} mb-1">
                                            {{ $category->is_active ? 'Ẩn' : 'Hiện' }}
                                        </a>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning mb-1"><i class="fas fa-edit"></i> Cập nhật</a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mb-1" onclick="return confirm('Bạn có chắc muốn xóa không?')"><i class="fas fa-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
