@extends('admin.layout')
@section('title', 'Thêm Tin Mới')
@section('content')
<div class="container">
    <h3>Thêm tin tức mới</h3>
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-2">
            <label>Tiêu đề</label>
            <input name="title" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Danh mục</label>
            <select name="category_id" class="form-control">
                <option value="">--Chọn danh mục--</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            <label>Ảnh đại diện</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group mb-2">
            <label>Mô tả</label>
            <textarea name="summary" class="form-control"></textarea>
        </div>
        <div class="form-group mb-2">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" id="editor">{{ old('content', $news->content ?? '') }}</textarea>
        </div>
        <div class="form-group mb-2">
            <div class="form-check">
                <input
                    type="checkbox"
                    name="status"
                    value="1"
                    class="form-check-input"
                    id="status"
                    {{ (isset($news) ? $news->status : true) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="status">Hiển thị</label>
            </div>
        </div>
        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Quay lại</a>

    </form>
</div>
@endsection
@push('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editor.ui.view.editable.element.style.minHeight = '300px';
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush

