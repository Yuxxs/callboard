<?php

namespace App\Http\Middleware;

use App\Models\Ad;
use Closure;
use Illuminate\Http\Request;

class AccessAd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $ad = Ad::where('id',$request['id']??$request['ad']['id']??null)->withTrashed()->first();
        if (!is_null($ad)) {

            if ($request->user()->id != $ad->user->id) {
                abort(403);
            }
            return $next($request);
        } else {
            return $next($request);
        }
    }
}
