<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class CheckUserTokenApi
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
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token não fornecido'], 401);
        }

        try {
            $user = $this->getUserFromToken($token);

            if (!$user || !isset($user['id'])) {
                return response()->json(['message' => 'Usuário inválido'], 401);
            }


            $request->merge([
                'user_id' => $user['id'],
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                ],
            ]);
            
            return $next($request);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    private function getUserFromToken(string $token){
        $isLocal = App::environment('local') && config("app.pacoca_api_url") === config("app.rita_api_url");

        if ($isLocal) {
            $user = \App\Http\Controllers\UserController::verifyTokenInternal($token);

            if (!$user || empty($user['valid'])) {
                throw new \Exception("Token inválido (local)");
            }

            return $user;
        }

        $response = Http::withToken($token)->acceptJson()->post(config("app.pacoca_api_url") . "/verify-token");

        if ($response->failed() || empty($response->json('valid'))) {
            throw new \Exception("Token inválido (prod)");
        }

        return $response->json();
    }
}
