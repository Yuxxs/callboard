<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = DataSeed::getCategories();

        for ($i = 0; $i < count($categories); $i++) {
            $id = Str::uuid();
            $categories_uuids[strval($categories[$i][0])] = $id;
            if ($categories[$i][1] != '') {
                DB::table('categories')->insert(
                    [
                        'id' => $id,
                        'parent_id' => $categories_uuids[$categories[$i][1]],
                        'name' => $categories[$i][2],
                        'slug' => $categories[$i][3],
                        'description' => $categories[$i][4],
                        'level' => $categories[$i][5],
                    ]
                );
            } else {
                DB::table('categories')->insert(
                    [
                        'id' => $id,
                        'name' => $categories[$i][2],
                        'slug' => $categories[$i][3],
                        'description' => $categories[$i][4],
                        'level' => $categories[$i][5],
                    ]
                );
            }

        }
    }
}
