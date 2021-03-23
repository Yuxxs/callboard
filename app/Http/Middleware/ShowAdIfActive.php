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
        $ad =  Ad::withTrashed()->find($request['id']??$request['ad']['id']);

        if ($ad->status->slug == 'active') {
            return $next($request);
        } elseif (
            $ad->status->slug == 'rejected' ||
            $ad->status->slug == 'moderation' ||
            $ad->status->slug == 'sketch' ||
            $ad->status->slug == 'removed'
        ) {
            $user = $request->user();
            if($user)
            if (
                $user->role->slug='moderator'
                || $user->role->slug='admin'
                || $user->id == $ad->user->id
            ) {
                return $next($request);
            }
        }


        abort(403);
    }
}
