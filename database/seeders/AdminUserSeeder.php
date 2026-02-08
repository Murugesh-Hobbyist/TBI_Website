<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Never seed predictable admin credentials by default.
        // If you want to seed via `php artisan db:seed`, set ADMIN_EMAIL and ADMIN_PASSWORD in .env.
        $email = (string) env('ADMIN_EMAIL', '');
        $password = (string) env('ADMIN_PASSWORD', '');
        $name = (string) env('ADMIN_NAME', 'Admin');

        if ($email === '' || $password === '') {
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );
    }
}
