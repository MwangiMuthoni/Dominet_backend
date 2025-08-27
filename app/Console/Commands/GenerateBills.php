<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Bill;
use App\Models\Company;
use App\Notifications\BillNotification;

class GenerateBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $users=User::whereNull('company_id')->where('role_id','!=',1)->get();
        $companies=Company::all();

        foreach ($users as $user) {
            $uniqid=uniqid();
            if(isset($user->subscription)){
                $bill = Bill::create(['number'=>$uniqid,'narrative'=>'Subscription bill from spa.com', 'user_id'=>$user->id, 'amount'=>$user->subscription->package->price, 'status'=>'Unpaid', 'company_id'=>null]);
                $user->notify(new BillNotification($user->name, $bill->narrative));
            }
            
        }

        foreach ($companies as $company) {
            $uniqid=uniqid();
            if(isset($company->subscription)){
                $bill = Bill::create(['number'=>$uniqid,'narrative'=>'Subscription bill from spa.com', 'user_id'=>null, 'amount'=>$company->subscription->package->price, 'status'=>'Unpaid', 'company_id'=>$company]);
                $company->user->notify(new BillNotification($company->user->name, $bill->narrative));
            }
            
        }
    }
}