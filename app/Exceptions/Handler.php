<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ThrottleRequestsException) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        return parent::render($request, $exception);
    }
}
