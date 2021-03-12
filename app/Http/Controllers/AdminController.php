<?php

namespace App\Http\Controllers;

use App\Models\Ad;
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
            $query->where('slug', 'moderation')->orWhere('slug','rejected');;
        })->get();
        return view('admin.home', ['users' => $users
        ,'ads'=>$ads]);
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


    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:60'],
            'surname' => ['required', 'string', 'max:60'],
            'middlename' => ['string', 'max:60'],
            'phone' => ['required', 'string', 'max:16' ],
            'email' => ['required', 'string', 'email', 'max:60'],
            'password' => [ 'string', 'max:60','min:8', 'confirmed'],
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
            $user = new User( [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'middlename' => $request['middlename'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
        } else {
            $user->update( [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'middlename' => $request['middlename'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
        }
        $role = Role::where('slug', $request['role'])->first();
        $status = UserStatus::where('slug', $request['status'])->first();

        $user->role()->associate($role);
        $user->status()->associate($status);

        $user->save();
        return redirect(route('admin.home'));
    }
}
