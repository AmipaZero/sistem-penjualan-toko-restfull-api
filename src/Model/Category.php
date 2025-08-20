<?php
namespace App\Model;

class Category
{
    public int $id;
    public string $nama;
    public ?string $deskripsi;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->nama = $data['nama'] ?? '';
            $this->deskripsi = $data['deskripsi'] ?? null;
        }
    }
}
