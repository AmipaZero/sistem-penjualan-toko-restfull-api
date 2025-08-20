<?php
namespace App\Repository;

use PDO;
use App\Model\SaleDetail;

class SaleDetailRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(SaleDetail $detail): void
    {
        $stmt = $this->db->prepare("INSERT INTO sale_details (sale_id, product_id, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $detail->sale_id,
            $detail->product_id,
            $detail->jumlah,
            $detail->harga_satuan,
            $detail->subtotal
        ]);
    }
}
