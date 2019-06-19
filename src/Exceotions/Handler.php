<?php

namespace APDevs\LaravelUtils\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            return $this->renderExceptionAsJson($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render an exception into a JSON response
     *
     * @param $request
     * @param Exception $exception
     * @return SymfonyResponse
     */
    protected function renderExceptionAsJson($request, Exception $exception)
    {
        // Currently converts AuthorizationException to 403 HttpException
        // and ModelNotFoundException to 404 NotFoundHttpException
        $exception = $this->prepareException($exception);

        // Default response
        $response = [
            'message' => 'Sorry, something went wrong.'
        ];

        // Add debug info if app is in debug mode
        if (config('app.debug')) {
            $response['exception'] = get_class($exception); // Reflection might be better here
            $response['message'] = $exception->getMessage();
            $response['trace'] = $exception->getTrace();
        }

        $status = 400;

        switch ($exception) {
            case $exception instanceof ValidationException:
                return $this->convertValidationExceptionToResponse($exception, $request);
            case $exception instanceof AuthenticationException:
                $status = 401;
                $response['message'] = Response::$statusTexts[$status];
                break;
            case $this->isHttpException($exception):
                $status = $exception->getStatusCode();
                $response['message'] = Response::$statusTexts[$status];
                break;
            default:
                break;
        }

        return response()->json($response, $status);
    }

}
