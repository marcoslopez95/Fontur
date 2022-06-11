<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 100; $i++) {
            $array =[
                'placa' => $faker->unique()->word(),
                'type_fuel' => $faker->randomElement(['Gasolina','Diesel']),
                'num_controller' => $faker->regexify('[A-Z]{5}[0-9]{5}[a-z]{5}'),
            ];
            DB::table('vehicles')
                ->insertGetId($array);
        }
    }
}
