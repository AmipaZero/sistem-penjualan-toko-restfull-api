<?php
namespace App\Service;

use App\Model\Returns;
use App\Repository\ReturnsRepository;

class ReturnsService
{
    private ReturnsRepository $repo;

    public function __construct(ReturnsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
        
    }
     public function create(array $data): Returns
    {
    $returns = new Returns();
    $returns->sale_detail_id = $data['sale_detail_id'];
    $returns->jumlah = (int) $data['jumlah'];
    $returns->alasan = $data['alasan'];
    $returns->user_id = $data['user_id'];
    $this->repo->save($returns);

    return $returns;
    }
        public function getById(int $id): ?Returns
    {
        return $this->repo->findById($id);
        if (!$returns) {
        $response->getBody()->write(json_encode([
            'status' => 'fail',
            'message' => 'returns tidak ditemukan',
        ]));
        return $response->withStatus(404)
                        ->withHeader('Content-Type', 'application/json');
    }
    }
      public function update(int $id, array $data): ?Returns
    {
        $returns = $this->repo->findById($id);
        if (!$returns) {
            return null; // atau throw exception
        }
        $returns->sale_detail_id = $data['sale_detail_id'] ?? $returns->sale_detail_id;
        $returns->jumlah = isset($data['jumlah']) ? $data['jumlah'] : $returns->jumlah;
        $returns->alasan = isset($data['alasan']) ? $data['alasan'] : $returns->alasan;
        $returns->user_id = $data['user_id']  ?? $returns->user_id;
        $this->repo->update($returns);
        return $returns;
    }

        public function delete(int $id): bool
    {
        $returns = $this->repo->findById($id);
        if (!$returns) {
            return false;
        }

        return $this->repo->delete($id);
    }
}
