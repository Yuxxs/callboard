<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Активен',
                'slug' => 'active',
            ]
        );
        DB::table('user_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Заблокирован',
                'slug' => 'blocked',
            ]
        );
        DB::table('user_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Ожидает активации email',
                'slug' => 'waiting',
            ]
        );

    }
}
