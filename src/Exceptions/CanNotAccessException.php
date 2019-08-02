<?php

namespace Samirz\Super\Exceptions;

use Exception;

class CanNotAccessException extends Exception
{

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'message' => 'Can not Access this Page',
            'type' => 'error'
        ], 403);
    }
}
