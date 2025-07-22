<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $newsList = News::with('category')->orderByDesc('id')->get();
        return view('admin.news.index', compact('newsList'));
    }
     // Form thêm tin
    public function create()
    {
        $categories = NewCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    // Lưu tin mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'summary' => 'nullable|max:500',
            'content' => 'required',
            'category_id' => 'nullable|exists:new_categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);
        $slug = Str::slug($request->title);
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/news'), $imageName);
        }
        News::create([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imageName,
            'status' => $request->has('status') ? 1 : 0,
        ]);
        return redirect()->route('admin.news.index')->with('success', 'Thêm tin thành công!');
    }

    // Form sửa
    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = NewCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $request->validate([
            'title' => 'required|max:255',
            'summary' => 'nullable|max:500',
            'content' => 'required',
            'category_id' => 'nullable|exists:new_categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'nullable|boolean',
        ]);
        $data = $request->only('title', 'summary', 'content', 'category_id');
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->has('status') ? 1 : 0;
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/news'), $imageName);
            $data['image'] = $imageName;
        }
        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'Cập nhật thành công!');
    }

    // Xoá tin
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Xóa file ảnh nếu tồn tại
        if ($news->image) {
            $imagePath = public_path('uploads/news/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Đã xoá!');
    }

}
