<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupervisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehiculos = Vehicle::all();
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 100; $i++) {
            $array =[
                'fecha'=>$faker->date(),
                'vehicle_id' => ($vehiculos->random())->id,
                'activo'=> $faker->randomElement([true,false])
            ];
            DB::table('supervisions')
                ->insertGetId($array);
        }
    }
}
