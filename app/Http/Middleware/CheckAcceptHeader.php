<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SimpleXMLElement;

class CheckAcceptHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $acceptHeader = $request->header('Accept');

        if (str_contains($acceptHeader, 'application/json')) {
            return response()->json($response->original, $response->status());
        } elseif (str_contains($acceptHeader, 'application/xml')) {
            return response()->xml($response->original, $response->status());
        }

        return $response;
    }
}
