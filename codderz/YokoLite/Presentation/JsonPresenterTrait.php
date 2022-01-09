<?php

namespace Codderz\YokoLite\Presentation;

use Codderz\YokoLite\Shared\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait JsonPresenterTrait
{
    public function successResponse($payload = null, $code = 200)
    {
        return response()->json($payload, $code);
    }

    public function errorResponse($error, $code = 400)
    {
        return response()->json(['error' => $error], $code);
    }

    //

    public function render($request, Throwable $e)
    {
        return $request->wantsJson()
            ? $this->handleApiException($request, $e)
            : parent::render($request, $e);
    }

    protected function handleApiException($request, Throwable $exception)
    {
        if ($exception instanceof Exception) {
            return $this->errorResponse($exception->getFullMessage(), $exception->getCode() ?: 403);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the call is invalid', 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found', 404);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected Exception. Try later', 500);
    }
}
