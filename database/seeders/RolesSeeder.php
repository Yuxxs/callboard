<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {




        DB::table('roles')->insert(
            [
            'id' => Str::uuid(),
            'name' => 'Пользователь',
            'slug' => 'user',
            ]
        );
        Role::where('slug',  'user')->first()->permissions()->attach([
            DB::table('permissions')
                ->where('slug', '=', 'browsing_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'authorisation')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'find_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'create_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'send_ad_to_moderation')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'ad_edit')->value('id'),
        ]);

        DB::table('roles')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Модератор',
                'slug' => 'moderator',
            ]
        );
        Role::where('slug',  'moderator')->first()->permissions()->attach([
            DB::table('permissions')
                ->where('slug', '=', 'browsing_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'authorisation')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'find_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'moderation')->value('id'),

        ]);

        DB::table('roles')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Администратор',
                'slug' => 'admin',
            ]
        );
        Role::where('slug',  'admin')->first()->permissions()->attach([
            DB::table('permissions')
                ->where('slug', '=', 'browsing_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'authorisation')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'find_ad')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'register')->value('id'),
            DB::table('permissions')
                ->where('slug', '=', 'moderation')->value('id'),
        ]);
    }
}
