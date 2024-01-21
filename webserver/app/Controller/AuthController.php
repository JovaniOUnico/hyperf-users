<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\UserRegisterRequest;
use App\Request\LoginRequest;
use App\Interfaces\LoginRepositoryInterface;
use App\Repositories\LoginRepository;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Contract\RequestInterface;

class AuthController extends AbstractController
{
    protected LoginRepositoryInterface $loginRepository;
    protected ResponseInterface $response;

    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
    }

    public function login(LoginRequest $request)
    {
        return $this->loginRepository->login($request);
    }

    public function register(RequestInterface $request)
    {
        $result = $this->loginRepository->register($request);

        if ($result) {
            return $this->response->json([
                'message' => 'Usuário cadastrado com sucesso.'
            ])->withStatus(201);
        } else {
            return $this->response->json([
                'error' => 'Não foi possível realizar o cadastro.'
            ])->withStatus(500);
        } 
    }

}