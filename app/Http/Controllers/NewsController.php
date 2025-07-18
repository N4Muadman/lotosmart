<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // Trang danh sách tin tức
    public function index()
    {
        $newsList = News::orderBy('created_at', 'desc')->get();
        return view('news.index', compact('newsList'));
    }

    // Trang chi tiết
    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('news.show', compact('news'));
    }

    // Form thêm tin (dùng cho admin)
    public function create()
    {
        return view('admin.news.create');
    }

    // Lưu tin mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($request->title, '-');
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
        }

        News::create([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return redirect()->route('news.index')->with('success', 'Đã thêm tin tức thành công!');
    }
}
