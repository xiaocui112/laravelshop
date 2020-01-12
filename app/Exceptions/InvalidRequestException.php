<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidRequestException extends Exception
{
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }
    /**
     * 错误处理
     *
     * @param Request $request
     * @return Illuminate\View\View|JSON
     */
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['msg' => $this->message], $this->code);
        }
        return view('pages.error', ['msg' => $this->message]);
    }
}
