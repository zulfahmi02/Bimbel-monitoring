# Bimbel Pados Ilmu - Platform Monitoring & Game Edukasi

<p align="center">
  <img src="storage/app/public/logo.png" alt="Bimbel Pados Ilmu Logo" width="120">
</p>

<p align="center">
  <strong>Platform Monitoring Akademik dengan Game Edukasi Interaktif</strong>
</p>

<p align="center">
  Platform modern untuk memantau perkembangan belajar siswa dengan pendekatan gamifikasi yang menyenangkan.
</p>

---

## 📋 Tentang Project

**Bimbel Pados Ilmu** adalah platform monitoring akademik berbasis web yang menggabungkan manajemen sekolah dengan game edukasi interaktif. Platform ini memungkinkan:

- **Guru** untuk membuat dan mengelola game edukasi
- **Orang Tua** untuk memantau perkembangan belajar anak
- **Siswa** untuk belajar sambil bermain game interaktif
- **Admin** untuk mengelola seluruh sistem melalui Filament

## ✨ Fitur Utama

### 👨‍🏫 Untuk Guru
- ✅ Membuat game edukasi dengan berbagai format (Pilihan Ganda, Benar/Salah, Isian)
- ✅ Mengelola pertanyaan dan materi pembelajaran
- ✅ Melihat statistik dan progress siswa
- ✅ Dashboard analytics dengan grafik

### 👨‍👩‍👧‍👦 Untuk Orang Tua
- ✅ Memantau aktivitas belajar anak
- ✅ Melihat hasil game dan skor
- ✅ Tracking progress pembelajaran
- ✅ Download laporan PDF

### 🎮 Untuk Siswa
- ✅ Bermain game edukasi interaktif
- ✅ Sistem poin dan leaderboard
- ✅ Materi pembelajaran yang menyenangkan
- ✅ Badge dan reward

### 🔐 Untuk Admin
- ✅ Approval guru dan orang tua
- ✅ Manajemen user melalui Filament
- ✅ Monitoring sistem
- ✅ Konfigurasi platform

## 🛠️ Tech Stack

- **Framework**: Laravel 12
- **Frontend**: Tailwind CSS 4, Alpine.js
- **Database**: SQLite (default), MySQL/PostgreSQL (optional)
- **Admin Panel**: Filament 4
- **Authentication**: Laravel Multi-Guard (Teacher, Parent, Admin)
- **UI Components**: Glassmorphism, Animations

## 📦 Instalasi

### Prerequisites

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite (atau MySQL/PostgreSQL)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd Dashboard_Monitoring
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database**
   ```bash
   # Untuk SQLite (default)
   touch database/database.sqlite
   
   # Atau edit .env untuk MySQL/PostgreSQL
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=bimbel_pados_ilmu
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```
   
   Seeder akan membuat:
   - 15 Mata Pelajaran
   - 7 Guru (5 approved, 2 pending)
   - 12 Orang Tua (10 approved, 2 pending)
   - 20 Siswa (SD, SMP, SMA)
   - 3 Template Game
   - 15 Game dengan 5-10 pertanyaan masing-masing
   - 1 Admin User

6. **Setup Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Build Assets**
   ```bash
   npm run build
   # Atau untuk development
   npm run dev
   ```

8. **Run Application**
   ```bash
   php artisan serve
   ```
   
   Aplikasi akan berjalan di `http://localhost:8000`

## 🔑 Login Credentials

Setelah menjalankan seeder, gunakan kredensial berikut untuk login:

### 🔐 Admin (Filament Panel)
- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@padosilmu.com`
- **Password**: `admin123`

### 👨‍🏫 Guru (Approved)
- **URL**: `http://localhost:8000/teacher/login`
- **Email**: `budi.santoso@padosilmu.com`
- **Password**: `password123`

**Guru Lainnya**:
- `siti.nurhaliza@padosilmu.com` - password123
- `ahmad.fauzi@padosilmu.com` - password123
- `dewi.lestari@padosilmu.com` - password123
- `rizki.ramadhan@padosilmu.com` - password123

### 👨‍👩‍👧‍👦 Orang Tua (Approved)
- **URL**: `http://localhost:8000/parent/login`
- **Email**: `agus.setiawan@gmail.com`
- **Password**: `password123`

**Orang Tua Lainnya**:
- `rina.wati@gmail.com` - password123
- `bambang.hermawan@gmail.com` - password123
- `sari.indah@gmail.com` - password123
- (dan 6 lainnya dengan password yang sama)

## 📁 Struktur Project

```
Dashboard_Monitoring/
├── app/
│   ├── Filament/          # Filament Admin Resources
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/      # Authentication Controllers
│   │   │   ├── Teacher/   # Teacher Controllers
│   │   │   ├── Parent/    # Parent Controllers
│   │   │   └── Student/   # Student Controllers
│   │   └── Middleware/    # Custom Middleware
│   └── Models/            # Eloquent Models
├── database/
│   ├── migrations/        # Database Migrations
│   └── seeders/           # Database Seeders
├── resources/
│   └── views/
│       ├── auth/          # Login & Register Pages
│       ├── teacher/       # Teacher Dashboard & Views
│       ├── parent/        # Parent Dashboard & Views
│       ├── student/       # Student Game Views
│       └── layouts/       # Layout Templates
├── routes/
│   └── web.php            # Web Routes
└── public/
    └── storage/           # Public Storage (logo, images)
```

## 🎨 Fitur UI/UX

- ✅ **Premium Design** dengan glassmorphism effects
- ✅ **Responsive** untuk desktop dan mobile
- ✅ **Loading States** pada semua form
- ✅ **Password Strength Indicator** pada registrasi
- ✅ **Show/Hide Password Toggle**
- ✅ **Animated Backgrounds** dengan blob animations
- ✅ **Toast Notifications** untuk feedback
- ✅ **Error Handling** yang user-friendly

## 🔒 Security Features

- ✅ Password hashing dengan bcrypt
- ✅ CSRF Protection pada semua form
- ✅ Rate Limiting untuk login (5 attempts/minute)
- ✅ Multi-guard authentication
- ✅ Approval system untuk Teacher & Parent
- ✅ Middleware protection untuk routes

## 📊 Database Schema

### Main Tables
- `users` - Admin users
- `teachers` - Guru dengan approval system
- `parents` - Orang tua dengan approval system
- `students` - Siswa dengan education & class level
- `subjects` - Mata pelajaran
- `game_templates` - Template game (multiple choice, true/false, etc)
- `games` - Game yang dibuat guru
- `game_questions` - Pertanyaan dalam game
- `game_sessions` - Sesi bermain siswa
- `game_answers` - Jawaban siswa

## 🚀 Development

### Running Development Server
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite Dev Server
npm run dev
```

### Creating New Seeder
```bash
php artisan make:seeder NamaSeeder
```

### Creating New Migration
```bash
php artisan make:migration create_table_name
```

### Refresh Database
```bash
php artisan migrate:fresh --seed
```

## 📝 TODO / Roadmap

- [ ] Email verification system
- [ ] Forgot password functionality
- [ ] Leaderboard system
- [ ] Badge & reward system
- [ ] PDF report export
- [ ] Dashboard analytics charts
- [ ] Notification system
- [ ] API endpoints for mobile app
- [ ] Automated testing

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is licensed under the MIT License.

## 👥 Team

**Bimbel Pados Ilmu Development Team**

## 📞 Contact

- **Website**: https://padosilmu.com
- **Email**: info@padosilmu.com
- **Phone**: +62 812-3456-7890

---

<p align="center">
  Made with ❤️ by Bimbel Pados Ilmu Team
</p>
