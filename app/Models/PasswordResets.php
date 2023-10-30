<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\SendEmailJob;
use URL;

class PasswordResets extends Model
{

    use HasFactory;
    protected $table = 'password_resets';
    public $timestamps = false;
    protected $primaryKey ='email';
	
    protected $fillable = [
        'email','token','created_at'
    ];

    # Send Forgot Password Email
    public function forgotLink($token, $email, $isMobile='', $name='')
    {          
        dispatch(new SendEmailJob([
            '_blade' => 'forgot-password',
            'subject' => trans('email.RESET_PASSWORD'),
            'email' => $email,
            'name' => $name,
            'url' =>  URL::to('/') . '/forgot-password/' . $token . '/' . $isMobile
        ]));
    }

}
