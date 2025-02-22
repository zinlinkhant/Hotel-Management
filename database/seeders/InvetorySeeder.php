<?php

namespace Database\Seeders;

use App\Models\Invetory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvetorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invetory::factory()->count(50)->create();
    }
}
