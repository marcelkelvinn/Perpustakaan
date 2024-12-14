# PENTING!
# Projek Perpustakaan

Aplikasi Berbasis API dengan
- perpustakaan-backend (Backend)
- perpustakaan-frontend (Frontend)

# Persiapan Penggunaan

## Backend
1. Masuk kedalam directory backend

```bash
cd perpustakaan-backend
```

2. Install dependencies untuk backend

```bash
composer install
```

3. Konfigurasi file .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

4. Jalankan migrasi database dan juga seeder untuk memasukkan data awal/dummy

```bash
php artisan migrate:fresh --seed
```

5. Jalankan perintah untuk development server

```bash
php artisan serve
```

## Frontend
1. Masuk kedalam directory backend

```bash
cd perpustakaan-frontend
```

2. Install dependencies untuk frontend

```bash
npm install
```

```bash
npm install axios
```

3. Jalankan perintah untuk development server

```bash
npm run dev
```

# Informasi Tambahan :
- Backend Menggunakan Laravel 11 berbasis SOA, sehingga controller terletak pada app/Services
- Frontend Menggunakan Vue.js dengan axios
- - - - - - - - - - - - - - - -
- Backend berjalan ada port 8000 menggunakan api, dan untuk menghubungkan ke Frondend menggunakan CORS
- Frontend berjalan pada port 5173

## Contoh akses :

sebelum membuka pada browser, jalankan development server terlebih dahulu pada terminal

backend

```bash
php artisan serve
```

frontend

```bash
npm run dev
```

- Backend :
  http://localhost:8000/api/

- Frontend :
  http://localhost:5173/
