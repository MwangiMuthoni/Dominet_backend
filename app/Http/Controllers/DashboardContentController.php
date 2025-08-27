<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Property;
use App\Models\Visit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardContentController extends Controller
{
    //
    public function dashboardContent(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $companyId = $request->query('company_id'); 
    
        $user = Auth::user();
        $year = date('Y');  
        $currentMonth = date('m');
        $currentDay = date('d');
    
        $commonQuery = function ($query) use ($user) {
            if ($user->company_id != null && $user->role_id != 1) {
                return $query->where('properties.company_id','=', $user->company_id);
            } elseif ($user->company_id == null && $user->role_id != 1) {
                return $query->where('properties.user_id','=', $user->id);
            }
            return $query;
        };
    
        $users = User::when($user->company_id != null && $user->role_id != 1, function ($query) use ($user) {
                return $query->where('company_id', '=', $user->company_id);
            })->orderBy('users.created_at', 'asc')
            ->get();
    
        return response([
            'visitors' => UserResource::collection($users),
        ]);
    }
      

    private function formatTrends($trends)
    {
        $monthlyData = array_fill(1, 12, 0);    

        foreach ($trends as $trend) {
            $monthlyData[$trend->month] = $trend->total;
        }   

        $formattedTrends = [];
        foreach ($monthlyData as $month => $total) {
            $formattedTrends[] = [
                'month' => $month,
                'total' => $total
            ];
        }   

        return $formattedTrends;
    }
    
}