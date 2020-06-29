<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class NewsSeeder extends Seeder
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
            DB::table('news')->insert([
                'receiver' => $faker->numberBetween(1,10),
                'title' => $faker->realText,
                'body' => $faker->realText,
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
