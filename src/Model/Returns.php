<?php
namespace App\Model;

class Returns 
{
    public int $id;
    public string $sale_detail_id;
    public string $jumlah;
    public string $alasan;
    public string $user_id;
        public string $created_at;

    public function __construct(array $data = [])
    { 
        if (!empty($data)) {
        $this->id = (int) $data['id'];
        $this->sale_detail_id = (int) $data['sale_detail_id'];
        $this->jumlah = (int) $data['jumlah'];
        $this->alasan = $data['alasan'];
        $this->user_id = $data['user_id'] ?? 0;
        $this->tanggal = new \DateTime($data['tanggal']);
        }
    }

}
