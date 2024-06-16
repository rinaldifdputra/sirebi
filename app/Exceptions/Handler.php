<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
//use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
    //         return response()->view('errors.404', [], 404);
    //     }

    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
    //         return response()->view('errors.403', [], 403);
    //     }

    //     // Penanganan error 500
    //     if ($exception instanceof \Exception) {
    //         return response()->view('errors.500', [], 500);
    //     }

    //     return parent::render($request, $exception);
    // }
}
