<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserStatus;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;


    protected function redirectTo(): string
    {
        if(Auth::user()->role->slug=='user')
            return route('user_home');
        elseif(Auth::user()->role->slug=='moderator')
            return route('moderator_home');
        elseif(Auth::user()->role->slug=='admin')
            return route('admin_home');
        else return route('login');
    }
    public function authorize(Request $request)
    {
        if (! hash_equals((string) $request->route('id'),
            (string) $request->user()->getKey())) {
            return false;
        }

        if (! hash_equals((string) $request->route('hash'),
            sha1($request->user()->getEmailForVerification()))) {
            return false;
        }

        return true;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
