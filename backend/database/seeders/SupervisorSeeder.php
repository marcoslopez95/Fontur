<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 20; $i++) {
            $array =[
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'ci' => $faker->unique()->regexify('[a-z]{2}[0-9]{1}[A-Z]{2}[0-9]{2}'),
                'regional' => $faker->randomElement([true,false]),
                'municipality_id' => $faker->randomElement(range(250,258))
            ];
            DB::table('supervisors')
                ->insertGetId($array);
        }
    }
}
