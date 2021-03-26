<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;

trait RedirectTo
{
    protected function redirectTo(): string
    {
        if(Auth::user()->role)
            return route(Auth::user()->role->slug.'.home');
        else return route('login');
    }
}
