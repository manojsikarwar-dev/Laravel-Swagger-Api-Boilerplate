<?php

namespace App\Helpers;

use Request;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ResponseHelper
{
    # Response
    public static function res($data, $message, $code)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'timestamp' => Carbon::now()->timestamp,
            'data' => $data
        ];
        return response()->json($response, $code);
    }

    # Success Response
    public static function success($data = [], $message = 'Success', $code = 200)
    {
        return ResponseHelper::res($data, $message, $code);
    }

    # Fail Response
    public static function fail($data = [], $message = "Error", $code = 203)
    {
        return ResponseHelper::res($data, $message, $code);
    }

    # Error Parse
    public static function error_parse($message)
    {
        foreach ($message->toArray() as $key => $value) {
            foreach ($value as $ekey => $evalue) {
                return $evalue;
            }
        }
    }

}
