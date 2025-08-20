<?php
namespace App\Repository;
use PDO;

class AuthRepository {
    private PDO $db;
   
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // public function createUser($nama, $username, $password, $role) {
    //     $stmt = $this->db->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
    //     return $stmt->execute([$nama, $username, $password, $role]);
    // }

    public function updateToken($id, $token, $expiredAt) {
        $stmt = $this->db->prepare("UPDATE users SET token = ?, token_expired_at = ? WHERE id = ?");
        $stmt->execute([$token, $expiredAt, $id]);
    }

    public function clearToken($id) {
        $stmt = $this->db->prepare("UPDATE users SET token = NULL, token_expired_at = NULL WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

}