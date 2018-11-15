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
class AllowedMiddleware implements MiddlewareInterface
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
        $origin = $request->getParsedBody()['request_url'];

        if(empty($origin)){
            return response()->raw('Not Allowed Request', 405);
        }

        $allowOrigin = [
            'swoft.cn'
        ];
        $matches = [];
        preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|net)(\/|$)/isU', explode(':',$origin)[1], $matches);
        $domain = trim($matches[0], '/');
        if (!empty($domain) && in_array($domain, $allowOrigin)) {
            return $handler->handle($request);
        } else {
            return response()->raw('Not Allowed Request', 405);
        }
    }
}