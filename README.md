# Sistem Penjualan Toko (RESTful API)

Aplikasi backend sederhana untuk penjualan toko menggunakan **PHP Slim Framework**.  
Dilengkapi dengan autentikasi **JWT (JSON Web Token)** untuk keamanan akses, serta role-based access control (RBAC).

---

## ✨ Fitur Utama
- **Autentikasi JWT**
  - Login & Logout
  - Register pengguna baru
- **Role-based Access**
  - **Admin**: dapat mengakses seluruh fitur, termasuk manajemen laporan.
  - **Kasir**: dapat mengakses semua fitur penjualan, kecuali laporan.

## 📌 Teknologi
- **PHP Slim Framework**
- **MySQL** sebagai database
- **JWT** untuk autentikasi
