<?php
namespace App\Model;

class SaleDetail
{
    public int $id;
    public int $sale_id;
    public int $product_id;
    public int $jumlah;
    public float $harga_satuan;
    public float $subtotal;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->sale_id = $data['sale_id'] ?? 0;
            $this->product_id = $data['product_id'] ?? 0;
            $this->jumlah = $data['jumlah'] ?? 0;
            $this->harga_satuan = $data['harga_satuan'] ?? 0.0;
            $this->subtotal = $data['subtotal'] ?? 0.0;
        }
    }
}
