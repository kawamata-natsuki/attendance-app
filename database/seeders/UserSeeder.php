<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => '西 怜奈',
                'email' => 'reina.n@example.com',
            ],
            [
                'name' => '山田 太郎',
                'email' => 'taro.y@example.com',
            ],
            [
                'name' => '増田 一世',
                'email' => 'issei.m@example.com',
            ],
            [
                'name' => '山田 敬吉',
                'email' => 'keikichi.y@example.com',
            ],
            [
                'name' => '秋田 朋美',
                'email' => 'tomomi.a@example.com',
            ],
            [
                'name' => '中西 教夫',
                'email' => 'norio.n@example.com',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => '12345678',
                    'email_verified_at' => now(),
                ]
            );
        }

        // 管理者ユーザー
        Admin::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'ADMIN',
                'password' => 'admin123',
                'email_verified_at' => now(),
            ]
        );
    }
}
