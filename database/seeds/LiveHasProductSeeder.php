<?php

use Illuminate\Database\Seeder;

class LiveHasProductSeeder extends Seeder
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
            DB::table('live_has_product')->insert([
                'live_id' => $faker->numberBetween(1,30),
                'product_id' => $faker->numberBetween(1,30),
                'qty' => $faker->numberBetween(5,10),
                'sold_qty' => $faker->numberBetween(1,7),
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
