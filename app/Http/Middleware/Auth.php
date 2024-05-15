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
        if (!FacadesAuth::check()) {
            return redirect('/login')->with('alert', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'You must login to enter.'
            ]);
        }


        $user = FacadesAuth::user();
        $routeName = $request->route()->getName();

        switch ($routeName) {
            case 'mybusinesses':
            case 'establishments.edit':
            case 'establishments.destroy':
            case 'establishments.create':
                if (!in_array($user->role, ['Business', 'Admin'])) {
                    return redirect('/')->with('alert', [
                        'type' => 'danger',
                        'title' => 'Error!',
                        'message' => 'You are not allowed to access this page.'
                    ]);
                } else {
                    return $next($request);
                }
                break;
            case 'myreserves':
                if (!in_array($user->role, ['Client', 'Admin'])) {
                    return redirect('/')->with('alert', [
                        'type' => 'danger',
                        'title' => 'Error!',
                        'message' => 'You are not allowed to access this page.'
                    ]);
                } else {
                    return $next($request);
                }
                break;
        }
        return $next($request);
    }
}
