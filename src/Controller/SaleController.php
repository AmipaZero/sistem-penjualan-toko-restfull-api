<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Service\SaleService;

class SaleController
{
    public function __construct(private SaleService $saleService) {}

      public function getAll(Request $request, Response $response): Response
    {
        $data = $this->saleService->getAll();
        $response->getBody()->write(json_encode(['data' => $data]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $this->saleService->createSale($data);

        $response->getBody()->write(json_encode([
            'status' => 'success',
            'message' => 'Transaksi berhasil disimpan'
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
