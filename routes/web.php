<?php

use App\Events\LotteryResultSent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');

Route::get('phan-tich', function() {
    return view('pages.analytic');
})->name('pages.analytic');
