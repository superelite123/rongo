<?php

use Illuminate\Database\Seeder;

class StoreUserFollow extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');
        for($i = 0;$i < 30; $i ++)
        {
            DB::table('store_user_follow')->insert([
                'user_id' => $faker->numberBetween(1,10),
                'store_id' => $faker->numberBetween(1,30),
                'type' => $faker->numberBetween(1,2),
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
