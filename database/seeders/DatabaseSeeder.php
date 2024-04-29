<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        // $this->call(ProvinsiSeeder::class);
        // $this->call(KabupatenSeeder::class);
        // $this->call(KecamatanSeeder::class);
        // $this->call(DesaSeeder::class);
    }
}
