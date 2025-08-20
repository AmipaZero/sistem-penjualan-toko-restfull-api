<?php
namespace App\Model;

class Product 
{
    public int $id;
    public string $kode_produk;
    public string $nama;
    public int $categorie_id;
    public int $stok;
    public float $harga_jual;
    public string $created_at;

    public function __construct(array $data = [])
    { 
        if (!empty($data)) {
        $this->id = (int) $data['id'];
        $this->kode_produk = $data['kode_produk'];
        $this->nama = $data['nama'];
        $this->categorie_id = (int) $data['categorie_id'];
        $this->stok = (int) $data['stok'];
        $this->harga_jual = (float) $data['harga_jual'];
        $this->created_at = new \DateTime($data['created_at']);
        }
    }
}
