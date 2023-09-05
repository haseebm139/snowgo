<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\payoffDetails;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Artisan;
use App\Mail\OrderShipped;
use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Laravel\Passport\Passport;
use Hash;
use App\Mail\ResetPasswordEmail;
use Mail;
use Illuminate\Validation\ValidationException;
use Carbon;
class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'phone_number'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }


        $input = $request->except(['confirm_password','password','bank_name','account_type','account_number','bic/swift'],$request->all());
         if($request->hasFile('profile')) {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $input['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }else{
            $input['profile'] = 'default.png';
        }

        if($request->hasFile('driving_license')) {
            $img = Str::random(20).$request->file('driving_license')->getClientOriginalName();
            $input['driving_license'] = $img;
            $request->driving_license->move(public_path("documents/driving_license"), $img);
        }

        if($request->hasFile('ein_number')) {
            $img = Str::random(20).$request->file('ein_number')->getClientOriginalName();
            $input['ein_number'] = $img;
            $request->ein_number->move(public_path("documents/ein_number"), $img);
        }

        if($request->hasFile('police_check')) {
            $img = Str::random(20).$request->file('police_check')->getClientOriginalName();
            $input['police_check'] = $img;
            $request->police_check->move(public_path("documents/police_check"), $img);
        }
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $success['token'] =  $user->createToken('snowgo')->accessToken;
        $success['name'] =  $user->name;
        $success['image_path'] = asset('documents/profile/'.$input['profile']);
        $user_type = Str::studly($input['type']);
        if ($input['type'] == 'service_provider') {
            $this->payoffDetail($user->id,$request->all());
        }
        return $this->sendResponse($success, $user_type .' register successfully.');

    }


    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required',
            'password' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('snowgo')->accessToken;
            $success['name'] =  $user->name;


            if (!empty($coOrdinates['lat']) && $coOrdinates['lat'] !== null && !empty($coOrdinates['lon']) && $coOrdinates['lon'] !== null) {
                $this->updateLocation($coOrdinates);
            }

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Email or Password is Invalid.');
        }
    }

    /**
     * Forget Password
     *
     * @return \Illuminate\Http\Response
     */
    public function forgetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        $user = User::where('email', $request->email)->first();
        // $token = mt_rand(1000, 9999);
        $token = 1234;
        $user->password_reset_token = $token;
        $user->password_reset_token_expires_at = now()->addMinutes(60);
        $user->save();

        // Send the password reset email to the user
        Mail::to($user->email)->send(new ResetPasswordEmail($user));

        $success['email'] =  $user->email;
        $success['code'] =   $user->password_reset_token;
        return $this->sendResponse($success, 'Password reset email sent');
    }

    /**
     * Create New Password
     *
     * @return \Illuminate\Http\Response
     */
    public function updateForgetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        $user = User::where('email', $request->email)
        ->first();
        $user->password = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_token_expires_at = null;
        $user->save();
        $success = [];
        return $this->sendResponse($success, 'Password Changed Successfully');

    }

    /**
     * Edit Profile
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request){
        // return $request->all();
        $validator = Validator::make($request->all(), [

            'first_name' => 'required',
            'mid_name' => 'required',
            'last_name' => 'required',
            'profile' => 'required',
            'address' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        $user = User::find(auth()->user()->id);
        $profile = $request->except(['first_name','mid_name','last_name','profile'],$request->all());
        $profile['name'] = $request->first_name.' '.$request->mid_name.' '.$request->last_name;
        if($request->hasFile('profile')) {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $profile['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }

        if($request->hasFile('driving_license')) {
            $img = Str::random(20).$request->file('driving_license')->getClientOriginalName();
            $input['driving_license'] = $img;
            $request->driving_license->move(public_path("documents/driving_license"), $img);
        }

        if($request->hasFile('ein_number')) {
            $img = Str::random(20).$request->file('ein_number')->getClientOriginalName();
            $input['ein_number'] = $img;
            $request->ein_number->move(public_path("documents/ein_number"), $img);
        }

        if($request->hasFile('police_check')) {
            $img = Str::random(20).$request->file('police_check')->getClientOriginalName();
            $input['police_check'] = $img;
            $request->police_check->move(public_path("documents/police_check"), $img);
        }
        $data['image_path'] = asset('documents/profile/'.$profile['profile']);
        $user->update($profile);
        return $this->sendResponse($data,'Profile Sucessfully Updated.');
    }

    /**
     * Update Password
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        $user = User::find(auth()->user()->id);
        $input['password'] = Hash::make($request->password);
        $user->update($input);
        return $this->sendResponse($result = [],'Password Update Sucessfully!');
    }

    /**
     * Update Location
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLocation($coOrdinates){
        $user = Auth::user();
        $user->update($coOrdinates);
        // = User::find($id)->update($coOrdinates)
        return $user;
    }

    public function payoffDetail($id,$user){

        $pay_of_details = PayoffDetails::Create([
            "service_provider_id"=>$id,
            "bank_name"=>$user['bank_name'],
            "account_type"=>$user['account_type'],
            "account_number"=>$user['account_number'],
            "bic/swift"=>$user['bic/swift'],
        ]);
        return $pay_of_details;

    }

    public function updateUserLocation(Request $request){

        $user = Auth::user();
        $success = [];
        if (!empty($request->lat) && $request->lat !== null && !empty($request->lon) && $request->lon !== null) {
            $user->update($request->all());
            return $this->sendResponse($success, 'Update Location');
        }
        return $this->sendError('Longitude or Latitude Should not be null');
        // = User::find($id)->update($coOrdinates)
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('config:cache');
            // Additional cache clearing commands can be added here if needed

            return "Cache cleared successfully.";
        } catch (\Exception $e) {
            return "Cache clearing failed: " . $e->getMessage();
        }
    }



}
