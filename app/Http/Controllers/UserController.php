<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ConfirmEmail;
use App\Models\ConfirmPhone;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Notifications\ConfirmationEmailNotification;
use App\Notifications\ConfirmationPhoneNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $this->authorize('viewAny', User::class);
        $activeUser = Auth::user();
        $users = User::when($activeUser->company_id != null && $activeUser->role_id != 1, function ($query) use ($activeUser) {
                            return $query->where('company_id','=', $activeUser->company_id);
                        })
                        ->when($activeUser->company_id == null && $activeUser->role_id != 1, function ($query) use ($activeUser) {
                            return $query->where('id','=', $activeUser->id);
                        })
                        ->orderBy('created_at','desc')
                        ->paginate(20);
        return UserResource::collection($users)->preserveQuery();
    }

    public function users()
    {
        //
        // $this->authorize('viewAny', User::class);
        $activeUser = Auth::user();
        $users = User::when($activeUser->company_id != null && $activeUser->role_id != 1, function ($query) use ($activeUser) {
                            return $query->where('company_id','=', $activeUser->company_id);
                        })
                        ->when($activeUser->company_id == null && $activeUser->role_id != 1, function ($query) use ($activeUser) {
                            return $query->where('id','=', $activeUser->id);
                        })
                        ->orderBy('created_at','asc')
                        ->get();

        
        return response(['users' => UserResource::collection($users)]);
    }

    public function search(Request $request)
    {
        //
        // $this->authorize('viewAny', User::class);
        $input=$request->all();

        $users = User::where('name','LIKE','%'.$input['searchTerm'].'%')
            ->orderBy('created_at','asc')
            ->paginate(20);

        return $users;
    }

    public function agents()
    {
        $agent_role_id = 3;

        $agents = User::where('role_id', $agent_role_id)->get();
    
        return response(['agents' => UserResource::collection($agents)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input=$request->all();
        $validator = Validator::make($input, [
            'name'=>'required',
            'role_id'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $input['password']=Hash::make($input['password']);
        $input['company_id'] = auth()->user()->company_id;
        $user=User::create($input);

        $role = $user->role;

        if (isset($role)) {
            $user->assignRole($role->name);
        }
        $permissions = [];
        foreach ($user->role->permissions as $permission) {
            $permissions[] = $permission->name;
        }
        $user->syncPermissions($permissions);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $User)
    {
        //
        // $this->authorize('view', $User);
        return new UserResource($User);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        //

        $this->authorize('update', $User);
        $input=$request->all();
        if(isset($input['password'])){$input['password']=Hash::make($input['password']);}
        $user->update($input);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $User)
    {
        //
        $this->authorize('delete', $User);
        $User->delete();
        return response(['message' => 'User was deleted successfully']);
    }


    public function updateAccount(Request $request, $id) {
        $user = User::find($id);

        $input=$request->all();

        if($input['password'] == "null") {
            $input['password'] = $user->password;
        }
        else {
            $input['password']=Hash::make($input['password']);
        }

        if ($input['email'] != $user->email && !is_null($user->email) && !is_null($input['email'])) {

            $registrationCode = rand(100000, 999999);
            $emailConfirmationCode = ConfirmEmail::create([
                'registration_code' => $registrationCode,
                'user_id' => $user->id,
            ]);

            $virtualUser = new User;
            $virtualUser->email = $input['email'];

            try {$virtualUser->notify(new ConfirmationEmailNotification($registrationCode));} catch (TransportException $e) {} catch (Exception $e) {}  
        }

        if ($input['phone'] != $user->phone && !is_null($user->phone) && !is_null($input['phone'])) {
            $input['phone_confirmed'] = null;

            $registrationCode = rand(100000,999999);
      
            $smsConfirmationCode = confirmPhone::create([
                'registration_code'=>$registrationCode,
                'user_id'=>$user->id,
            ]);

            $virtualUser = new User;
            $virtualUser->email = $user->email;
    
            try {$virtualUser->notify(new ConfirmationPhoneNotification($input['calling_code'].$input['phone'],$registrationCode));} catch (TransportException $e) {} catch (Exception $e) {} 
        }

        $user->update($input);

        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('profiles');
        }

        if ($request->hasFile('signature')) {
            $user->addMediaFromRequest('signature')->toMediaCollection('signatures');
        }
        

        return new UserResource($user);
    }
}
