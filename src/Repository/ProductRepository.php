<?php
namespace App\Repository;
use PDO;
use App\Model\Product;

class ProductRepository
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
   public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Product::class);
    }
     public function save(Product $product): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (kode_produk, nama, category_id, stok, harga_jual)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $product->kode_produk,
            $product->nama,
            $product->category_id,
            $product->stok,
            $product->harga_jual
        ]);
    }
     public function findById(int $id): ?Product
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetchObject(Product::class);
        return $result ?: null;
    }
    public function update(Product $product): bool
    {
    $stmt = $this->db->prepare("
        UPDATE products 
        SET kode_produk = ?, nama = ?, category_id = ?, stok = ?, harga_jual = ?
        WHERE id = ?
    ");
    return $stmt->execute([
        $product->kode_produk,
        $product->nama,
        $product->category_id,
        $product->stok,
        $product->harga_jual,
        $product->id,
    ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
      public function report(): array
    {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Product::class);
    }
}
