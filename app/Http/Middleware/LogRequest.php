<?php

namespace App\Http\Middleware;

use Closure;

class LogRequest
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
    
    public function terminate($request, $response)
    {
      // Execute after the HTTP response has been sent to the browser
    }
    protected function log($request,$response)
    {
    }
}
