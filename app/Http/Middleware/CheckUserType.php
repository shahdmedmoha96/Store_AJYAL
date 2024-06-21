<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      // Check if the user is authenticated and if their role is 'admin'
      if ($request->user() && ($request->user()->type === 'admin'||$request->user()->type === 'super_admin')) {
        return $next($request);
    }

    // If not admin, check if the user is authenticated
    if ($request->user()) {
        return redirect('/'); // Redirect regular users to home page
    }

    return redirect('/login'); // Redirect unauthenticated users to login page

    }
}
