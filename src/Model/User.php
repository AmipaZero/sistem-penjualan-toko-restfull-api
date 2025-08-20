<?php
namespace App\Model;

class User
{
    private ?int $id;
    private string $nama;
    private string $username;
    private string $password;
    private string $role;
    private ?string $token;
    private ?string $tokenExpiredAt;
    private string $createdAt;
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? 0;
            $this->nama = $data['nama'] ?? '';
            $this->username = $data['username'] ?? '';
            $this->password = $data['password'] ?? '';
            $this->role = $data['role'] ?? '';
            $this->tokenExpiredAt = $data['tokenExpiredAt'] ?? '';
            $this->createdAt = $data['createdAt'] ?? '';
        }
    }
 
}
