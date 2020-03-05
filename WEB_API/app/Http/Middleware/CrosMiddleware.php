<?php

namespace App\Http\Middleware;

use Closure;

class CrosMiddleware
{
    private $headers;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'X-CSRF-TOKEN,X-PINGOTHER,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Content-Range,Range,Authorization',
            'Access-Control-Allow-Credentials' => 'false',//允许客户端发送cookie
            'Access-Control-Expose-Headers'=> 'X-CSRF-TOKEN,X-PINGOTHER,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Content-Range,Range,Authorization',
        ];

        if($request->getMethod() == "OPTIONS") {
            $response = new Response('', 200);
            foreach ($this->headers as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }

        $response = $next($request);
        foreach($this->headers as $key => $value)
            $response->header($key, $value);
        return $response;

    }
}
