# Website UMKM Makanan dengan Laravel

Ini adalah aplikasi web untuk mengelola UMKM makanan dengan fitur autentikasi role-based, manajemen produk, dan order management.

## Fitur Utama

### 1. **Sistem Autentikasi & Role**
- Login dan Register untuk pengguna baru
- 3 Role: User, Admin, dan Super Admin
- Middleware untuk pembatasan akses berdasarkan role
- Seeder untuk data awal roles dan users

### 2. **Fitur untuk User**
- Melihat daftar produk makanan
- Melihat detail produk
- Membuat pesanan dengan multiple items
- Melihat riwayat pesanan
- Melihat detail pesanan

### 3. **Fitur untuk Admin**
- CRUD Produk (Create, Read, Update, Delete)
- Melihat semua pesanan
- Mengubah status pesanan (pending, confirmed, shipped, delivered, cancelled)
- Dashboard dengan statistik

### 4. **Fitur untuk Super Admin**
- CRUD User (Create, Read, Update, Delete)
- Kelola roles user
- Dashboard dengan overview semua data
- Melihat statistik keseluruhan

## Struktur Database

### Tables
- **roles** - Tabel untuk role
- **users** - Tabel user dengan foreign key ke roles
- **products** - Tabel produk makanan
- **orders** - Tabel pesanan
- **order_items** - Tabel detail item pesanan

### Relationships
- User → hasMany Orders
- Role → hasMany Users
- Order → belongsTo User
- Order → hasMany OrderItems
- OrderItem → belongsTo Product
- OrderItem → belongsTo Order
- Product → hasMany OrderItems

## Instalasi & Setup

### Prasyarat
- PHP 8.1 atau lebih tinggi
- Composer
- Database (MySQL/SQLite)
- Node.js & npm (opsional, untuk asset building)

### Langkah-Langkah Instalasi

1. **Clone atau Setup Project**
   ```bash
   cd c:\Coding\sales-app
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Copy Environment File**
   ```bash
   copy .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   Edit file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=umkm_makanan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan Migrations**
   ```bash
   php artisan migrate
   ```

7. **Jalankan Seeders**
   ```bash
   php artisan db:seed
   ```

8. **Link Storage** (untuk upload gambar)
   ```bash
   php artisan storage:link
   ```

9. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://localhost:8000`

## Akun Test Default

Setelah menjalankan seeder, ada 3 akun default:

### 1. User Biasa
- Email: `user@example.com`
- Password: `password`

### 2. Admin
- Email: `admin@example.com`
- Password: `password`

### 3. Super Admin
- Email: `superadmin@example.com`
- Password: `password`

## Routing Structure

```
/login                          - Login page
/register                       - Register page
/dashboard                      - Dashboard (sesuai role)

User Routes (/user/*)
  /user/products              - Daftar produk
  /user/products/{id}         - Detail produk
  /user/orders                - Daftar pesanan
  /user/orders/{id}           - Detail pesanan
  /user/orders/create         - Buat pesanan baru

Admin Routes (/admin/*)
  /admin/products             - Kelola produk
  /admin/products/create      - Tambah produk
  /admin/products/{id}/edit   - Edit produk
  /admin/products/{id}        - Hapus produk
  /admin/orders               - Kelola pesanan
  /admin/orders/{id}          - Detail pesanan + ubah status

Super Admin Routes (/super-admin/*)
  /super-admin/users          - Kelola user
  /super-admin/users/create   - Tambah user
  /super-admin/users/{id}/edit - Edit user
  /super-admin/users/{id}     - Hapus user
```

## Models & Controllers

### Models
- `Role` - Model untuk role
- `User` - Model user dengan methods helper: `hasRole()`, `isAdmin()`, `isSuperAdmin()`
- `Product` - Model produk
- `Order` - Model pesanan
- `OrderItem` - Model item pesanan

### Controllers
- `AuthController` - Login, Register, Logout
- `ProductController` - CRUD produk untuk user & admin
- `OrderController` - Create order (user) & manage order (admin)
- `DashboardController` - Dashboard untuk semua role
- `Admin\UserManagementController` - CRUD user (super admin)

### Middleware
- `RoleMiddleware` - Membatasi akses berdasarkan role
- Digunakan dalam route groups

## Fitur Keamanan

1. **CSRF Protection** - Semua form dilindungi CSRF token
2. **Password Hashing** - Password di-hash menggunakan bcrypt
3. **Authorization** - Middleware role membatasi akses
4. **Route Protection** - Route dilindungi auth middleware
5. **Model Authorization** - User hanya bisa lihat pesanan mereka sendiri

## Testing Aplikasi

### 1. Test User Role
- Login sebagai user@example.com
- Lihat daftar produk di `/user/products`
- Klik produk untuk lihat detail
- Buat pesanan di `/user/orders/create`
- Lihat riwayat pesanan di `/user/orders`

### 2. Test Admin Role
- Login sebagai admin@example.com
- Akses `/admin/products` untuk CRUD produk
- Akses `/admin/orders` untuk lihat dan ubah status pesanan
- Lihat dashboard admin

### 3. Test Super Admin Role
- Login sebagai superadmin@example.com
- Akses `/super-admin/users` untuk CRUD user
- Lihat dashboard super admin dengan statistik lengkap

## Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ProductController.php
│   │   ├── OrderController.php
│   │   ├── DashboardController.php
│   │   └── Admin/
│   │       └── UserManagementController.php
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── Role.php
│   ├── User.php
│   ├── Product.php
│   ├── Order.php
│   └── OrderItem.php

resources/
└── views/
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── user/
    │   ├── dashboard.blade.php
    │   ├── products/
    │   │   ├── index.blade.php
    │   │   └── show.blade.php
    │   └── orders/
    │       ├── index.blade.php
    │       ├── create.blade.php
    │       └── show.blade.php
    ├── admin/
    │   ├── dashboard.blade.php
    │   ├── products/
    │   │   ├── index.blade.php
    │   │   ├── create.blade.php
    │   │   └── edit.blade.php
    │   └── orders/
    │       ├── index.blade.php
    │       └── show.blade.php
    └── super_admin/
        ├── dashboard.blade.php
        └── users/
            ├── index.blade.php
            ├── create.blade.php
            └── edit.blade.php

database/
├── migrations/
│   ├── 2024_12_04_000001_create_roles_table.php
│   ├── 2024_12_04_000002_add_role_id_to_users_table.php
│   ├── 2024_12_04_000003_create_products_table.php
│   ├── 2024_12_04_000004_create_orders_table.php
│   └── 2024_12_04_000005_create_order_items_table.php
└── seeders/
    ├── RoleSeeder.php
    └── DatabaseSeeder.php

routes/
└── web.php
```

## Catatan Penting

1. **File Uploads** - Produk dapat memiliki gambar. File disimpan di `storage/app/public/products`
2. **Stock Management** - Stok produk otomatis dikurangi saat order dibuat
3. **Order Status** - Ada 5 status: pending, confirmed, shipped, delivered, cancelled
4. **Validation** - Semua input divalidasi di server side
5. **Response Messages** - Flash messages untuk sukses/gagal operasi

## Troubleshooting

### 1. Error "Class not found"
```bash
php artisan clear:cache
composer dump-autoload
```

### 2. Error saat migrate
- Pastikan database sudah dibuat
- Cek konfigurasi `.env` untuk database connection

### 3. Error "No Application Encryption Key"
```bash
php artisan key:generate
```

### 4. Storage link tidak jalan
```bash
php artisan storage:link
```

### 5. Permissions error
```bash
# Windows
icacls storage /grant Everyone:F /T
icacls bootstrap/cache /grant Everyone:F /T
```

## Development Tips

1. **Tambah User Baru** - Gunakan Super Admin → Kelola User → Tambah User
2. **Tambah Produk** - Gunakan Admin → Kelola Produk → Tambah Produk
3. **Debug** - Gunakan `dd()` atau `Log::info()` di controller
4. **Database Query** - Gunakan Tinker: `php artisan tinker`

## Pengembangan Lanjutan

Untuk pengembangan lebih lanjut, Anda bisa:
1. Tambah notifikasi email
2. Tambah payment gateway
3. Tambah rating & review
4. Tambah cart system
5. Tambah report & analytics
6. Tambah API untuk mobile app
7. Tambah frontend UI framework (Bootstrap, Tailwind, dll)

## Support & License

Ini adalah template starter untuk UMKM makanan. Silakan modifikasi sesuai kebutuhan Anda.

---

**Created:** December 4, 2024
**Framework:** Laravel 11
**PHP Version:** 8.1+
