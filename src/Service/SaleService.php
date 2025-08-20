<?php
namespace App\Service;

use App\Model\Sale;
use App\Model\SaleDetail;
use App\Model\SalesHistory;
use App\Repository\SaleRepository;
use App\Repository\SaleDetailRepository;
use App\Repository\SalesHistoryRepository;

class SaleService
{
    public function __construct(
        private SaleRepository $saleRepo,
        private SaleDetailRepository $detailRepo,
        private SalesHistoryRepository $historyRepo
    )
    {   $this->saleRepo = $saleRepo;}

     public function getAll(): array
    {
        return $this->saleRepo->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->saleRepo->findById($id);
    }
  public function createSale(array $data): void
{
    //data sale
    $sale = new Sale();
    $sale->kode_penjualan = $data['kode_penjualan'];
    $sale->tanggal = date('Y-m-d H:i:s');
    $sale->user_id = (int) $data['user_id'];
    $sale->total_harga = (float) $data['total_harga'];
    $sale->metode_pembayaran = $data['metode_pembayaran'];
    $sale->status = $data['status'] ?? 'dibayar'; 
    $saleId = $this->saleRepo->create($sale);

    // Simpan detail penjualan
    foreach ($data['products'] as $product) {
        $detail = new SaleDetail();
        $detail->sale_id = $saleId;
        $detail->product_id = (int) $product['product_id'];
        $detail->jumlah = (int) $product['jumlah'];
        $detail->harga_satuan = (float) $product['harga_satuan'];
        $detail->subtotal = (float) $product['subtotal'];

        $this->detailRepo->create($detail);
    }

    //  Simpan riwayat penjualan 
    $history = new SalesHistory();
    $history->sale_id = $saleId;
    $history->user_id = (int) $data['user_id'];
    $history->aksi = 'dibuat';
    $history->catatan = $data['catatan'] ?? null;

    $this->historyRepo->create($history);
    }
  public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }

}
