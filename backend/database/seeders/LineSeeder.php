<?php

namespace Database\Seeders;

use App\Models\Line;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

        for ($i=0; $i < 50; $i++) {
            $array =[
                'name' => $faker->word(),
                'rif'  => $faker->unique()->regexify('[a-z]{2}[0-9]{1}[A-Z]{2}[0-9]{2}'),
                'municipality_id' => $faker->randomElement(range(250,258))
            ];
            DB::table('lines')
                ->insertGetId($array);
        }
    }
}
