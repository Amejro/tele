<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        School::insert([
            ['name' => 'SCHOOL OF ALLIED HEALTH SCIENCES (SAHS)', 'code' => 'SAHS'],
            ['name' => 'SCHOOL OF MEDICINE (SOM)', 'code' => 'SOM'],
            ['name' => 'SCHOOL OF NURSING AND MIDWIFERY (SONAM)', 'code' => 'SONAM'],
            ['name' => 'F. N. BINKA SCHOOL OF PUBLIC HEALTH (FNBSPH)', 'code' => 'FNBSPH'],
        ]);
    }
}
