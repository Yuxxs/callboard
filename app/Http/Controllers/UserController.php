<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $ads = Auth::user()->ads();
        return view('user/home',['ads'=>$ads]);
    }
    public function saveAd(Request $request){
        dd($request->all());
        //return redirect(route('user.home'));
    }
    public function editAd(Request $request){
        if($request->has('category_id'))
        {
            
        }
        return view('user.edit_ad');
    }
    public function adChooseCategory(Request $request){
        if($request->has('id'))
        {
            $categories = Category::where('id',$request['id'])->get();
            if(count($categories[0]->children)==0){
                return redirect(route('user.edit_ad',['category_id'=>$request['id']]));
            }
        }
        else $categories = Category::all()->whereNull('parent_id');
        return view('user.choose_category',['categories'=>$categories]);
    }
}
