<?php
namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Repository\UserRepository;

class UserService {
    private UserRepository $repo;
    private string $secret;

    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
        $this->secret = $_ENV['JWT_SECRET']; 
    }

    public function register($data) {
        $nama = $data['nama'] ?? '';
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $role = strtolower(trim($data['role'] ?? ''));

        //  Validasi semua field wajib diisi
    if (!$nama || !$username || !$password || !$role) {
        throw new \Exception("Nama, username, password, dan role wajib diisi");
    }

    //  Validasi role hanya admin atau staff
    if (!in_array($role, ['admin', 'kasir'])) {
        throw new \Exception("Role hanya boleh 'admin' atau 'kasir'");
    }

        if ($this->repo->findByUsername($username)) {
            return false; // Username sudah ada
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        return $this->repo->createUser($nama, $username, $hashedPassword, $role);
    }

   public function getCurrentUser(string $token) {
    return JWT::decode($token, new Key($this->secret, 'HS256'));
    $user = $this->repo->findById($decoded->id);
    if (!$user) {
        throw new \Exception("User tidak ditemukan");
    }

    return $user;
}

}