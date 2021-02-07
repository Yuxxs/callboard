<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\Moderation;
use App\Models\Role;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ModeratorController extends Controller
{
    public function index()
    {
        $ads = Ad::whereHas('status', function ($query) {
            $query->where('slug', 'moderation')->orWhere('slug','rejected');;
        })->get();

        return view('moderator.home',['ads'=>$ads]);
    }

    public function moderation(Request $request)
    {
        $ad = Ad::where('id',$request['id'])->first();
       
        return view('moderator.moderation',['ad'=>$ad]);
    }
    public function createModeration(Request $request)
    {
        $ad = Ad::where('id',$request['id'])->first();
        $status= AdStatus::where('slug','rejected')->first();
        $ad->status()->associate($status);
        $ad->save();

        $moderation = new Moderation([
            'id'=>Str::uuid(),
            'reason'=>$request['reason'],
            'publish'=>false,
        ]);

        $moderation->ad()->associate($ad);
        $moderation->user()->associate($request->user());
        $previous_moderation = $ad->moderations()->latest()->first();

        if($previous_moderation!=null){
            $moderation->oldVersion()->associate($previous_moderation);
        }

        $moderation->save();

        return redirect(route('ad.moderation',['id'=>$request['id']]));
    }
    public function publishAd(Request $request)
    {
        $ad = Ad::where('id',$request['id'])->first();
        $status= AdStatus::where('slug','active')->first(); 
        $ad->status()->associate($status);
        $ad->update(['created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        $ad->save();
        
        $moderation = new Moderation([
            'id'=>Str::uuid(),
            'reason'=>'Обьявление допущено к публикации',
            'publish'=>true,
        ]);

        $moderation->ad()->associate($ad);
        $moderation->user()->associate($request->user());
        $previous_moderation = $ad->moderations()->latest()->first();

        if($previous_moderation!=null){
            $moderation->oldVersion()->associate($previous_moderation);
        }

        $moderation->save();
        return redirect(route('moderator.home'));
    }
}
