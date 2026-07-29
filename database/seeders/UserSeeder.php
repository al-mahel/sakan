<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'أحمد محمد',     'email' => 'ahmed@student.com'],
            ['name' => 'فاطمة علي',      'email' => 'fatma@student.com'],
            ['name' => 'محمد إبراهيم',   'email' => 'mohamed@student.com'],
            ['name' => 'نورهان خالد',    'email' => 'nourhan@student.com'],
            ['name' => 'عمر حسن',        'email' => 'omar@student.com'],
            ['name' => 'مريم سامي',      'email' => 'mariam@student.com'],
            ['name' => 'يوسف طارق',      'email' => 'youssef@student.com'],
            ['name' => 'سارة أحمد',      'email' => 'sara@student.com'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name'     => $user['name'],
                    'password' => Hash::make('password123'),
                    'is_admin' => false,
                ]
            );
        }

        $this->command->info('✅ تم إنشاء ' . count($users) . ' مستخدم بنجاح');
    }
}
