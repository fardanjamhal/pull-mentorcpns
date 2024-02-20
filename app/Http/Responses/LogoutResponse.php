<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Inertia\Inertia;

class LogoutResponse implements LogoutResponseContract
{

    /**
     * toResponse
     *
     * @param  mixed $request
     * @return void
     */
    public function toResponse($request)
    {
        return Inertia::location(route('home'));
    }
}
