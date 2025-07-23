<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(){
        return view('pages.home');
    }

    public function analytic(){
        return view('pages.analytic');
    }

    public function simulateLotteryDraw(){
        return view('pages.simulate-lottery-draw');
    }

    public function partner(){
        return view('partner.index');
    }
}
