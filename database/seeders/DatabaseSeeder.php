<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'consumer',
            'state' => 'Niger',
            'password' => bcrypt('mynumber'), 
        ]);

        User::factory()->create([
            'name' => 'Ministry Admin',
            'email' => 'admin@agriculture.gov.ng',
            'role' => 'admin',
            'state' => 'Abuja',
            'password' => bcrypt('mynumber'), 
            
        ]);
        User::factory()->create([
            'name' => 'Han Zho',
            'email' => 'adminzho@agriculture.gov.ng',
            'role' => 'admin',
            'state' => 'Kano',
            'password' => bcrypt('mynumber'), 
            
        ]);
        User::factory()->create([
            'name' => 'Depot Officer',
            'email' => 'depot_officer@agriculture.gov.ng',
            'role' => 'depot_officer',
            'state' => 'Niger',
            'password' => bcrypt('mynumber'), 
        ]);
    }
}
