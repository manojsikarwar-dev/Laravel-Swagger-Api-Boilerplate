<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Helpers\ResponseHelper;

class Handler extends ExceptionHandler
{
    protected $code = 'code';
    protected $messages = 'messages';
    
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {        
        if ($request->is('api/*')) {             
            if($exception->getMessage()=='Unauthenticated.'){
                return ResponseHelper::fail([], $exception->getMessage(), config('code.UNAUTHORIZED_CODE'));
            }
            
            if (method_exists($exception, 'getCode')) {
                $response[$this->code] = $exception->getCode();
            } else {
                $response[$this->code] = 500;
            }
            
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $response[$this->messages] = $exception->errors();
                $response[$this->code] = 400;
            } else {
                $response[$this->messages] = $exception->getMessage();
                if (env('APP_DEBUG', true)) {
                    $response['trace'] = $exception->getTrace();
                }
            }
            
            if ($response[$this->code] <= 100 || $response[$this->code] >= 600) {
                $response[$this->code] = 500;
            }
            
            return ResponseHelper::fail($exception, isset($response[$this->messages])?$response[$this->messages]:'No MSG',$response[$this->code]);
        }     
        return parent::render($request, $exception);
    }
}
