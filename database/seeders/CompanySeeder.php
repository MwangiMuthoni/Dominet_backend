<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Spa',
            'phone' => '0712345678',
            'email' => 'test@test.com', 
            'contact_person' => 'John Doe',
            'contact_email' => 'john@doe.com',
            'contact_phone' => '0723456789', 
           
            
        ]);
    }
}
