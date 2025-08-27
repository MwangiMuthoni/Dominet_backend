<?php

namespace App\Providers;

// Policies

use App\Policies\UserPolicy;
use App\Policies\PrototypePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\PackagePolicy;
//use App\Policies\SubscriptionPolicy;
use App\Policies\BillPolicy;
use App\Policies\PaymentPolicy;



// Models

use App\Models\User;
use App\Models\Prototype;
use App\Models\Company;
use App\Models\Package;
//use App\Models\Subscription;
use App\Models\Bill;
use App\Models\Payment;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Tests\Feature\Models\EmployeePaySlipDefaultTest;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the Ticket.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Prototype::class => PrototypePolicy::class,
        Company::class => CompanyPolicy::class,
        Package::class => PackagePolicy::class,
        //Subscription::class => SubscriptionPolicy::class,
        Bill::class => BillPolicy::class,
        Payment::class => PaymentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
