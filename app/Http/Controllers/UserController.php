<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $ads = $request->user()->ads()->get();
        return view('user.home', ['ads' => $ads]);
    }
}
