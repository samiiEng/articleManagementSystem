<?php

namespace App\Exceptions;

use Exception;
use function Psy\debug;

class FilterFormatException extends Exception
{
    public function render()
    {
        return response()->json("<div>Your request is incorrectly formatted!</div>");
    }

    public function report()
    {
        $user = auth()->user()['username'];
        error_log("<div>$user! Your request is incorrectly formatted!</div>");
    }
}
