<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء المشرف الرئيسي
        Admin::create([
            'name' => 'المدير العام',
            'email' => 'admin@progineous.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        // إنشاء مشرف فرعي للاختبار
        Admin::create([
            'name' => 'أحمد محمد',
            'email' => 'ahmed@progineous.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
