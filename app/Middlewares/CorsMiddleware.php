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
class CorsMiddleware implements MiddlewareInterface
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
        $origin = $request->getUri();
        if ('OPTIONS' === $request->getMethod()) {
            return $this->configResponse(\response(), $origin);
        }

        if(empty($origin)){
            return response()->raw('No \'Access-Control-Allow-Origin\' header is present on the requested resource.Origin is therefore not allowed access.', 405);
        }

        $allowOrigin = [
            'swoft.cn'
        ];
        $matches = [];
        preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|net)(\/|$)/isU', explode(':',$origin)[1], $matches);
        $domain = trim($matches[0], '/');

        $response = $handler->handle($request);
        if (!empty($domain) && in_array($domain, $allowOrigin)) {
            return $this->configResponse($response, $origin);
        } else {
            return response()->raw('No \'Access-Control-Allow-Origin\' header is present on the requested resource.Origin is therefore not allowed access.', 405);
        }

    }

    private function configResponse(ResponseInterface $response, $origin)
    {
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
}