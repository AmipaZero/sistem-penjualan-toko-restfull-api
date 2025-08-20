<?php

namespace App\Controller;

use App\Service\ReturnsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ReturnsController
{
    public function __construct(private ReturnsService $service)
    {
        $this->service = $service;
    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->service->getAll();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
        public function getById(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $returns = $this->service->getById((int)$args['id']);
        if (!$returns) {
            $response->getBody()->write(json_encode(['message' => 'Returns tidak ditemukan']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($returns));
        return $response->withHeader('Content-Type', 'application/json');
    }
      public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $returns = $this->service->create($body);

        $response->getBody()->write(json_encode($returns));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
     public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $returns = $this->service->update((int)$args['id'], $body);

        if (!$returns) {
            $response->getBody()->write(json_encode(['message' => 'Returns tidak ditemukan']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($returns));
        return $response->withHeader('Content-Type', 'application/json');
    }

        public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->service->delete((int)$args['id']);
        $response->getBody()->write(json_encode(['message' => 'Returns berhasil dihapus']));
        return $response->withHeader('Content-Type', 'application/json');
    }

}