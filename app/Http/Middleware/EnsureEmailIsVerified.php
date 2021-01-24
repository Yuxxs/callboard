<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified
{

    public function handle(Request $request, Closure $next)
    {
        if (is_null($request->user())||
            ($request->user()->status->slug=='waiting')) {
            return Redirect::guest(URL::route('verification.notice'));
        }

        return $next($request);
    }
}
