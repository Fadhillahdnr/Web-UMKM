# UMKM Makanan - Quick Start Guide

## Instalasi Cepat (5 Menit)

### 1. Install Dependencies
```bash
composer install
```

### 2. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 3. Database Setup
Edit `.env` - sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD dengan mysql Anda:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=umkm_makanan
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian:
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 4. Jalankan Aplikasi
```bash
php artisan serve
```
Buka browser: `http://localhost:8000`

## Login Test Account

| Role | Email | Password |
|------|-------|----------|
| User | user@example.com | password |
| Admin | admin@example.com | password |
| Super Admin | superadmin@example.com | password |

## File & Struktur Penting

- **Controllers:** `app/Http/Controllers/`
- **Models:** `app/Models/`
- **Views:** `resources/views/`
- **Routes:** `routes/web.php`
- **Migrations:** `database/migrations/`
- **Middleware:** `app/Http/Middleware/RoleMiddleware.php`

## Fitur Utama

✅ Sistem Login/Register  
✅ Role-Based Access Control (User, Admin, Super Admin)  
✅ Manajemen Produk (CRUD)  
✅ Sistem Pesanan  
✅ Manajemen User (Super Admin)  
✅ Dashboard untuk setiap role  

## Halaman Utama

- `/login` - Login
- `/register` - Register baru
- `/dashboard` - Dashboard (sesuai role)
- `/user/products` - Lihat produk
- `/user/orders` - Lihat pesanan
- `/admin/products` - Kelola produk
- `/admin/orders` - Kelola pesanan
- `/super-admin/users` - Kelola user

## Database Tables

1. **roles** - user, admin, super_admin
2. **users** - dengan role_id
3. **products** - makanan
4. **orders** - pesanan dari user
5. **order_items** - detail item per pesanan

## Troubleshooting

**Error "No encryption key":**
```bash
php artisan key:generate
```

**Error "Class not found":**
```bash
composer dump-autoload
```

**Database error:**
- Buat database baru: `umkm_makanan`
- Edit `.env` dengan kredensial DB yang benar
- Jalankan `php artisan migrate`

**Storage link tidak jalan (Windows):**
```bash
php artisan storage:link
```

---

Untuk dokumentasi lengkap, lihat **SETUP_GUIDE.md**
