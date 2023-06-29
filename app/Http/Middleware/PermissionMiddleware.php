<?php

namespace App\Http\Middleware;

use App\Models\Permissions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()['status'] == '1') {
            if ((new Permissions)->isValid($request->getPathInfo()) && count(Session::get('routes', []))) {
                return $next($request);
            } else {
                return abort(403, 'Not permitted to access.');
            }
        } else {
            return abort(401, 'Your account is inactive.');
        }
    }
}
