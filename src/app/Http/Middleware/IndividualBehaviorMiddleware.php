<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IndividualBehaviorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       // dd(auth()->user()->can('show_all_data'));
        $canAccess = 'no';
        if (auth()->user()->can('show_all_data')) {
            $canAccess = 'yes';
        }
        $request->merge(['clientRoleAccess' => $canAccess]);

        return $next($request);
    }
}
