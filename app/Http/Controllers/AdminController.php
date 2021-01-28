<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{


    public function index()
    {
        $users = User::all();
        return view('admin.home',['users'=>$users]);
    }

    public function showRegistrationForm()
    {
        $roles = Role::all();
        return view('admin.register_user',['roles'=>$roles]);
    }


    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:60'],
            'surname' => ['required', 'string', 'max:60'],
            'middlename' => ['required', 'string', 'max:60'],
            'phone' => ['required', 'string', 'max:16', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    protected function registerUser(Request $request)
    {
        $this->validator($request->all())->validate();

        $data = $request->all();
        $user = new User([
            'id' =>Str::uuid(),
            'name' => $data['name'],
            'surname' => $data['surname'],
            'middlename' => $data['middlename'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $role = Role::where('slug',$data['role'])->first();
        if($request->has('waiting')) {
            $status = UserStatus::where('slug', 'waiting')->first();
        }
        else{
            $status = UserStatus::where('slug', 'active')->first();
        }
        $user->role()->associate($role);
        $user->status()->associate($status);
        $user->save();
        return redirect(route('admin.home'));
    }

}
