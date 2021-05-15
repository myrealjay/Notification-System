<?php

namespace App\Exceptions;

use App\Traits\HasResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

class Handler extends ExceptionHandler
{
    use HasResponse;
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

    /**
     * Handles all throwable exceptions
     *
     * @param $request
     * @param \Throwable $e
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->notAllowedResponse('The method you are calling is not allowed');
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->notFoundResponse($e->getMessage() ? $e->getMessage() : 'we could not found what you are looking for');
        }

        if ($e instanceof ValidationException) {
            return $this->formValidationResponse('The validation has failed', $e->errors());
        }

        if ($e instanceof AuthenticationException) {
            return $this->notAllowedResponse($e->getMessage());
        }

        if ($e instanceof AuthorizationException) {
            return $this->notAllowedResponse($e->getMessage());
        }

        return $this->serverErrorResponse('Sorry an error occured, we are working on it', new Exception($e->getMessage()));
    }
}
