<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return view('user/home',['ads'=>$ads]);
    }
}
