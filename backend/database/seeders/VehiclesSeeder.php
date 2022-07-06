<?php

namespace Database\Seeders;

use App\Models\Line;
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
        $lines = Line::all();
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 100; $i++) {
            $array =[
                'placa' => $faker->unique()->word(),
                'type_fuel' => $faker->randomElement(['Gasolina','Diesel']),
                'num_controller' => $faker->regexify('[A-Z]{5}[0-9]{5}[a-z]{5}'),
                'line_id'   => ($lines->random())->id
            ];
            DB::table('vehicles')
                ->insertGetId($array);
        }
    }
}
