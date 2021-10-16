<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Exception $exception
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Exception $exception
     * @return Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
