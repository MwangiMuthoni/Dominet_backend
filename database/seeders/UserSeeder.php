<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user = User::create([
            'name' => 'Spa Admin',
            'phone' => '+254700000000',
            'email' => 'admin@spa.com',
            'password' => Hash::make('spa101'),
            'role_id' => 1
        ]);

        $user->syncRoles(['Super Admin']);

        $permissions = array();
        foreach ($user->role->permissions as $permission) {
            $permissions[] = $permission->name;
        }
        $user->syncPermissions($permissions);

        // //Teacher
        // $teacher = User::create([
        //     'name' => 'Test Teacher',
        //     'phone' => '+254700000000',
        //     'email' => 'teacher@spa.com',
        //     'password' => Hash::make('spa101'),
        //     'role_id' => 2
        // ]);

        // $teacher->syncRoles(['Teacher']);

        // $permissions = array();
        // foreach ($teacher->role->permissions as $permission) {
        //     $permissions[] = $permission->name;
        // }
        // $teacher->syncPermissions($permissions);

        // //Guardian
        // $guardian = User::create([
        //     'name' => 'Test Guardian',
        //     'phone' => '+254700000000',
        //     'email' => 'guardian@spa.com',
        //     'password' => Hash::make('spa101'),
        //     'role_id' => 3
        // ]);

        // $guardian->syncRoles(['Guardian']);

        // $permissions = array();
        // foreach ($guardian->role->permissions as $permission) {
        //     $permissions[] = $permission->name;
        // }
        // $guardian->syncPermissions($permissions);

        // //Student
        // $student = User::create([
        //     'name' => 'Test Student',
        //     'phone' => '+254700000000',
        //     'email' => 'student@spa.com',
        //     'password' => Hash::make('spa101'),
        //     'role_id' => 4
        // ]);

        // $student->syncRoles(['Student']);

        // $permissions = array();
        // foreach ($student->role->permissions as $permission) {
        //     $permissions[] = $permission->name;
        // }
        // $student->syncPermissions($permissions);

    }
}
