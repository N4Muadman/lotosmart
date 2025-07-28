<?php

use App\Events\LotteryResultSent;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PagesController;

Route::get('/', [PagesController::class, 'home'])->name('pages.home');

Route::get('phan-tich', [PagesController::class, 'analytic'])->name('pages.analytic');

Route::get('quay-thu-xo-so', [PagesController::class, 'simulateLotteryDraw'])->name('pages.simulate-draw');

Route::get('doi-tac', [PagesController::class, 'partner'])->name('partner.index');

Route::get('dang-nhap', [AuthController::class, 'showLogin'])->name('login.form');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/news', [NewsController::class, 'index'])->name('news.index'); // Trang tin tức tổng
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show'); // Trang chi tiết
//Route::get('/admin/news/create', [NewsController::class, 'create'])->name('admin.news.create'); // Trang thêm tin
//Route::post('/admin/news', [NewsController::class, 'store'])->name('admin.news.store'); // Lưu tin mới


include __DIR__.'/admin.php'; // Đăng ký các route admin
