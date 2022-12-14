<?php

namespace App\Http\Middleware;

use App\Traits\ResponseJsonTrait;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
{
    use ResponseJsonTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array(Auth::user()->role, ['superadmin', 'admin'])) {
            return $next($request);
        }
        return $this->responseError('forbidden');
    }
}
