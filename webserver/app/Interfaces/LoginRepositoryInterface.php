<?php

namespace App\Interfaces;
use Hyperf\HttpServer\Contract\RequestInterface;

interface LoginRepositoryInterface {
  public function login(RequestInterface $request);
  public function register(RequestInterface $request);
}