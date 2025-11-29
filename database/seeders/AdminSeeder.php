<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin account
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'fullname' => 'Administrator',
                'email' => 'admin@reykentraders.com',
                'password' => Hash::make('admin123'),
                'age' => 30,
                'isadmin' => true,
            ]
        );

        $this->command->info('Admin account created!');
        $this->command->info('Username: admin');
        $this->command->info('Password: admin123');
    }
}
