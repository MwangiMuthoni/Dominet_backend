<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
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
        $firstCompanyId = Company::first()->id;

        $user=User::create([
            'id' => Str::uuid(), 
            'name'=>'Spa Admin', 
            'phone'=>'+254700000000', 
            'email'=>'admin@spa.com', 
            'password'=>Hash::make('spa101'), 
            'role_id'=>1
        ]);

        $user->syncRoles(['Super admin']);
        
        $permissions=array();
        foreach($user->role->permissions as $permission){
                    $permissions[]=$permission->name;
                }
        $user->syncPermissions($permissions);

        $company_admin=User::create([
            'id' => Str::uuid(), 
            'name'=>'Company Admin', 
            'phone'=>'+254700000000', 
            'email'=>'admin@company.com', 
            'password'=>Hash::make('company101'), 
            'role_id'=>2, 
            'company_id'=> $firstCompanyId
        ]);
        $company_admin->syncRoles(['Company admin']);
        
        $permissions=array();
        foreach($company_admin->role->permissions as $permission){
                    $permissions[]=$permission->name;
                }
        $company_admin->syncPermissions($permissions);

        // $agentData = [
        //     ['name' => 'Alex Johnson', 'email' => 'agent1@company.com', 'password' => 'agent101'],
        //     ['name' => 'Jordan Lee', 'email' => 'agent2@company.com', 'password' => 'agent102'],
        //     ['name' => 'Taylor Morgan', 'email' => 'agent3@company.com', 'password' => 'agent103'],
        // ];

        // foreach ($agentData as $data) {
        //     $companyAgent = User::create([
        //         'name' => $data['name'],
        //         'phone' => '+254700000000',
        //         'email' => $data['email'],
        //         'password' => Hash::make($data['password']),
        //         'role_id' => 3,
        //         'company_id'=> $firstCompanyId
        //     ]);
        //     $companyAgent->syncRoles(['Company agent']);
            
        //     $companyAgentPermissions = [];
        //     foreach ($companyAgent->role->permissions as $permission) {
        //         $companyAgentPermissions[] = $permission->name;
        //     }
        //     $companyAgent->syncPermissions($companyAgentPermissions);
        // }

    }
}
