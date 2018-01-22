<?php namespace Satudata\Ahhprovinsi\Http\Middleware;

use Closure;

/**
 * The AhhprovinsiMiddleware class.
 *
 * @package Satudata\Ahhprovinsi
 * @author  MKI <info@mkitech.net>
 */
class AhhprovinsiMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
