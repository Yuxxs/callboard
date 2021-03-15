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
        $ad = Ad::where('id', $request['id'])->first();
        if ($request->user())
            if ($request->user()->id != $ad->user->id) {
                $ad->incrementViewCount();
            }
        return view('ad', ['ad' => $ad]);
    }

    public function searchAds(Request $request)
    {
        $ads = Ad::whereHas('status', function ($query) {
            $query->where('slug', 'active');
        });

        $current_category = null;
        $current_city = null;

        $category_slug = $request["category_slug"];
        $city_slug = $request["city_slug"];
        if ($category_slug) {
            $current_category = Category::where('slug', $category_slug)->first();
            $ads = $ads->whereHas('category', function ($query) use ($category_slug) {
                $query->where('slug', $category_slug);
            });
        }

        if ($city_slug) {
            $current_city = City::where('slug', $city_slug)->first();
            $ads = $ads->whereHas('city', function ($query) use ($city_slug) {
                $query->where('slug', $city_slug);
            });
        }

        if ($request['text']) {
            $text = $request['text'];
            $ads = $ads->where(function ($q) use ($text) {
                $q->where('name', 'LIKE', "%" . $text . "%")->orWhere('description', 'LIKE', "%" . $text . "%");
            });
        }
        $ads = $ads->get();
        return view('search_ads', ['ads' => $ads, 'current_text' => $request['text'], 'current_category' => $current_category, 'current_city' => $current_city]);
    }

    public function saveAd(Request $request)
    {
        $ad = Ad::where('id', $request['id'])->first();
        $category = Category::where('id', $request['category_id'])->first();
        $city = City::where('id', $request['cities_select'])->first();

        if (is_null($ad)) {
            $ad = new Ad(
                [
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'cost' => $request['cost'],
                    'views_count' => 0
                ]
            );
            $status = AdStatus::where('slug', 'sketch')->first();
            $ad->status()->associate($status);
            $ad->user()->associate($request->user());
            $ad->city()->associate($city);
            $ad->category()->associate($category);
        } else {
            $ad->city()->associate($city);
            $ad->category()->associate($category);
            $ad->update([
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

        if ($request['ad']) {
            $ad = new Ad($request['ad']);
            if ($request['ad']['id']){
                $ad = Ad::find($request['ad']['id']);
            }

        } else {
            $ad = new Ad();
            $ad->city()->associate(City::all()->first());
        }

        if ($request['category_id']) {
            $category = Category::find($request['category_id']);
            $ad->category()->associate($category);
        }

        $imageFile = Storage::disk('public')->files('uploads/' . $request->user()->id . '/' . $ad->id);
        return view('user.edit_ad', ['ad' => $ad, 'imageFile' => $imageFile, 'cities' => $cities, 'regions' => $regions, 'countries' => $countries]);
    }

    public function deleteAd(Request $request)
    {
        Ad::where('id', $request['id'])->delete();
        return redirect(route('user.home'));
    }

    public function adChooseCategory(Request $request)
    {

        if ($request['ad'])
            $ad = new Ad($request['ad']);
        else $ad = new Ad();
        if ($request['category_id']) {
            $category = Category::find($request['category_id']);

            if (count($category->children) == 0) {
                return redirect(route('user.edit_ad', ['ad' => $ad->toArray(), 'category_id' => $request['category_id']]));
            }

            return view('user.choose_category', ['ad' => $ad, 'category' => $category]);
        } else {
            $categories = Category::all()->whereNull('parent_id');
            return view('user.choose_category', ['ad' => $ad, 'categories' => $categories]);
        }
    }

    public function sendToModeration(Request $request)
    {
        $ad = Ad::find($request['id']);
        $status = AdStatus::where('slug', 'moderation')->first();
        $ad->status()->associate($status);
        $ad->save();
        return redirect(route('ad', ['id' => $request['id']]));
    }
}
