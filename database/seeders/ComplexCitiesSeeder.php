<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComplexCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = DataSeed::getCountries();
        $regions = DataSeed::getRegions();
        $cities = DataSeed::getCities();
        $countries_uuids = [];
        $regions_uuids = [];

        for ($i = 0; $i < count($countries); $i++) {
            $id = Str::uuid();
            $countries_uuids[strval($countries[$i][0])]=$id;
            DB::table('countries')->insert([
                'id' => $id,
                'name' =>  $countries[$i][1]
            ]);
        }
        for ($i = 0;$i < count($regions); $i++) {
            $id = Str::uuid();
            $regions_uuids[strval($regions[$i][0])]=$id;
            DB::table('regions')->insert([
                'id' => $id,
                'name' => $regions[$i][1],
                'country_id'=>$countries_uuids[strval($regions[$i][2])]
            ]);
        }
        for ($i = 0;$i < count($cities); $i++) {
            $id = Str::uuid();
            DB::table('cities')->insert([
                'id' => $id,
                'name' => $cities[$i][1],
                'region_id' =>$regions_uuids[strval($cities[$i][2])]
            ]);
        }

    }
}
