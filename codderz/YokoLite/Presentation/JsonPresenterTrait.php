<?php

namespace Codderz\YokoLite\Presentation;

trait JsonPresenterTrait
{
    public function successResponse($payload = null, $code = 200)
    {
        return response()->json($payload, $code);
    }

    public function errorResponse($error, $code = 400)
    {
        return response()->json($error, $code);
    }
}
