<?php

namespace App\Service;

use App\Model\Product;
use App\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
        
    }

    public function getById(int $id): ?Product
    {
        return $this->repo->findById($id);
        if (!$mobil) {
        $response->getBody()->write(json_encode([
            'status' => 'fail',
            'message' => 'product tidak ditemukan',
        ]));
        return $response->withStatus(404)
                        ->withHeader('Content-Type', 'application/json');
    }
    }

    public function create(array $data): Product
    {
    $product = new Product();
    $product->kode_produk = $data['kode_produk'];
    $product->nama = $data['nama'];
    $product->category_id = (int) $data['category_id'];
    $product->stok = (int) $data['stok'];
    $product->harga_jual = (float) $data['harga_jual'];
    $this->repo->save($product);

    return $product;
    }

    public function update(int $id, array $data): ?Product
    {
        $product = $this->repo->findById($id);
        if (!$product) {
            return null; // atau throw exception
        }

        $product->kode_produk = $data['kode_produk'] ?? $product->kode_produk;
        $product->nama = $data['nama'] ?? $product->nama;
        $product->category_id = isset($data['category_id']) ? (int) $data['category_id'] : $product->category_id;
        $product->stok = isset($data['stok']) ? (int) $data['stok'] : $product->stok;
        $product->harga_jual = isset($data['harga_jual']) ? (float) $data['harga_jual'] : $product->harga_jual;

        $this->repo->update($product);
        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->repo->findById($id);
        if (!$product) {
            return false;
        }

        return $this->repo->delete($id);
    }
        public function report(): array
    {
        return $this->repo->findAll();
    }

}