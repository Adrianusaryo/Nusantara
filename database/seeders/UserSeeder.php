<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Psy\CodeCleaner\PassableByReferencePass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Adrianus Aryo',
            'email' => 'adrianusaryo710@gmail.com',
            'password' => Hash::make('Cristianoronaldo7')
        ]);
    }
}
