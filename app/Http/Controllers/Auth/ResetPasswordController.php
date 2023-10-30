<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResets;
use App\Http\Requests\v1\ResetPasswordRequest;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    # Reset Password Page
    public function viewResetPassword($token, $isMobile='')
    {
        try{
            $tokenData = PasswordResets::where('token', $token)->first();
            if (!$tokenData){
                session()->flash('error', trans('api.INVALID_RESET_PASSWORD'));
                return redirect()->route('success');
            }
            return view('auth.passwords.reset',array('token'=>$token,'isMobile'=>$isMobile));
        }catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect()->route('success');
        }
    }

    # Reset Password
    public function resetPassword(ResetPasswordRequest $request, $token, $isMobile='')
    {
        try{
            $password = $request->password;
            $tokenData = PasswordResets::where('token', $token)->first();

            $user = User::where('email', $tokenData->email)->first();
            if (!$user) {
                session()->flash('error', trans('api.INVALID_RESET_PASSWORD'));
                return redirect()->route('success');
            }

            $user->password = Hash::make($password);
            $user->save();

            PasswordResets::where('email', $user->email)->delete();

            session()->flash('success', trans('api.PASSWORD_RESET_SUCCESS'));
            return redirect()->route('success');
        }catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect()->route('reset-password', array('token' => $token, 'isMobile' => $isMobile));            
        }
    }
}
