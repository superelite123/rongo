<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class NotificationSeeder extends Seeder
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
            DB::table('notifications')->insert([
                'receiver' => $faker->numberBetween(1,10),
                'icon' => $faker->numberBetween(0,3).'.png',
                'title' => $faker->realText,
                'body' => $faker->realText,
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
