<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseHelper;
use App\Models\User;

class UsersController extends Controller{

     /**
     * @OA\Get(
     *     path="/api/v1/get-user-details",
     *     summary="Get logged-in user details",
     *      security={{"bearer":{}}},
     *     @OA\Response(response="200", description="Success"),
     *    @OA\Response(response="401", description="Invalid credentials"),
     *      @OA\Response(response="403",description="Forbidden")
     * )
     */

    # Get User Details
    public function getUserDetails(Request $request) 
    {        
        try{
            $data = User::find(Auth::user()->id);                                            
            return ResponseHelper::success($data, trans('api.SUCCESS'), config('code.SUCCESS_CODE'));
        } catch (Exception $ex) {
            return  ResponseHelper::fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }        
    }

    /**
     * @OA\Get(
     *     path="/api/v1/get-all-users",
     *     summary="Get all user details",
     *      security={{"bearer":{}}},
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Invalid credentials"),
     *      @OA\Response(response="403",description="Forbidden")
     * )
     */

    # Get All Users
    public function getAllUsers(Request $request) 
    {        
        try{
            $data = User::all();                                            
            return ResponseHelper::success($data, trans('api.SUCCESS'), config('code.SUCCESS_CODE'));
        } catch (Exception $ex) {
            return  ResponseHelper::fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }        
    }
    
}
