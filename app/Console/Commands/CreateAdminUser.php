<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin-user {username} {email} {password}';

    protected $description = 'Create an admin user for CodeArena';

    public function handle()
    {
        $email = (string) $this->argument('email');

        if (Admin::where('email', $email)->exists()) {
            $this->error('Admin with this email already exists.');
            return self::FAILURE;
        }

        Admin::create([
            'username' => (string) $this->argument('username'),
            'email' => $email,
            'hashed_password' => Hash::make((string) $this->argument('password')),
            'is_active' => true,
        ]);

        $this->info('Admin user created.');
        return self::SUCCESS;
    }
}
