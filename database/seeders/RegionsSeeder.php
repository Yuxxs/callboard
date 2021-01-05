<?php

namespace Database\Seeders;

use App\Models\Region;
<<<<<<< HEAD

use Illuminate\Database\Seeder;


=======
use Cassandra\Uuid;
use Illuminate\Database\Seeder;

>>>>>>> develop
class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $data = DataSeed::getRegions();
        for ($i = 0; $i < sizeof($data); $i++) {
            Region::create([
<<<<<<< HEAD

=======
                'id'=> Uuid::generate($data[$i][0]),
>>>>>>> develop
                'name' => $data[$i][1]
            ]);
        }
    }

}
