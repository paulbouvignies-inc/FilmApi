<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Response;

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
            $xml = new SimpleXMLElement('<root/>');
            array_walk_recursive($response->original, function ($value, $key) use ($xml) {
                $xml->addChild($key, $value);
            });
            return response($xml->asXML(),  $response->status())->header('Content-Type', 'application/xml');
        }

        return $response;
    }
}
