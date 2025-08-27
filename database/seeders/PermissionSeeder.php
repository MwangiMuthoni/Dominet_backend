<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use File;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path("seeders/data/permissions.json"));
        $data = json_decode($json);
        $permissions = $data[0]->permissions;
        $roles = $data[0]->roles;

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }

        foreach ($roles as $role) {
            $roleModel = Role::where('name', '=', $role->name)->first();
            if (!isset($roleModel)) {
                $roleModel = Role::create([
                    'name' => $role->name,
                    'guard_name' => 'api'
                ]);
            }
            $roleModel->syncPermissions($role->permissions);
        }
    }
}