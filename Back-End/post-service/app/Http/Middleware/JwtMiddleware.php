<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // Get JWT token from the Authorization header

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $secretKey = env('JWT_SECRET'); // Use the secret key from .env
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256')); // Decode token
            dd($decoded);
            // Optionally, attach decoded user data to the request
            $request->attributes->set('jwt_payload', (array) $decoded);
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid token', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }


}
