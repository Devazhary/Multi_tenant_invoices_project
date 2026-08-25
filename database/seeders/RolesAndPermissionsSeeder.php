<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permissions
        $permissions = [
            'الفواتير',
            'قائمة الفواتير',
            'إضافة فاتورة',
            'تعديل فاتورة',
            'حذف فاتورة',
            'تصدير اكسيل',
            'حالة الدفع',
            'ارشيف فاتورة',
            'الغاء ارشيف فاتورة',
            'طباعة فاتورة',
            'الفواتير المدفوعة',
            'الفواتير الغير مدفوعة',
            'الفواتير المدفوعة جزئيا',
            'قائمة الفواتير المؤرشفة',
            'حذف الفواتير المؤرشفة',
            'الاعدادات',
            'الاقسام',
            'المنتجات',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
            'التقارير',
            'تقرير الفواتير',
            'تقرير العملاء',
            'المستخدمين',
            'قائمة المستخدمين',
            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',
            'صلاحيات المستخدمين',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Roles
        $admin = Role::firstOrCreate([
            'name' => 'مدير النظام',
            'guard_name' => 'web',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'مدير',
            'guard_name' => 'web',
        ]);

        $invoice_employee = Role::firstOrCreate([
            'name' => 'موظف فواتير',
            'guard_name' => 'web',
        ]);

        $inventory_employee = Role::firstOrCreate([
            'name' => 'موظف مخزن',
            'guard_name' => 'web',
        ]);

        $accountant = Role::firstOrCreate([
            'name' => 'محاسب',
            'guard_name' => 'web',
        ]);

        //admin
        $admin->syncPermissions($permissions);

        //manager
        $manager->syncPermissions([
            'الفواتير',
            'قائمة الفواتير',
            'إضافة فاتورة',
            'تعديل فاتورة',
            'حذف فاتورة',
            'تصدير اكسيل',
            'حالة الدفع',
            'ارشيف فاتورة',
            'الغاء ارشيف فاتورة',
            'طباعة فاتورة',
            'الفواتير المدفوعة',
            'الفواتير الغير مدفوعة',
            'الفواتير المدفوعة جزئيا',
            'قائمة الفواتير المؤرشفة',
            'الاقسام',
            'المنتجات',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
            'التقارير',
            'تقرير الفواتير',
            'تقرير العملاء',
        ]);

        $invoice_employee->syncPermissions([
            'الفواتير',
            'قائمة الفواتير',
            'إضافة فاتورة',
            'تعديل فاتورة',
            'تصدير اكسيل',
            'حالة الدفع',
            'طباعة فاتورة',
            'الفواتير المدفوعة',
            'الفواتير الغير مدفوعة',
            'الفواتير المدفوعة جزئيا',
        ]);

        $inventory_employee->syncPermissions([
            'الاقسام',
            'المنتجات',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
        ]);

        $accountant->syncPermissions([
            'الفواتير',
            'قائمة الفواتير',
            'تصدير اكسيل',
            'حالة الدفع',
            'طباعة فاتورة',
            'الفواتير المدفوعة',
            'الفواتير الغير مدفوعة',
            'الفواتير المدفوعة جزئيا',
            'قائمة الفواتير المؤرشفة',
            'التقارير',
            'تقرير الفواتير',
        ]);

        // Create Tenant1 User
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'tenant1@gmail.com'],
            [
                'name' => 'Tenant1',
                'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
                'status' => 'active',
            ]
        );

        // Assign Admin Role to User
        $user->assignRole($admin);
    }
}
