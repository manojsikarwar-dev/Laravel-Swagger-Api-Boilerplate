<?php

namespace App\Helpers;

use Request;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use App\Jobs\SendEmailJob;

class Helper
{
    # Send Email
    public static function sendEmail($bladeFile, $subject, $email, $data = [], $cc = '', $bcc = '')
    {
        $emailData = [
            '_blade' => $bladeFile,
            'subject' => $subject,
            'email' => $email,            
            'data' => $data
        ];

        if(isset($cc) && $cc !=''){
            $emailData['cc'] = $cc;   
        }
        if(isset($bcc) && $bcc !=''){
            $emailData['bcc'] = $bcc;   
        }

        dispatch(new SendEmailJob($emailData));

        return true;
    }
}
