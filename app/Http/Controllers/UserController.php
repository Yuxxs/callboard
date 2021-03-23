<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $ads = $request->user()->ads()->withTrashed()->get();
        return view('user.home', ['ads' => $ads]);
    }
    public function profile($id)
    {
        $user = User::find($id);
        return view('user.profile', ['user' => $user]);
    }
    public function sendToModeration(Request $request)
    {
        $ad = Ad::find($request['id']);
        $status = AdStatus::where('slug', 'moderation')->first();
        $ad->status()->associate($status);
        $ad->save();
        return redirect(route('ad', ['id' => $request['id']]));
    }
}
