<?php

namespace App\Service;

use App\Model\Category;
use App\Repository\CategoryRepository;

class CategoryService
{
    private CategoryRepository $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
        
    }

    public function getById(int $id): ?Category
    {
        return $this->repo->findById($id);
        if (!$mobil) {
        $response->getBody()->write(json_encode([
            'status' => 'fail',
            'message' => 'category tidak ditemukan',
        ]));
        return $response->withStatus(404)
                        ->withHeader('Content-Type', 'application/json');
    }
    }

    public function create(array $data): Category
    {
        $category = new Category();
        $category->nama = $data['nama'];
        $category->deskripsi = $data['deskripsi'];

        $this->repo->save($category);
        return $category;
    }
     public function update(int $id, array $data): ?Category
    {
        $category = $this->repo->findById($id);
        if (!$category) {
            return null; // atau throw exception
        }
        $category->nama = $data['nama'] ?? $category->nama;
        $category->deskripsi = $data['deskripsi'] ?? $category->deskripsi;
        $this->repo->update($category);
        return $category;
    }

    public function delete(int $id): bool
    {
        $category = $this->repo->findById($id);
        if (!$category) {
            return false;
        }
        return $this->repo->delete($id);
    }
}
