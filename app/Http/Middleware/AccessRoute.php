<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccessRoute
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        if($user){
            if($user->role->slug!=$role){
                abort(403);
            }
            if($user->status->slug=='blocked'){
                Auth::logout();
                redirect(route('login'));
            }
        }
        else{
           redirect(route('login'));
        }
        return $next($request);




    }
}
