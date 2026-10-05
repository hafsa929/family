<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['phone' => '0912345678'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('12345678'),
                'status' => 'active',
                'is_admin' => true,
            ]
        );
    }
}
