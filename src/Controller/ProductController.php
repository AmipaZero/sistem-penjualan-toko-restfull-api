<?php

namespace App\Controller;

use App\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProductController
{
    public function __construct(private ProductService $service)
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
        $product = $this->service->getById((int)$args['id']);
        if (!$product) {
            $response->getBody()->write(json_encode(['message' => 'Produk tidak ditemukan']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($product));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $product = $this->service->create($body);

        $response->getBody()->write(json_encode($product));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
    
    public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $product = $this->service->update((int)$args['id'], $body);

        if (!$product) {
            $response->getBody()->write(json_encode(['message' => 'Mobil tidak ditemukan']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($product));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->service->delete((int)$args['id']);
        $response->getBody()->write(json_encode(['message' => 'Produk berhasil dihapus']));
        return $response->withHeader('Content-Type', 'application/json');
    }
     public function report(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->service->report();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}