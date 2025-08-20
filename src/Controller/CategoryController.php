<?php

namespace App\Controller;

use App\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController
{
    private CategoryService $service;

    public function __construct(CategoryService $service)
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
        $category = $this->service->getById((int)$args['id']);
        if (!$category) {
            $response->getBody()->write(json_encode(['message' => 'Mobil tidak ditemukan']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($category));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $category = $this->service->create($body);

        $response->getBody()->write(json_encode($category));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
       public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $category = $this->service->update((int)$args['id'], $body);

        if (!$category) {
            $response->getBody()->write(json_encode(['message' => 'Category tidak ditemukan']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($category));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->service->delete((int)$args['id']);
        $response->getBody()->write(json_encode(['message' => 'Category berhasil dihapus']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}