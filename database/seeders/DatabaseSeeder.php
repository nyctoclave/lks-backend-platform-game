<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'username' => 'player1',
            'password' => Hash::make('helloworld1')
        ]);

        User::create([
            'username' => 'player2',
            'password' => Hash::make('helloworld2')
        ]);

        Admin::create([
            'username' => 'admin1',
            'password' => Hash::make('hellouniverse1')
        ]);

        Admin::create([
            'username' => 'admin2',
            'password' => Hash::make('hellouniverse2')
        ]);

        Game::create([
            'title' => 'GTA IV',
            'description' => 'this is GTA V',
            'slug' => 'dsadsa-dsadassss',
            'thumbnail' => asset('download.jpeg'),
        ]);

        Game::create([
            'title' => 'GTA X',
            'description' => 'this is GTA X',
            'slug' => 'dsadsa-ddsasd',
            'thumbnail' => asset('download.jpeg'),
        ]);

        Game::create([
            'title' => 'GTA San Andreas',
            'description' => 'this is GTA San Andreas',
            'slug' => 'dsadsa-dsadas',
            'thumbnail' => asset('download.jpeg'),
        ]);
       


    }
}
