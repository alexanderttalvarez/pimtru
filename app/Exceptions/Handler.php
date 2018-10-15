<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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

        if( $exception instanceof ValidationException ) {
            return $this->convertValidationExceptionToResponse( $exception, $request );
        }

        if( $exception instanceof NotFoundHttpException ) {
            return $this->errorResponse( __('errors.route_not_found') , 404);
        }

        if( $exception instanceof ModelNotFoundException ) {
            $model = strtolower( class_basename( $exception->getModel() ) );
            return $this->errorResponse( sprintf( __('errors.instance_not_found'), $model), 404);
        }

        if( $exception instanceof MethodNotAllowedHttpException ) {
            return $this->errorResponse( __('errors.method_not_allowed'), 404);
        }

        if( $exception instanceof UrlGenerationException ) {
            return $this->errorResponse( __('errors.required_parameters'), 404);
        }

        if( $exception instanceof HttpException ) {
            return $this->errorResponse( __($exception->getMessage()), $exception->getStatusCode() );
        }

        /*if( $exception instanceof FatalThrowableError ) {
            return $this->errorResponse( sprintf( __('errors.fatal_error')), 404);
        }*/


        return parent::render($request, $exception);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        if( $this->isFrontend( $request ) ) {
            return $request->ajax() ? response()->json($errors, 422) : redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors($errors);
        }

        return $this->errorResponse( $errors, 422 );
    }

    /**
     * Checks if the action is being run from the laravel frontend
     * @return boolean
     */
    private function isFrontend($request) {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
