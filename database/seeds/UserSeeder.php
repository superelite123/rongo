<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('ja_JP');
        for($i = 0;$i < 10; $i ++)
        {
            DB::table('users')->insert([
                'nickname' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'phone_number' => $faker->phoneNumber,
                'type' => $faker->numberBetween(1,2),
                'firstname_h' => $faker->firstKanaName,
                'lastname_h' => $faker->KanaName,
                'firstname_k' => $faker->firstKanaName,
                'lastname_k' => $faker->lastKanaName,
                'address_id' => 1,
                'created_at' => $faker->dateTimeBetween('2020-06-05 23:59:68','2020-01-05 00:00:00'),
                'updated_at' => $faker->dateTimeBetween( '2020-06-05 23:59:68','2020-01-05 00:00:00'),
            ]);
        }
    }
}
