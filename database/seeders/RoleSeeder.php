<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role=Role::create(['name' => 'Super admin', 'guard_name' => 'api']);

        $role->syncPermissions([
            'View company',
            'Create company',
            'Edit company',
            'Delete company',

            'View package',
            'Create package',
            'Edit package',
            'Delete package',

            'View bill',
            'Create bill',
            'Edit bill',
            'Delete bill',

            'View payment',
            'Create payment',
            'Edit payment',
            'Delete payment',

            'View subscription',
            'Create subscription',
            'Edit subscription',
            'Delete subscription',

            'View prototype',
            'Create prototype',
            'Edit prototype',
            'Delete prototype', 

            'View user',
            'Create user',
            'Edit user',
            'Delete user',          
        ]);


        $company_admin_role=Role::create(['name' => 'Company admin', 'guard_name' => 'api']);

        $company_admin_role->syncPermissions([
            'View company',
            'Create company',
            'Edit company',
            'Delete company',

            'View package',
            'Create package',
            'Edit package',
            'Delete package',

            'View bill',
            'Create bill',
            'Edit bill',
            'Delete bill',

            'View payment',
            'Create payment',
            'Edit payment',
            'Delete payment',

            'View subscription',
            'Create subscription',
            'Edit subscription',
            'Delete subscription',

            'View prototype',
            'Create prototype',
            'Edit prototype',
            'Delete prototype',

            'View user',
            'Create user',
            'Edit user',
            'Delete user',          
        ]);



        $user_role=Role::create(['name' => 'User', 'guard_name' => 'api']);

        $user_role->syncPermissions([
            'View company',
            'Create company',
            'Edit company',
            'Delete company',

            'View package',
            'Create package',
            'Edit package',
            'Delete package',

            'View bill',
            'Create bill',
            'Edit bill',
            'Delete bill',

            'View payment',
            'Create payment',
            'Edit payment',
            'Delete payment',

            'View subscription',
            'Create subscription',
            'Edit subscription',
            'Delete subscription',

            'View prototype',
            'Create prototype',
            'Edit prototype',
            'Delete prototype',

            'View user',
            'Create user',
            'Edit user',
            'Delete user', 
        ]);

    }
}
