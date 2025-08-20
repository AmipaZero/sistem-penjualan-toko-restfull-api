<?php

namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Service\AuthService;
use Slim\Psr7\Response; 

class JwtMiddleware implements MiddlewareInterface
{
    private $authService;
    private $allowedRoles;

    public function __construct(AuthService $authService, array $allowedRoles = []) {
        $this->authService = $authService;
        $this->allowedRoles = $allowedRoles;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');

        //  Cek header Authorization
        if (!$authHeader || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            $response = new Response();
            $response->getBody()->write(json_encode([
                'message' => 'Unauthorized - Token tidak ditemukan'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        $token = $matches[1];

        try {
            //  Verifikasi token
            $decoded = $this->authService->verifyToken($token);
            
            //  Cek role
        if (!in_array($decoded->role, $this->allowedRoles)) {
            $response = new Response();
            $response->getBody()->write(json_encode([
                'message' => 'Forbidden - Anda tidak punya akses untuk role ini'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);
        }

            // Simpan user terverifikasi di request
            $request = $request->withAttribute('user', $decoded);

            // Lanjut ke handler berikutnya
            return $handler->handle($request);

        } catch (\Exception $e) {
            $response = new Response();
            $response->getBody()->write(json_encode([
                'message' => 'Unauthorized - Token tidak valid',
                'error' => $e->getMessage()
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }
    }
}
