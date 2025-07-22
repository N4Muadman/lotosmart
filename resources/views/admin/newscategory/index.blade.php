@extends('admin.layout')
@section('title', 'Quản lý danh mục tin')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Quản lý danh mục tin</h1>
    <a href="{{ route('admin.newscategory.create') }}" class="btn btn-primary mb-3">+ Thêm danh mục</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên danh mục</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>
                    <a href="{{ route('admin.newscategory.edit', $cat) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.newscategory.destroy', $cat) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
