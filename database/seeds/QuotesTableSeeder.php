<?php

use App\Quote;
use Illuminate\Database\Seeder;

class QuotesTableSeeder extends Seeder
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
        // Save data
        for ($i = 0; $i <= 10; $i++) {
            Quote::create([
                'description' => $faker->text(),
            ]);
        }
    }
}
