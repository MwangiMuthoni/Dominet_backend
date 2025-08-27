<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $json=File::get(__DIR__ . "/data/countries.json");
        $data=json_decode($json);

        foreach ($data as $obj) {

            $countryD=[
                'name'=>$obj->country, 
                'calling_code'=>$obj->callingcode, 
                'nationality'=>$obj->nationality,
                'swift_code'=>$obj->swiftcode,
            ];

            $country = Country::create($countryD);

        }
    }
}