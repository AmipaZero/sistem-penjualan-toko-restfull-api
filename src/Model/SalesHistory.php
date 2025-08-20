<?php
namespace App\Model;

class SalesHistory
{
    public int $id;
    public int $sale_id;
    public int $user_id;
    public string $aksi;
    public ?string $catatan;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->sale_id = $data['sale_id'] ?? 0;
            $this->user_id = $data['user_id'] ?? 0;
            $this->aksi = $data['aksi'] ?? '';
            $this->catatan = $data['catatan'] ?? null;
        }
    }
}
