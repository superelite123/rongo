<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        for($i = 0;$i < 30; $i ++)
        {
            DB::table('products')->insert([
                'store_id' => $faker->numberBetween(1,10),
                'label' => $faker->name,
                'number' => $faker->numberBetween(1000,100000),
                'description' => $faker->realText,
                'qty' => $faker->randomDigit,
                'price' => $faker->randomFloat(2,0.1,100000),
                'ship_days' => $faker->randomDigit,
                'shipper_id' => $faker->randomDigit,
                'shipping_fee' => $faker->randomFloat(2,0.1,310),
                'status_id' => $faker->numberBetween(1,7),
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
