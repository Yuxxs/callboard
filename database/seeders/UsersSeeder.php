<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$role = Role::where('slug',  'admin')->first();
        //$status = UserStatus::where('slug',  'active')->first();
        $role_id = DB::table('roles')
            ->where('slug', '=', 'admin')->value('id');
        $status_id = DB::table('user_statuses')
            ->where('slug', '=', 'active')->value('id');
        DB::table('users')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Em',
                'surname' => 'All',
                'role_id' => $role_id,
                'status_id' => $status_id,
                'phone'=>'89278067745',
                'email'=>'admin@example.com',
                'email_verified_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                'password'=>bcrypt('admin'),
                'phone_calls_time'=>'timetimetime',

            ]
        );
    }
}
