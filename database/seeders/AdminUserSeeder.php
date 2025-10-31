<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mugduck.ru',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'points' => 1000,
            'avatar' => 'images/user-info/avatars/default-avatar.png',
            'email_verified_at' => now(),
        ]);


        User::create([
            'name' => 'Test User',
            'email' => 'user@mugduck.ru',
            'password' => Hash::make('user123'),
            'is_admin' => false,
            'points' => 500,
            'avatar' => 'images/user-info/avatars/default-avatar.png',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Администратор и тестовый пользователь созданы!');
        $this->command->info('Email: admin@mugduck.ru');
        $this->command->info('Password: admin123');
        $this->command->info('Обязательно смените пароль после первого входа!');
    }
}
