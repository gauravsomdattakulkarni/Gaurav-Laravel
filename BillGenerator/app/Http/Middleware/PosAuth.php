<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PosAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('pos_logged_in') !== true) {
            return redirect('/pos_login');
        }

        return $next($request);
    }
}