<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $ads = $request->user()->ads()->get();
        return view('user.home', ['ads' => $ads]);
    }
    public function profile($id)
    {
        $user = User::find($id);
        return view('user.profile', ['user' => $user]);
    }

}
