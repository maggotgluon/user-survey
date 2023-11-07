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
            'name' => 'admin',
            'email' => 'admin@mag.codes',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@mag.codes',
        ]);


        \App\Models\question::create([
            'Question' => 'demo question',
            'status' => true,
        ]);
        \App\Models\question::create([
            'Question' => 'production question',
            'status' => false,
        ]);

        $location = 'locker';
        \App\Models\answer::factory(90)->create([
            'socre'=>5, 'Location' => $location,
        ]);
        \App\Models\answer::factory(36)->create([
            'socre'=>4, 'Location' => $location,
        ]);
        \App\Models\answer::factory(17)->create([
            'socre'=>3, 'Location' => $location,
        ]);
        \App\Models\answer::factory(7)->create([
            'socre'=>2, 'Location' => $location,
        ]);
        \App\Models\answer::factory(17)->create([
            'socre'=>1, 'Location' => $location,
        ]);

        $location = 'retail';
        \App\Models\answer::factory(21)->create([
            'socre'=>5, 'Location' => $location,
        ]);
        \App\Models\answer::factory(10)->create([
            'socre'=>4, 'Location' => $location,
        ]);
        \App\Models\answer::factory(5)->create([
            'socre'=>3, 'Location' => $location,
        ]);
        \App\Models\answer::factory(1)->create([
            'socre'=>2, 'Location' => $location,
        ]);
        \App\Models\answer::factory(10)->create([
            'socre'=>1, 'Location' => $location,
        ]);

        $location = 'food court';
        \App\Models\answer::factory(97)->create([
            'socre'=>5, 'Location' => $location,
        ]);
        \App\Models\answer::factory(19)->create([
            'socre'=>4, 'Location' => $location,
        ]);
        \App\Models\answer::factory(5)->create([
            'socre'=>3, 'Location' => $location,
        ]);
        \App\Models\answer::factory(8)->create([
            'socre'=>2, 'Location' => $location,
        ]);
        \App\Models\answer::factory(21)->create([
            'socre'=>1, 'Location' => $location,
        ]);
    }
}
