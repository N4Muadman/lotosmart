<?php

use App\Events\LotteryResultSent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');


Route::get('/test', function () {
    return view('welcome');
});