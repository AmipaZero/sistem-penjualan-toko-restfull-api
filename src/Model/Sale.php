<?php
namespace App\Model;

class Sale
{
    public int $id;
    public string $kode_penjualan;
    public string $tanggal;
    public int $user_id;
    public float $total_harga;
    public string $metode_pembayaran;
    public string $status;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->kode_penjualan = $data['kode_penjualan'] ?? '';
            $this->tanggal = $data['tanggal'] ?? date('Y-m-d H:i:s');
            $this->user_id = $data['user_id'] ?? 0;
            $this->total_harga = $data['total_harga'] ?? 0.0;
            $this->metode_pembayaran = $data['metode_pembayaran'] ?? '';
            $this->status = $data['status'] ?? 'pending';
        }
    }
}
