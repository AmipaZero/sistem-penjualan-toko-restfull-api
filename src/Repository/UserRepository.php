<?php
namespace App\Repository;
use PDO;

class UserRepository {
    private PDO $db;
   
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function createUser($nama, $username, $password, $role) {
        $stmt = $this->db->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nama, $username, $password, $role]);
    }

       public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}