<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user =  User::create([
            'fname' => 'Sylvester',
            'lname' => 'Umole',
            'email' => 'sly.umole@gmail.com',
            'dept' => 'IT & Admin',
            'designation' => 'HOD',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $role = Role::create(['name' => 'Super Admin']);

        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
