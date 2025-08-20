<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Repository\AuthRepository;

class AuthService {
    private AuthRepository $repo;
    private string $secret;

    public function __construct(AuthRepository $repo) {

        $this->repo = $repo;
        $this->secret = $_ENV['JWT_SECRET']; 
    }

    public function login($username, $password) {
        $user = $this->repo->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        $payload = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'exp' => time() + 36000 
        ];

        $token = JWT::encode($payload, $this->secret, 'HS256');

        // Simpan token dan expired ke database
        $this->repo->updateToken($user['id'], $token, date('Y-m-d H:i:s', $payload['exp']));

        return ['token' => $token, 'user' => $user];
    }

    public function logout($userId) {
        $this->repo->clearToken($userId);
    }

    public function verifyToken(string $token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, 'HS256'));

            $user = $this->repo->findById($decoded->id);

            if (!$user || $user['token'] !== $token) {
                throw new \Exception("Token tidak valid atau sudah logout");
            }

            if (strtotime($user['token_expired_at']) < time()) {
                throw new \Exception("Token sudah expired (di DB)");
            }

            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception("Unauthorized: " . $e->getMessage());
        }
    }
}