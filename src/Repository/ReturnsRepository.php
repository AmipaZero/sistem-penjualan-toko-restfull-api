<?php
namespace App\Repository;
use PDO;
use App\Model\Returns;

class ReturnsRepository
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
   public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM returns");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Returns::class);
    }

       public function save(Returns $returns): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO returns (sale_detail_id, jumlah, alasan, user_id)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $returns->sale_detail_id,
            $returns->jumlah,
            $returns->alasan,
            $returns->user_id
        ]);
    }
         public function findById(int $id): ?Returns
    {
        $stmt = $this->db->prepare("SELECT * FROM returns WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetchObject(Returns::class);
        return $result ?: null;
    }
     public function update(Returns $returns): bool
    {
    $stmt = $this->db->prepare("
        UPDATE returns
        SET sale_detail_id = ?, jumlah = ?, alasan = ?, user_id = ?
        WHERE id = ?
    ");
    return $stmt->execute([
        $returns->sale_detail_id,
        $returns->jumlah,
        $returns->alasan,
        $returns->user_id,
        $returns->id,
    ]);
    }
       public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM returns WHERE id = ?");
        return $stmt->execute([$id]);
    }

}