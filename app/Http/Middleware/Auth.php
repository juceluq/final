<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (FacadesAuth::check()) {
            $user = FacadesAuth::user();
            if ($user->role === 'Admin' || $user->role === 'Client') {
                return $next($request);
            } else {
                abort(403, 'Unauthorized access');
            }
        } else {
            return redirect('/login')->with('alert', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'You must login to enter.'
            ]);;
        }
    }
}
