<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use File;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update roles and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = File::get(database_path("seeders/data/permissions.json"));
        $data = json_decode($json);
        $permissions = $data[0]->permissions;
        $roles = $data[0]->roles;

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }
        
        // Create or update roles with their permissions
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

        $users = User::all();
        foreach ($users as $user) {
            $user->syncPermissions($user->role->permissions->pluck('name'));
        }

        $this->info('Roles & Permissions seeded successfully');

        return 0;
    }
}