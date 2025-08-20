<?php
namespace App\Repository;
use PDO;
use App\Model\Category;

class CategoryRepository
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Category::class);
    }
    public function save(Category $category): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO categories (nama, deskripsi)
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $category->nama,
            $category->deskripsi,

        ]);
    }
     public function update(Category $category): bool
    {
    $stmt = $this->db->prepare("
        UPDATE products 
        SET nama = ?, deskripsi = ? WHERE id = ?
    ");
    return $stmt->execute([
        $category->nama,
        $category->deskripsi,
    ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
