<?php

namespace App\Http\Middleware;

use App\Models\Ad;
use Closure;
use Illuminate\Http\Request;

class ShowAdIfActive
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
        $ad =  Ad::where('id', $request['id']??$request['ad']['id'])->first();

        if ($ad->status->slug == 'active') {
            return $next($request);
        } elseif (
            $ad->status->slug == 'rejected' ||
            $ad->status->slug == 'moderation' ||
            $ad->status->slug == 'sketch'
        ) {
            $user = $request->user();
            if (
                $user->role->slug='moderator'
                || $user->id == $ad->user->id
            ) {
                return $next($request);
            }
        }


        abort(403);
    }
}
