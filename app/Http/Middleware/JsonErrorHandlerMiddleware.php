<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonErrorHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ($response->isServerError()) {return response()->json(['error' => 'Internal Server Error']);}   
        if ($response->isClientError()) {return response()->json(['error' => 'Unauthorized']);} 
        if ($response->isForbidden()) {return response()->json(['error' => 'Forbidden']);}
        return $response;
    }
}
