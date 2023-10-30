<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\RegisterRequest;
use App\Http\Requests\v1\ForgotPasswordRequest;
use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Models\PasswordResets;
use Carbon\Carbon;

class AuthController extends Controller{

/**
* @OA\Post(
     *     path="/api/v1/register",
     *     summary="Register a new user",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    # Register
    public function register(RegisterRequest $request) 
    {        
        try{
            $emailExist = User::where('email','=',$request->email)->first();
            if($emailExist){
                return ResponseHelper::fail([],trans('api.EMAIL_EXISTS'), config('code.VALIDATION_ERROR_CODE'));
            }
            
            DB::beginTransaction();
            $data = User::register($request);
            DB::commit(); 
            
            return ResponseHelper::success($data, trans('api.REGISTER_SUCCESS'), config('code.SUCCESS_CODE'));
        } catch (Exception $ex) {
            DB::rollBack();
            return  ResponseHelper::fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }        
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Authenticate user and generate JWT token",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */

    # Login
    public function login(LoginRequest $request) 
    {        
        try{
            $user = [];
            
            if(Auth::attempt(['email' =>$request->email, 'password' => $request->password, 'role_id' => config('const.ROLE_USER')])){ 
                $user = Auth::user();   
            }else{
                return ResponseHelper::fail([], trans('api.INVALID_CREDENTIALS'), config('code.UNAUTHORIZED_CODE'));
            }
            
            if ($user->email_verified_at == NULL || $user->email_verified_at == '') {
                return ResponseHelper::fail([], trans('api.ACCOUNT_NOT_VERIFIED'), config('code.UNAUTHORIZED_CODE'));
            }
            if ($user->status == config('const.STATUS_INACTIVE')){
                return ResponseHelper::fail([], trans('api.ACCOUNT_INACTIVE'), config('code.UNAUTHORIZED_CODE'));
            }
            if ($user->role_id != config('const.ROLE_USER')){
                return ResponseHelper::fail([], trans('api.NOT_AUTHORIZED'), config('code.UNAUTHORIZED_CODE'));
            }
    
            $tokenobj = Auth::user()->createToken('laravel-api-boilerplate');           
            $user->token = $tokenobj->accessToken;            
            $token_id = $tokenobj->token->id;
           
            DB::table('oauth_access_tokens')->where('id','!=', $token_id)->where('user_id', Auth::user()->id)->update([
                'revoked' => true
            ]);                    
                       
            return ResponseHelper::success($user, trans('api.LOGIN_SUCCESS'), config('code.SUCCESS_CODE'));

        }catch(\Exception $e){                  
            return  ResponseHelper::fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }   
    
    # Logout
    public function logout(Request $request)
    {
        try{                       
            $user = Auth::user()->token(); 
            $user->revoke();
            return ResponseHelper::success([], trans('api.LOGOUT_SUCCESS'), config('code.SUCCESS_CODE'));
        }catch(\Exception $e){                  
            return  ResponseHelper::success([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

       /**
     * @OA\Post(
     *     path="/api/v1/forgot-password",
     *     summary="Forget Password",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Forget and Reset Password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="We have sent a link to your registered email address, Please review the email and follow the instruction to reset your password."),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */

    # Forgot Password
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try{
            $user = User::where('email',$request->email)->first();
            if(!$user){
                return ResponseHelper::fail([],trans('api.EMAIL_NOT_FOUND'), config('code.VALIDATION_ERROR_CODE'));
            }

            if(isset($user) && $user->status==config('const.statusInActiveInt')){
                return ResponseHelper::fail([],trans('api.ACCOUNT_INACTIVE'), config('code.VALIDATION_ERROR_CODE'));               
            }

            $token = Crypt::encryptString($request->email);
            PasswordResets::updateOrCreate(['email' => $request->email],[
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ])->forgotLink($token, $request->email, 1, $user->name);

            return ResponseHelper::success([], trans('api.FORGOT_PASSWORD'), config('code.SUCCESS_CODE'));            
        }catch(\Exception $e){
            return  ResponseHelper::fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
    
}
