<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;

trait RedirectToHome
{
    protected function redirectTo(): string
    {
        if(Auth::user()->role->slug=='user')
            return route('user.home');
        elseif(Auth::user()->role->slug=='moderator')
            return route('moderator.home');
        elseif(Auth::user()->role->slug=='admin')
            return route('admin.home');
        else return route('login');
    }
}
