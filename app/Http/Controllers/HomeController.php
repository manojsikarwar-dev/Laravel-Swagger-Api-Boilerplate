<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    # Success Page
    public function success(Request $request)
    {
        return view('success');
    }

    # Email Verification
    public function activation($token='')
    {
        try{
            $data = User::where('email',Crypt::decryptString($token))->first();
            if($data){
                User::where(['email'=>Crypt::decryptString($token)])->update(['email_verified_at'=>Carbon::now()]);
                session()->flash('success', trans('api.EMAIL_VERIFIED_SUCCESS'));
                return redirect()->route('success');
            }else{
                session()->flash('error', trans('api.EMAIL_VERIFY_FAIL'));
                return redirect()->route('success');
            }
        }catch(\Exception $e){                  
            session()->flash('error',$e->getMessage());
            return redirect()->route('success');
        }
    }
}
