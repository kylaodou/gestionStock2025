<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatedBy
{
    /* public function handle(Request $request, Closure $next)
    {
        $request->merge([
            'created_by' => Auth::id(),
        ]);

        return $next($request);
    } */
}
