# Task Management System

Sistem manajemen tugas internal untuk memantau pekerjaan harian dari tim internal seperti IT, HR, dan Operasional.

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Git

## Cara Instalasi

1. Clone repository
```bash
git clone https://github.com/dwipurnomo515/task-management-system.git
cd task-management-system
```

2. Install dependencies PHP
```bash
composer install
```

3. Install dependencies Node.js
```bash
npm install
```

4. Copy file .env
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Konfigurasi database di file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task-management-system
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi dan seeder
```bash
php artisan migrate:fresh --seed
```

8. Build assets
```bash
npm run build
```

## Menjalankan Sistem

1. Jalankan server development
```bash
php artisan serve
```

2. Buka browser dan akses
```
http://localhost:8000/admin
```

## Akun Default

1. Super Admin
```
Email: admin@gmail.com
Password: password
```

2. Project Manager
```
Email: project.manager@gmail.com
Password: password
```

3. Team Member
```
Email: team.member1@gmail.com
Password: password
```

## Fitur Utama

1. Manajemen Proyek & Tugas
   - Membuat dan mengelola proyek
   - Membuat dan mengelola tugas
   - Tracking deadline

2. Pelaporan Progres
   - Dashboard dengan widget
   - Laporan per proyek
   - Laporan per user

3. Manajemen Hak Akses
   - Role-based access control
   - Super Admin, Project Manager, Team Member

## Teknologi yang Digunakan

- Laravel 12
- Filament 3
- MySQL/MariaDB
- Tailwind CSS
- Alpine.js

## Struktur Database

- users
- projects
- tasks
- roles
- permissions
- role_has_permissions
- model_has_roles
- model_has_permissions

## Kontribusi

1. Fork repository
2. Buat branch baru (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

## Lisensi

[MIT License](LICENSE)
