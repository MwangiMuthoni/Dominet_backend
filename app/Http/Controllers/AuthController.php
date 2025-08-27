<?php

namespace App\Http\Controllers;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\UserRegistrationJourney;
use App\Models\ConfirmEmail;
use App\Models\ConfirmPhone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserRegistrationJourneyResource;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\PasswordReset;
use Carbon\Carbon;
use Socialite;
use App\Notifications\ConfirmEmailNotification;
use App\Notifications\ConfirmPhoneNotification;
use App\Notifications\ContactNotification;
use App\Notifications\EnquiryNotification;

use App\Helpers\PhoneHelper;
use App\Rules\PhoneNumber;


class AuthController extends Controller
{
    //

    public function login()
    {
        $user=User::where('email','=',request('email'))->first();
        
        if ($user && Hash::check(request('password'), $user->password)) {
            $accessToken = $user->createToken('authToken');
            
            $company = Company::where('id',$user->company_id)->first();

            return response()->json([
                'user' => new UserResource($user),
                'company' => $company ? new CompanyResource($company) : null,
                'token' => $accessToken,
            ]);
        } else {
            return response(['error' => 'Invalid Email or Password']);
        }
    }


    public function reset(Request $request)
    {
       $input = $request->all(); 
         $validator = Validator::make($input, [
           'email'=>'required',
              ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
         }


      $user=User::where('email','=',$request->email)->first();

      if (!isset($user)) {
            return response(['error' => ['email'=>['The email address provided was not found in our records. Kindly check for errors.']]]);
         }
      DB::table('password_resets')->insert([
          'email' => $request->email,
          'token' => Str::random(60),
          'created_at' => Carbon::now()
      ]);
      $tokenData = DB::table('password_resets')
          ->where('email','=',$request->email)->first();

      $url = url('/').'/password/reset/'.$tokenData->token .'?email='.urlencode($user->email);

      $user->notify(new PasswordReset($url));

      /*try{$user->notify(new PasswordReset($url));}
        catch(\Exception $e){}*/
    }

    public function resetSave(Request $request)
    {
      $input = $request->all(); 
         $validator = Validator::make($input, [
           'email'=>'required',
           'password' => 'required|min:6|confirmed',
           'password_confirmation' => 'required|min:6',
           'token'=>'required',
              ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
         }
      $user=User::where('email','=',$request->email)->first();
      $tokenData = DB::table('password_resets')->where('token','=',$request->token)->first();
      if (isset($user) && isset($tokenData)) {
        $userD=array();
        $userD['password']=Hash::make($request->password);
        $user->update($userD);
      DB::table('password_resets')->where('email', '=',$user->email)->delete();
      $accessToken = $user->createToken('authToken');
      return response([ 'user' => new UserResource($user), 'token' => $accessToken]);}
      else{
        response(['error' => ['email'=>['The email address provided was not found in our records. Kindly check for errors.']]]);
      }
    }

    public function updatePassword(Request $request)
    {
        //
        $user=Auth::user();
        $input=$request->all();
        $validator = Validator::make($input, [
          'current_password' => 'required',
           'password' => 'required|min:6|confirmed',
           'password_confirmation' => 'required|min:6',
              ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
         }

         if(!Hash::check($input['current_password'], $user->password)){
            return response(['error' => ['current_password'=>['The current password is incorrect. If you have forgotten yor current password, kindly logout and reset your password in the forgot password page.']]]);
         }
         if(Hash::check($input['password'], $user->password)){
            return response(['error' => ['password'=>['The new password is similar to the current password.']]]);
         }
         $input['password']=Hash::make($input['password']);
        $user->update(['password'=>$input['password']]);
        return new UserResource($user);
    }
 

    public function logout()
    {
      if (Auth::user()) {
        $tokens = Auth::user()->tokens();
        $tokens->delete();

        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
      ]);
      }else {
        return response()->json([
          'success' => false,
          'message' => 'Unable to Logout'
        ]);
      }
     }

    public function checkAuth()
    {
        if (Auth::check()) {
            $user=Auth::user();
            return response(['success' => true, 'user' => new UserResource($user)]);
        }
        else{
            return response()->json(['success' => false, 'message' => 'User is not logged in']);
        }
    }


    public function registerUser(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 422);
        }

        $input['password'] = Hash::make($input['password']);
        $input['role_id'] = 2;

        $user = User::create($input);

        $userRegistrationJourney = UserRegistrationJourney::create([
            'user_id' => $user->id,
            'register' => 1,
        ]);

        $registrationCode = rand(100000, 999999);
        $confirmEmail = ConfirmEmail::create([
            'registration_code' => $registrationCode,
            'user_id' => $user->id,
        ]);

        $role = $user->role;

        if (isset($role)) {
            $user->assignRole($role->name);
        }
        $permissions = [];
        foreach ($user->role->permissions as $permission) {
            $permissions[] = $permission->name;
        }
        $user->syncPermissions($permissions);

        try {
            $user->notify(new ConfirmEmailNotification($registrationCode));
        } catch (TransportException $e) {
            
        } catch (Exception $e) {
        
        }

        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $accessToken,
        ], 201);
    }


    public function confirmEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'entered_code' => 'required|string|min:6|max:6',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $enteredCode = $request->input('entered_code');

            $confirmEmail = ConfirmEmail::where('registration_code', $enteredCode)->firstOrFail();
            
            $user = User::where('id', $confirmEmail->user_id)->firstOrFail();

            $userRegistrationJourney = UserRegistrationJourney::where('user_id',$user->id)->first();
    
            if($userRegistrationJourney) {
                $userRegistrationJourney->update([
                    'confirm_email'=>1,
                ]);
            }

            $confirmEmail->delete();
    

            return response([
                'message' => 'Email confirmation confirmed code was successfully.',
                'user'=> new UserResource($user)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid confirmation code or user not found.'], 404);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function updateUserProfile(Request $request) {
        $input=$request->all();

        $user = Auth::user();


        $validator = Validator::make($input, [
            'name' => 'required',
            'calling_code'=> 'required',
            'phone'=> ['required', new PhoneNumber],
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }

        $phoneDigits = preg_replace('/\D/', '', $input['phone']); 
        $lastNineDigits = substr($phoneDigits, -9); 

        $phoneOnly = $input['phone'];
    
        $input['phone'] = $input['calling_code'].$lastNineDigits;
        
        $user->update($input);

        $userRegistrationJourney = UserRegistrationJourney::where('user_id',$user->id)->first();
    

        if($userRegistrationJourney) {
            $userRegistrationJourney->update([
                'complete_profile'=>1,
            ]);    
        }


        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('profiles');
        }

        $registrationCode = rand(100000,999999);
      
        $confirmPhone = ConfirmPhone::create([
            'registration_code'=>$registrationCode,
            'user_id'=>$user->id,
        ]);

        try {$user->notify(new ConfirmPhoneNotification($input['calling_code'].$phoneOnly,$registrationCode));} catch (TransportException $e) {} catch (Exception $e) { }

        return new UserResource($user);
    }


    public function confirmPhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'entered_code' => 'required|string|min:6|max:6',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            $enteredCode = $request->input('entered_code');

            $confirmPhone = ConfirmPhone::where('registration_code', $enteredCode)->firstOrFail();
    
            $user = User::where('id', $confirmPhone->user_id)->firstOrFail();

            $userRegistrationJourney = UserRegistrationJourney::where('user_id',$user->id)->first();
    
            if($userRegistrationJourney) {
                $userRegistrationJourney->update([
                    'confirm_phone'=>1,
                ]);
            }

            $confirmPhone->delete();
    
            return response([
                'message' => 'Phone confirmation code was successfully.',
                'user'=> new UserResource($user)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Invalid confirmation code or user not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function addPackage(Request $request) {
        $input=$request->all();

        $user = Auth::user();

        $userRegistrationJourney = UserRegistrationJourney::where('user_id',$user->id)->first();
    
        $userRegistrationJourney->update([
            'package'=>1,
        ]);

        return new UserResource($user);
    }


    public function postContact(Request $request) {
        $virtualUser = new User;
        $virtualUser->email = config('app.admin_email');
        $input = $request->all();

        try {
            $virtualUser->notify(new ContactNotification($input['name'], $input['phone'], $input['email'], $input['subject'], $input['message']));
        } catch (TransportException $e) {} catch (Exception $e) {
        }

        $virtualUser2 = new User;
        $virtualUser2->email = $input['email'];

        try {
            $virtualUser2->notify(new EnquiryNotification($input['name'], $input['subject']));
        } catch (TransportException $e) {} catch (Exception $e) {
        }

        return response([
            'message' => 'Your message has been received. We will reach out to you ASAP.',
        ]);
    }


    public function changeEmail(Request $request) {
        $user =Auth::user();

        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|unique:users',
        ]);
      
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        $user->update([
            'email'=>$input['email']
        ]);

        $registrationCode = rand(100000,999999);

        $emailConfirmationCode = ConfirmEmail::create([
            'registration_code'=>$registrationCode,
            'user_id'=>$user->id,
        ]);

        try {$user->notify(new ConfirmEmailNotification($registrationCode));} catch (TransportException $e) {} catch (Exception $e) {}
        
        return new UserResource($user);
      }

      public function changePhone(Request $request) {
        $user = Auth::user();

        $input = $request->all();

        $validator = Validator::make($input, [
            'phone' => 'required',
            'calling_code' => 'required',
        ]);
      
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        $user->update([
            'phone'=>$input['calling_code'].$input['phone'],
        ]);

        $registrationCode = rand(100000,999999);
        $createSmsConfirmationCode = ConfirmPhone::create([
            'registration_code'=>$registrationCode,
            'user_id'=>$user->id,
        ]);

        try {$user->notify(new ConfirmPhoneNotification($input['phone'],$registrationCode));} catch (TransportException $e) {} catch (Exception $e) {}
        
        return new UserResource($user);
      }

      
}
