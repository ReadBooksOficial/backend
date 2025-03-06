<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserToken;

class CheckUserToken
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
        $user = auth()->user();
        $token = $request->bearerToken();
    
        // Verifica se o token existe na tabela
        // $tokenExists = \DB::table('pacoca.user_tokens')->where('user_id', $user->id)->where('token', $token)->exists();
        $tokenExists = UserToken::where('user_id', $user->id)->where('token', $token)->exists();
    
        if (!$tokenExists) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        return $next($request);
    }
}
