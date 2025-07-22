<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewCategory;
use Illuminate\Support\Str;

class NewCategoryController extends Controller
{
    public function index()
    {
        $categories = NewCategory::orderBy('id', 'desc')->get();
        return view('admin.newscategory.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.newscategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);
        $slug = Str::slug($request->name, '-');
        NewCategory::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);
        return redirect()->route('admin.newscategory.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = NewCategory::findOrFail($id);
        return view('admin.newscategory.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = NewCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255'
        ]);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
        return redirect()->route('admin.newscategory.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $category = NewCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.newscategory.index')->with('success', 'Xóa thành công!');
    }
}
