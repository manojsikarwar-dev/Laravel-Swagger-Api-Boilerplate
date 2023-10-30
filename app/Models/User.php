<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\SendEmailJob;
use App\Helpers\Helper;
use URL;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # Register
    public static function register($request)
    {
        $data = new User();
        $data->name = $request->name;        
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->role_id = config('const.ROLE_USER');

        # Email Verification
        $token = Crypt::encryptString($request->email);
        $emailData = [
            'url' => URL::to('/') . '/activation/' . $token
        ];
        Helper::sendEmail('email-verify', trans('email.EMAIL_VERIFY'), $request->email, $emailData);        

        $data->save();
        return $data;
    }
}
