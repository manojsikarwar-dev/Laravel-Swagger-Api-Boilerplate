<?php

namespace App\Helpers;

use Request;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use URL;

class UrlHelper
{
    # File UploadPath
    public static function fileUploadPath()
    {
        return storage_path('app/public/');
    }

    # Display Image Path
    public static function displayImagePath()
    {
        return URL::to('/') . '/storage/';
    }  

    # Display Defult Profile Path
    public static function displayDefultProfilePath()
    {
        return URL::to('/') . '/assets/admin/user/default.jpg';
    }
}
