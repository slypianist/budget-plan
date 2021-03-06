<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-show',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'budget-list',
            'budget-create',
            'budget-edit',
            'budget-delete',
            'budget-clear',
            'expense-list',
            'expense-create',
            'expense-edit',
            'expense-delete',
            'hod-approval',
            'cfo-approval',
            'md-approval',
            'hod-comment',
            'bo-comment',
            'cfo-comment',
            'md-comment',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);

        }
    }
}
