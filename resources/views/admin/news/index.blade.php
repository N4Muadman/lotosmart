@extends('admin.layout')
@section('title', 'Quản lý Tin Tức')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Quản lý Tin tức</h1>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">+ Thêm Tin mới</a>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách tin tức</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Ngày đăng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newsList as $news)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($news->image)
                                        <img src="{{ asset('uploads/news/'.$news->image) }}" style="width:80px; height:60px; object-fit:cover; border-radius:8px;">
                                    @else
                                        <img src="https://source.unsplash.com/80x60/?news" style="width:80px; height:60px; object-fit:cover; border-radius:8px;">
                                    @endif
                                </td>
                                <td>{{ $news->title }}</td>
                                <td>
                                    {{ $news->category ? $news->category->name : '---' }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($news->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $news->status ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $news->status ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Xoá tin này?')">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($newsList->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có tin tức nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
