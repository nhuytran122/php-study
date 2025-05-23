<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->hasAnyRole(['admin',  'manager', 'employee'])){
                return $next($request);
            }
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}