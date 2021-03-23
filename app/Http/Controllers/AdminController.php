<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{


    public function index()
    {
        $users = User::all();
        $ads = Ad::whereHas('status', function ($query) {
            $query->where('slug', 'moderation')->orWhere('slug', 'rejected');;
        })->get();
        return view('admin.home', ['users' => $users
            , 'ads' => $ads]);
    }

    public function editUser($id = null)
    {
        $user = User::find($id);
        if (!$user) {
            $user = new User();
            $user->role()->associate(Role::where('slug', 'user')->first());
            $user->status()->associate(UserStatus::where('slug', 'waiting')->first());
        }

        $roles = Role::all();
        $statuses = UserStatus::all();
        return view('admin.edit_user', ['statuses' => $statuses, 'user' => $user, 'roles' => $roles]);
    }


    private function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:60'],
            'surname' => ['required', 'string', 'max:60'],
            'middlename' => ['string', 'max:60','nullable'],
            'phone' => ['required', 'string', 'max:16'],
            'email' => ['required', 'string', 'email', 'max:60'],
            'password' => ['string', 'max:60', 'min:8', 'confirmed'],
        ]);
    }

    public function deleteUser($id)
    {
        User::find($id)->delete();
        return redirect(route('admin.home'));
    }

    public function saveUser(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::find($request['id']);

        if (is_null($user)) {
            $user = new User([
                'name' => $request['name'],
                'surname' => $request['surname'],
                'middlename' => $request['middlename'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
        } else {
            $user->update([
                'name' => $request['name'],
                'surname' => $request['surname'],
                'middlename' => $request['middlename'],
                'phone' => $request['phone'],
                'email' => $request['email'],
            ]);
        }
        $role = Role::where('slug', $request['role'])->first();
        $status = UserStatus::where('slug', $request['status'])->first();

        $user->role()->associate($role);
        $user->status()->associate($status);

        $user->save();
        return redirect(route('admin.home'));
    }


    public function saveCategory(Request $request, $id = null)
    {
        $data = $request->all();
        $category = Category::find($id);

        if ($category) {
            Validator::make($data, Category::rules($id))->validate();
            $category->update([
                'name' => $request['name'],
                'slug' => $request['slug'],
                'description' => $request['description']
            ]);
        } else {
            Validator::make($data, Category::rules())->validate();
            $parent = Category::find($request['parent_id']);
            $level = 0;
            if ($parent) {
                $cur = $parent;

                while ($cur) {
                    $cur = $cur->parent;
                    $level += 1;
                }



            }
            $category = new Category([
                'name' => $request['name'],
                'slug' => $request['slug'],
                'description' => $request['description'],
                'level'=>$level
            ]);
            $category->parent()->associate($parent);
        }
        $category->save();
        return redirect(route('admin.home'));
    }

    public function deleteCategory(Request $request, $id)
    {
        Category::find($id)->delete();
        return redirect(route('admin.home'));
    }
}
