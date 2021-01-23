<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;




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

        if(!is_null($user)){
            if($user->role->slug!=$role){
                abort(403);
            }
        }
        else abort(403);

        return $next($request);
    }
}
