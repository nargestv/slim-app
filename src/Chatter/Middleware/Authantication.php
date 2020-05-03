<?php
namespace Chatter\Middleware;
use Chatter\Models\User;

class Authantication{
    public function __invoke($request, $response, $next)
    {
        $auth = $request->getHeader('Authorization');
        $_apiKey = $auth[0];
        $apikey = substr($_apiKey,strpos($_apiKey,' ')+1);
        $user = new User();
        if(!$user->authenticate($apikey)){
            $response->withStatus(401);

            return $response;
        }
        $response = $next($request, $response);
        return $response;
    }
}