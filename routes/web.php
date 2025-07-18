<?php

use App\Events\LotteryResultSent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');

Route::get('phan-tich', function() {
    return view('pages.analytic');
})->name('pages.analytic');

Route::get('/test', function () {
    return view('welcome');
});

Route::get('/news', [NewsController::class, 'index'])->name('news.index'); // Trang tin tức tổng
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show'); // Trang chi tiết
//Route::get('/admin/news/create', [NewsController::class, 'create'])->name('admin.news.create'); // Trang thêm tin
//Route::post('/admin/news', [NewsController::class, 'store'])->name('admin.news.store'); // Lưu tin mới

Route::get('doi-tac', function () {
    return view('partner.index');
})->name('partner.index');

include __DIR__.'/admin.php'; // Đăng ký các route admin
