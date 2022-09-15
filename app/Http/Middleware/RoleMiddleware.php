<?php

namespace App\Http\Middleware;

use App\Traits\ResponseJsonTrait;
use Closure;

class RoleMiddleware
{
    use ResponseJsonTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!in_array(auth()->user()->role, $roles)) {
            return $this->responseError('forbidden');
        }

        return $next($request);
    }
}
