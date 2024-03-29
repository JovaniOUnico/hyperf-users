<?php

namespace App\Repositories;

use App\Interfaces\LoginRepositoryInterface;
use App\Model\User;
use App\Request\LoginRequest;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Hyperf\Utils\Str;
use Hyperf\HttpServer\Contract\RequestInterface;
use function Hyperf\Support\env;

class LoginRepository implements LoginRepositoryInterface 
{
  protected $jwtSecretKey;

  public function __construct()
  {
      $this->jwtSecretKey = env('JWT_SECRET_KEY');
  }

  public function login(RequestInterface $request)
  {
      $email    = $request->input('email');
      $password = $request->input('password');

      $user = $this->getUserByEmail($email);

      if (!$user) {
          return ['error' => 'Usuário não encontrado'];
      }

      if (password_verify($password, $user->password)) {
          $tokenPayload = [
              'uuid' => $user->uuid,
              'email' => $user->email,
              'iat' => time(),
          ];

          $token = JWT::encode($tokenPayload, $this->jwtSecretKey, 'HS256');

          return ['token' => $token];
      } else {
          return ['error' => 'Senha incorreta'];
      }
  }

  private function getUserByEmail($email)
  {
    return User::where('email', $email)->first();
  }

  public function register(RequestInterface $request)
  {

    $email = $request->input('email');

    $user = $this->getUserByEmail($email);

    if ($user) {
      return false;
    }

    $user = User::create([
      // 'uuid' => Uuid::uuid4()->toString(),
      'name' => $request->input('name'), 
      'email' => $email, 
      // 'birth_date' => $request->input('birth_date'), 
      // 'document' => $request->input('document'), 
      // 'cellphone' => $request->input('cellphone'), 
      'password' => password_hash($request->input('password'), PASSWORD_BCRYPT), 
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
    ]);
      
    if($user){
      return true;
    }
  
    return false;
  }

}