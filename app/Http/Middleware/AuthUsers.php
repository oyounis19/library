<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            // Check if a user is authenticated
            if (Auth::check()) {
                return $next($request); // User is authenticated, proceed
            }
            throw new \Exception();
        }catch(\Exception $e){
            // User not authenticated; redirect to a login page
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }
    }
}
