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
        $faker = Faker::create();
        for($i = 0;$i < 10; $i ++)
        {
            DB::table('products')->insert([
                'label' => $faker->word,
                'number' => $faker->numberBetween(1000,100000),
                'description' => $faker->paragraph,
                'qty' => $faker->randomDigit,
                'ship_days' => $faker->randomDigit,
                'shipper_id' => $faker->randomDigit,
                'price' => $faker->randomFloat(2,0.1,1000000),
                'shipping_fee' => $faker->randomFloat(2,0.1,1000000),
            ]);
        }
    }
}
