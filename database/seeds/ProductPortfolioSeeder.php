<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductPortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        DB::table('product_portfolio')->insert([
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ],
            [
                'product_id' => $faker->numberBetween(1,26),
                'order' => $faker->numberBetween(1,26),
                'filename' => $faker->randomDigit.'.png',
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]
        ]);
    }
}
