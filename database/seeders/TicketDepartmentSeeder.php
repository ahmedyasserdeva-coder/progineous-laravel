<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketDepartment;

class TicketDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name_en' => 'Technical Support',
                'name_ar' => 'الدعم الفني',
                'description' => 'For technical issues related to hosting, servers, and services',
                'email' => 'support@' . config('app.domain', 'example.com'),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Sales',
                'name_ar' => 'المبيعات',
                'description' => 'For pre-sales questions and new service inquiries',
                'email' => 'sales@' . config('app.domain', 'example.com'),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_en' => 'Billing',
                'name_ar' => 'الفواتير والمدفوعات',
                'description' => 'For billing, payments, and invoice related queries',
                'email' => 'billing@' . config('app.domain', 'example.com'),
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name_en' => 'Domain Support',
                'name_ar' => 'دعم النطاقات',
                'description' => 'For domain registration, transfer, and DNS issues',
                'email' => 'domains@' . config('app.domain', 'example.com'),
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name_en' => 'General Inquiry',
                'name_ar' => 'استفسار عام',
                'description' => 'For general questions and other inquiries',
                'email' => 'info@' . config('app.domain', 'example.com'),
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($departments as $department) {
            TicketDepartment::updateOrCreate(
                ['name_en' => $department['name_en']],
                $department
            );
        }
    }
}
