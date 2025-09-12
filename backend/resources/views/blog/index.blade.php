@extends('Layout.Layout')

@section('title', 'index Blog')

@section('content_admin')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-center">Danh sách bài viết</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('blog.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->id }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->category->name ?? 'N/A' }}</td>
                                    <td><img src="{{ asset('storage/' . $blog->image) }}" width="50" height="50" class="rounded"></td>
                                    <td>
                                        @if($blog->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-warning mb-1"><i class="fas fa-edit"></i> Cập nhật</a>
                                        <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mb-1" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
