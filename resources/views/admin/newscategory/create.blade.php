@extends('admin.layout')
@section('title', 'Thêm danh mục tin')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Thêm danh mục tin</h1>
    <form action="{{ route('admin.newscategory.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.newscategory.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
