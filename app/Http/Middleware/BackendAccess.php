<?php

namespace App\Http\Middleware;

use Closure;

class BackendAccess
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
        $allowedDesignation = [116,102,103,36,3,125,10,2,90,104,56,9,120,69,25];
        $designationId = auth()->user()->designation_id;
        if(!in_array($designationId, $allowedDesignation)) {
            abort(403);
        }
        return $next($request);
    }
}
