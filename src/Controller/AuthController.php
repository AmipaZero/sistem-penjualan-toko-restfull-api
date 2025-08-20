<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\AuthService;

class AuthController {
    private AuthService $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function login(Request $request, Response $response) {
        $data = (array)$request->getParsedBody();
        $result = $this->service->login($data['username'] ?? '', $data['password'] ?? '');

        if (!$result) {
            $response->getBody()->write(json_encode(['message' => 'Login gagal']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function logout(Request $request, Response $response) {
        $user = $request->getAttribute('user');
        $this->service->logout($user->id);

        $response->getBody()->write(json_encode(['message' => 'Logout berhasil']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}