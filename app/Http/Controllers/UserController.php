<?php

namespace App\Http\Controllers;

use App\Mail\AdForModeration;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $moderators = User::whereHas('role', function ($query) {
            $query->where('slug', 'moderator');
        })->get();
        $message = (new AdForModeration($ad))
            ->onQueue('emails');
        foreach ($moderators as $moderator) {
            Mail::to($moderator->email)->queue($message);
        }

        return redirect(route('ad', ['id' => $request['id']]));
    }
}
