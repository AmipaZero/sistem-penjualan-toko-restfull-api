<?php
namespace App\Repository;

use PDO;
use App\Model\Sale;

class SaleRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
         public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM sales ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM sales WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }
    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->repo->findById($id);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }

    public function create(Sale $sale): int
    {
        $stmt = $this->db->prepare("INSERT INTO sales (kode_penjualan, tanggal, user_id, total_harga, metode_pembayaran, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $sale->kode_penjualan,
            $sale->tanggal,
            $sale->user_id,
            $sale->total_harga,
            $sale->metode_pembayaran,
            $sale->status
        ]);
        return (int)$this->db->lastInsertId();
    }
   
}
