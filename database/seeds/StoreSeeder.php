<?php

use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create('ja_JP');
        for($i = 0;$i < 30; $i ++)
        {
            DB::table('stores')->insert([
                'user_id' => $faker->numberBetween(1,10),
                'description' => $faker->realText,
                'likes' => $faker->numberBetween(10,100),
                'normals' => $faker->numberBetween(10,100),
                'unlikes' => $faker->numberBetween(10,100),
                'follows' => $faker->numberBetween(10,100),
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
