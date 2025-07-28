<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use App\Models\NewCategory;

class NewsController extends Controller
{
    // Trang danh sách tin tức
    public function index(Request $request)
    {
        $categories = NewCategory::all();

        // Khởi tạo query với eager loading quan hệ category
        $query = News::with('category')->where('status', 1)->orderByDesc('created_at');

        // Lọc theo danh mục nếu có
        if ($request->filled('cat')) {
            $query->where('category_id', $request->cat);
        }

        // Lọc theo tìm kiếm nếu có
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('summary', 'like', '%'.$request->search.'%');
            });
        }

        // Lấy danh sách tin phân trang, mỗi trang 6 tin, giữ query string
        $newsList = $query->paginate(6)->withQueryString();

        return view('pages.news.index', compact('newsList', 'categories'));
    }

    // Trang chi tiết
    public function show($slug)
    {
        $news = News::with('category')->where('slug', $slug)->firstOrFail();

        // Lấy các tin cùng danh mục, khác id hiện tại
        $relatedNews = \App\Models\News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        return view('pages.news.show', compact('news', 'relatedNews'));
    }

    // // Form thêm tin (dùng cho admin)
    // public function create()
    // {
    //     return view('admin.news.create');
    // }

    // // Lưu tin mới
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'summary' => 'nullable|string|max:500',
    //         'content' => 'required|string',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $slug = Str::slug($request->title, '-');
    //     $imageName = null;

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = time().'_'.$image->getClientOriginalName();
    //         $image->move(public_path('uploads/news'), $imageName);
    //     }

    //     News::create([
    //         'title' => $request->title,
    //         'slug' => $slug,
    //         'summary' => $request->summary,
    //         'content' => $request->content,
    //         'image' => $imageName,
    //     ]);

    //     return redirect()->route('news.index')->with('success', 'Đã thêm tin tức thành công!');
    // }
}
