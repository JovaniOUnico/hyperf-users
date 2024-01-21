<?php

namespace App\Middleware;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\Di\Container;
use Hyperf\Utils\Context;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function Hyperf\Support\env;

class AuthMiddleware implements MiddlewareInterface
{
      /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;
    protected $jwtSecretKey;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
        $this->jwtSecretKey = env('JWT_SECRET_KEY');
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->request->getHeader('Authorization');

        if (empty($token)) {
            return $this->response->json(['error' => 'Token de autenticação ausente'], 401);
        }
        
        try {
            
            $decoded = JWT::decode($token[0], new Key($this->jwtSecretKey, 'HS256'));
            $this->container->set('user', $decoded);
        } catch (\Exception $e) {
            return $this->response->json(['error' => 'Token de autenticação inválido'], 401);
        }
        
        return $handler->handle($request);
    }
    
}