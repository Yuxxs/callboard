<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Регистрация нового пользователя',
                'slug' => 'register',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Авторизация',
                'slug' => 'authorisation',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Просмотр объявлений',
                'slug' => 'browsing_ad',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Поиск объявлений',
                'slug' => 'find_ad',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Создание объявления',
                'slug' => 'create_ad',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Отправка объявления на модерацию',
                'slug' => 'send_ad_to_moderation',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Модерация',
                'slug' => 'moderation',
            ]
        );
        DB::table('permissions')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Редактирование объявления',
                'slug' => 'ad_edit',
            ]
        );

    }
}
