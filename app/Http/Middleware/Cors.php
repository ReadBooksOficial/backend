<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
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
        $allowedOrigins = explode(',', config('app.frontend_urls'));
        $allowedIps = explode(',', config('app.allowed_ips'));
        $origin = $request->headers->get('Origin');
        $clientIp = $request->ip(); // Obtém o IP do cliente

        // se não tiver origin (navegador/postman) não permite fazer a menos que esteja com ip permitido
        if (!$origin && !in_array($clientIp, $allowedIps)) {
            return response()->json(['message' => 'CORS: Seu IP nao esta aqui'], 403);
        }
        
        $response = $next($request);
        if($origin){
            if (in_array($origin, $allowedOrigins)) {
                $response->header('Access-Control-Allow-Origin', $origin);
            }else{
                return response()->json(['message' => "CORS: Seu site nao esta aqui" . $origin], 403);
            }

        }

        return $response
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN');
    }
}
