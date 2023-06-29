<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartClearMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cart::where('status', 2)->where('created_at', '>=', Carbon::now()->subHour())->update(['status' => 3]);
        return $next($request);
    }
}
