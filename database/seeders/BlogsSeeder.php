<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BlogsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Insert fake data into the blogs table
        foreach (range(1, 10) as $index) {
            DB::table('blogs')->insert([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'author' => $faker->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}