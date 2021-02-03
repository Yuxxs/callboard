<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('ad_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Черновик',
                'slug' => 'sketch',
            ]
        );
        DB::table('ad_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'На модерации',
                'slug' => 'moderation',
            ]
        );
        DB::table('ad_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Отклонено, к доработке',
                'slug' => 'rejected',
            ]
        );
        DB::table('ad_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Снято, продано',
                'slug' => 'removed',
            ]
        );
        DB::table('ad_statuses')->insert(
            [
                'id' => Str::uuid(),
                'name' => 'Активно',
                'slug' => 'active',
            ]
        );
    }
}
