<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create two users
        $userOne = User::create([
            'name' => 'User One',
            'email' => 'userone@example.com',
            'password' => Hash::make('password123'),
        ]);

        UserProfile::create([
            'user_id' => $userOne->id,
            'bio' => 'Hello, I am User One!',
        ]);

        $userTwo = User::create([
            'name' => 'User Two',
            'email' => 'usertwo@example.com',
            'password' => Hash::make('password123'),
        ]);

        UserProfile::create([
            'user_id' => $userTwo->id,
            'bio' => 'Hello, I am User Two!',
        ]);
    }
}

