<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use App\Models\Ad;
use App\Models\AdStatus;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdController extends Controller
{
    
    public function index(Request $request)
    {
        $ad=Ad::where('id',$request['id'])->first();
        return view('ad', ['ad' => $ad]);
    }
    
    public function saveAd(Request $request)
    {
        $ad = Ad::where('id', $request['id'])->first();
        
        $category = Category::where('id', $request['category_id'])->first();
        $city = City::where('id', $request['cities_select'])->first();
        if (is_null($ad)) {
            $ad = new Ad(
            [
                'id' => $request['id'],
                'name' => $request['name'],
                'description' => $request['description'],
                'cost' => $request['cost'],
                'views_count'=>0
            ]);
            $status = AdStatus::where('slug', 'sketch')->first();
            $ad->status()->associate($status);
            $ad->user()->associate( $request->user());
            $ad->city()->associate($city);
            $ad->category()->associate($category);
        } else {
            $ad->city()->associate($city);
            $ad->category()->associate($category);
            $ad->update([
                'id' => $request['id'],
                'name' => $request['name'],
                'description' => $request['description'],
                'cost' => $request['cost'],
            ]);
            
            $files = Storage::disk('public')->files('uploads/' . $request->user()->id . '/' . $ad->id);
            Storage::disk('public')->delete($files);
        }
        $ad->save();
        if ($request->hasfile('imageFile')) {
            $images = $request->file('imageFile');

            foreach ($images as $image) {
                $name = $image->getClientOriginalName();
                $image->storeAs('uploads', $request->user()->id . '/' . $ad->id . '/' . $name, 'public');
            }
        }

        return redirect(route('user.home'));
    }

    public function editAd(Request $request)
    {
        $cities = City::all();
        $regions = Region::all();
        $countries = Country::all();
        
        $ad = new Ad($request['ad']);     
        $imageFile =Storage::disk('public')->files('uploads/'.$request->user()->id.'/'.$ad->id);
        return view('user.edit_ad', ['ad' => $ad,'imageFile'=>$imageFile, 'cities' => $cities, 'regions' => $regions, 'countries' => $countries]);
    }
    public function deleteAd(Request $request)
    {
        Ad::where('id', $request['id'])->delete();
        return redirect(route('user.home'));
    }
    public function adChooseCategory(Request $request)
    {
       
        if ($request->has('ad')) {
            $ad = new Ad($request['ad']);
        } else {
            $ad = new Ad(['id' => strval(Str::uuid())]);
            $ad->city()->associate(City::all()->first());   
        }
        
        if ($request->has('category_id')) {
            $category = Category::where('id', $request['category_id'])->first();
            
            if (count($category->children) == 0) {
                $ad->category()->associate($category);
                return redirect(route('user.edit_ad', ['ad' => $ad->toArray()]));
            }
            return view('user.choose_category', ['ad' => $ad->toArray(),'category' => $category]);
        } else {
            $categories = Category::all()->whereNull('parent_id');
            return view('user.choose_category', ['ad' => $ad->toArray(),'categories' => $categories]);
        }
        
    }

    public function sendToModeration(Request $request){
        $ad=Ad::where('id', $request['id'])->first();
        $status = AdStatus::where('slug','moderation')->first();
        $ad->status()->associate($status);
        $ad->save();
        return redirect(route('ad',['id'=>$request['id']]));
    }
}
