<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordConfirmation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  \Closure
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $password = $request->input('password');

        // Retrieve the current authenticated user
        $user = Auth::user();

        if ($user && !Hash::check($password, $user->password)) {
            return response()->json(['status' => 'Error', 'message' => 'Invalid password'], 403);
        }
        
        // $user = Auth::guard('customers')->user();

        // if ($user && !Hash::check($password, $user->password)) {
        //     return response()->json(['status' => 'Error', 'message' => 'Invalid password'], 403);
        // }

        return $next($request);
    }
}
