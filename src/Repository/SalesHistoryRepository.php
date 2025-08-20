<?php
namespace App\Repository;

use PDO;
use App\Model\SalesHistory;

class SalesHistoryRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(SalesHistory $history): void
    {
        $stmt = $this->db->prepare("INSERT INTO sales_history (sale_id, user_id, aksi, catatan) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $history->sale_id,
            $history->user_id,
            $history->aksi,
            $history->catatan
        ]);
    }
}
