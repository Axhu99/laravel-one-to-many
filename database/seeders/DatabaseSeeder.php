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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Giulia',
            'email' => 'giulia@ciao.com',
        ]);

        $this->call(CategorySeeder::class);

        \App\Models\Project::factory(14)->create();
    }
}
