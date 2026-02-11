<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrimTrailingSlash
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $path = $request->getPathInfo(); // includes leading slash
        if ($path !== '/' && str_ends_with($path, '/')) {
            $trimmed = rtrim($path, '/');
            $qs = $request->getQueryString();
            if ($qs) {
                $trimmed .= '?'.$qs;
            }

            return redirect($trimmed, 301);
        }

        return $next($request);
    }
}

