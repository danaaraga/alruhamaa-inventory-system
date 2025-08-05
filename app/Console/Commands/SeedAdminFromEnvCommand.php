<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SeedAdminFromEnvCommand extends Command
{
    protected $signature = 'admin:seed';
    protected $description = 'Create admin from environment variables';

    public function handle()
    {
        $name = env('ADMIN_NAME');
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$name || !$email || !$password) {
            $this->error('Environment variables tidak lengkap!');
            $this->error('Pastikan ADMIN_NAME, ADMIN_EMAIL, dan ADMIN_PASSWORD sudah diset di .env');
            return;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('Admin dengan email tersebut sudah ada!');
            return;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->info('Admin berhasil dibuat dari environment variables!');
    }
}