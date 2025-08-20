<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\UserService;

class UserController {

    private UserService $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }
    public function register(Request $request, Response $response) {
        $data = (array)$request->getParsedBody();
        $result = $this->service->register($data);

        if (!$result) {
            $response->getBody()->write(json_encode(['message' => 'Registrasi gagal']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode(['message' => 'Registrasi berhasil']));
        return $response->withHeader('Content-Type', 'application/json');
    }
     // Current User 
  public function current(Request $request, Response $response, $args) {
    $authHeader = $request->getHeaderLine('Authorization');

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        $response->getBody()->write(json_encode(['error' => 'Token tidak ditemukan']));
        return $response->withStatus(401)
                        ->withHeader('Content-Type', 'application/json');
    }

    // Ambil token dari header
    $token = str_replace('Bearer ', '', $authHeader);

    try {
        $user = $this->service->getCurrentUser($token);

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
        return $response->withStatus(401)
                        ->withHeader('Content-Type', 'application/json');
    }
}


}