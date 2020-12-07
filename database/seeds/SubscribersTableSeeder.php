<?php

use Illuminate\Database\Seeder;
use App\Subscriber;
use App\Helpers\Constant;

class SubscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Faker
        $faker = Faker\Factory::create();
        // Array (statuses)
        $status = [Constant::ACTIVE_STATUS, Constant::INACTIVE_STATUS, Constant::UNPAID_STATUS];
        // Save data
        for ($i = 0; $i <= 5; $i++) {
           Subscriber::create([
                'email' => $faker->email(),
                'status' => $status[rand(0,2)],
            ]);
        }
        // My acc
        Subscriber::create([
            'email' => 'nikolaidjos1@gmail.com',
            'status' => 'ACTIVE',
        ]);
    }
}
