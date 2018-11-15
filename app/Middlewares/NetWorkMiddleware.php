<?php
/**
 * Created by PhpStorm.
 * User: foreverzjz
 * Date: 2018/10/26
 * Time: 11:21 AM
 */

namespace App\Middlewares;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Bean;
use Swoft\Http\Message\Middleware\MiddlewareInterface;

/**
 * @Bean()
 */
class NetWorkMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(!$this->inWhiteList()){
            return response()->raw("Not Allowed Request", 405);
        }
        return $handler->handle($request);
    }

    protected function inWhiteList()
    {
        $ip = 167772161;
        if (
            ($ip >= 167772161 && $ip <= 167837695)      //10.0.*.*
            ||
            ($ip >= 3232235520 && $ip <= 3232301055)    //192.168.*.*
            ||
            $ip == 2130706433                           //127.0.0.1
            ||
            $ip == 2032909053                           //121.43.186.253
            ||
            $ip == 460525434                            //27.115.15.122
            ||
            $ip == 2362402202                           //140.207.101.154
            ||
            $ip == 1981798741                           //118.31.217.85
            ||
            $ip == 2344942223                           //139.196.250.143
            ||
            $ip == 2346714763                           //139.224.6.139
            ||
            $ip == 460525434
            ||
            $ip == 2130706433
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}