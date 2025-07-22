@extends('admin.layout')
@section('title', 'Sửa danh mục tin')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Sửa danh mục tin</h1>
    <form action="{{ route('admin.newscategory.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.newscategory.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
