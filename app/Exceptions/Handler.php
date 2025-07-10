<?php

namespace App\Exceptions;

use App\Enums\ECommon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;

class Handler extends ExceptionHandler
{
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

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        Log::channel(ECommon::LOG_CHANNEL_ERROR)->error("{$e->getMessage()} - {$e->getFile()} - {$e->getLine()}");
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        switch (get_class($e)) {
            case UnauthorizedHttpException::class:
                $message = __('message.error.common.401');
                $statusCode = JsonResponse::HTTP_UNAUTHORIZED;
                break;
            case ModelNotFoundException::class:
            case NotFoundHttpException::class:
                $message = __('message.error.common.404');
                $statusCode = JsonResponse::HTTP_NOT_FOUND;
                break;
            case MethodNotAllowedHttpException::class:
                $message = __('message.error.common.405');
                $statusCode = JsonResponse::HTTP_METHOD_NOT_ALLOWED;
                break;
            default:
                $message = __('message.error.common.500');
                $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }
        Log::channel(ECommon::LOG_CHANNEL_ERROR)->error("{$e->getMessage()} - {$e->getFile()} - {$e->getLine()}");

        return ApiResponse::error($message, $statusCode);
    }

}
