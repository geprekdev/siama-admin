<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            User::create([
                'name' => 'Test',
                'username' => 'test',
                'role' => 'ADMIN',
                'password' => bcrypt('password')
            ]);

            User::create([
                'name' => 'Test 1',
                'username' => 'test1',
                'role' => 'KURIKULUM',
                'password' => bcrypt('password')
            ]);

            User::create([
                'name' => 'Test 2',
                'username' => 'test2',
                'role' => 'KARYAWAN',
                'password' => bcrypt('password')
            ]);
        }
    }
}
