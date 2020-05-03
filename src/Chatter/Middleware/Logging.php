<?php
namespace Chatter\Middleware;

class Logging{
    public function __invoke($request, $response, $next)
    {
        error_log($request->getMethod() . "--" . $request->getUrl());
        $response = $next($request, $response);
        return $response;
    }
}
