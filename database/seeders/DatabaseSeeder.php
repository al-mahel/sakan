<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UniversitySeeder::class,
            UserSeeder::class,
            PropertySeeder::class,
            UniversityCommentSeeder::class,
        ]);
    }
}
