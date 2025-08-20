<?php

namespace App\Config;

use PDO;

class Database {
    public static function getConnection(): PDO
    {
        return new PDO("mysql:host=localhost;dbname=penjualan-toko", "root", "mipa");
    }
}