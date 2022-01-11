<?php

namespace Codderz\YokoLite\Shared;

use Codderz\YokoLite\Shared\Utils\Reflect;
use Exception as BaseException;
use Illuminate\Http\Response;
use Throwable;

class Exception extends BaseException
{
    public static function of($message = "", $code = Response::HTTP_FORBIDDEN, Throwable $previous = null)
    {
        return new static($message, $code, $previous);
    }

    public function getFullMessage()
    {
        return $this->getType() . ': ' . $this->getMessage();
    }

    public function getType()
    {
        return Reflect::getShortClass($this);
    }
}
