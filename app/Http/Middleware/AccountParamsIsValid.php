<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AccountParamsIsValid
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (
            !in_array($request->route()->parameter('type'), ['phone', 'card', 'email']) ||
            empty($request->route()->parameter('id'))
        ) {
            throw new InvalidArgumentException('Wrong parameters');
        }
        return $next($request);
    }
}
