# 📄 SELAKSA - Sistem Elektronik Layanan Keabsahan Dokumen Kependudukan

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-06B6D4?style=flat&logo=tailwindcss&logoColor=white)

## 🎯 Deskripsi

**SELAKSA** adalah sistem manajemen dokumen elektronik yang dirancang khusus untuk mengelola proses verifikasi dan penerbitan dokumen kependudukan antar daerah di Jawa Tengah. Sistem ini memfasilitasi komunikasi dan koordinasi antara Dinas Kependudukan dan Pencatatan Sipil (Dukcapil) tingkat provinsi dan kabupaten/kota.

## ✨ Fitur Utama

### 🔐 Multi-Level User Management
- **Superadmin**: Kelola user dan monitor sistem secara keseluruhan
- **Provinsi**: Verifikasi permohonan dan terbitkan dokumen untuk wilayah luar Jateng
- **Kota/Kabupaten**: Ajukan permohonan dan kelola balasan dokumen

### 📋 Manajemen Dokumen
- **Pengajuan Permohonan**: Upload dan submit dokumen untuk verifikasi
- **Proses Verifikasi**: Review dan validasi dokumen oleh tim provinsi
- **Penerbitan Balasan**: Generate dan distribusi dokumen hasil verifikasi
- **Tracking Status**: Monitor real-time status permohonan (BELUM → DIPROSES → SELESAI/DITOLAK)

### 🔄 Workflow Management  
- **Ajukan Ulang**: Re-submit permohonan yang ditolak dengan data ter-update
- **Filter & Search**: Pencarian berdasarkan status, bulan, dan kriteria lainnya
- **Statistik Dashboard**: Overview jumlah permohonan per status dan periode

### 🛡️ Security Features
- Role-based access control (RBAC)
- File authorization (user hanya akses file milik sendiri)
- Input validation dan CSRF protection
- Secure file upload dengan type validation

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 11.x
- **Database**: MySQL 8.0+
- **Language**: PHP 8.1+
- **Authentication**: Laravel Sanctum
- **File Storage**: Laravel Storage (local/public disk)

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Vanilla JS (DOM manipulation)
- **Icons**: Font Awesome 6.4
- **UI Components**: Custom Blade components
- **Responsive**: Mobile-first design

### Development Tools
- **Build Tool**: Vite
- **Package Manager**: Composer & NPM
- **Version Control**: Git
- **Environment**: Laravel Sail (Docker) atau XAMPP/Laragon

## 🚀 Installation Guide

### Prerequisites
- PHP >= 8.1
- Composer >= 2.0
- Node.js >= 18.x & NPM
- MySQL >= 8.0
- Web Server (Apache/Nginx)

### 1. Clone Repository
```bash
git clone <repository-url> selaksa
cd selaksa
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=selaksa
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration & Seeding
```bash
# Run migrations
php artisan migrate

# Seed default data (optional)
php artisan db:seed
```

### 6. Storage Setup
```bash
# Create storage symlink
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache
```

### 7. Build Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

### 8. Start Development Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👥 User Roles & Access

### 🔧 Superadmin
- **Login**: `/login` dengan credentials superadmin
- **Capabilities**:
  - Kelola user (create, read, update, delete)
  - Monitor semua permohonan dan penerbitan
  - Akses laporan sistem
  - Konfigurasi sistem

### 🏛️ User Provinsi  
- **Login**: `/login` dengan credentials provinsi
- **Menu Utama**:
  - **Dashboard**: Statistik dan overview
  - **Verifikasi**: Review dan approve/reject permohonan dari kab/kota
  - **Penerbitan**: Kelola dokumen untuk permohonan luar Jateng
- **Workflow**: Terima permohonan → Verifikasi → Terbitkan balasan

### 🏢 User Kota/Kabupaten
- **Login**: `/login` dengan credentials daerah  
- **Menu Utama**:
  - **Dashboard**: Statistik permohonan pribadi
  - **Permohonan**: Buat dan kelola permohonan baru
  - **Penerbitan**: Upload balasan untuk permohonan yang diterima
  - **Balasan**: Monitor status permohonan yang diajukan
- **Workflow**: Buat permohonan → Upload dokumen → Tunggu verifikasi → Terima balasan

## 📁 Struktur Project

```
selaksa/
├── app/
│   ├── Http/Controllers/
│   │   ├── Kota/                   # Controllers untuk user kab/kota
│   │   ├── Provinsi/               # Controllers untuk user provinsi  
│   │   └── Superadmin/             # Controllers untuk superadmin
│   ├── Models/                     # Eloquent models
│   └── View/Components/            # Blade components
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/                    # Data seeders
├── public/
│   ├── css/                        # Custom CSS files
│   ├── js/                         # JavaScript files
│   ├── img/                        # Images & assets  
│   └── data/                       # Static data (JSON)
├── resources/
│   ├── views/
│   │   ├── components/             # Reusable Blade components
│   │   ├── kota/                   # Views untuk user kab/kota
│   │   ├── provinsi/               # Views untuk user provinsi
│   │   └── superadmin/             # Views untuk superadmin
│   └── css/                        # Source CSS files
└── storage/
    └── app/public/                 # File uploads (permohonan, penerbitan)
```

## 🎮 Usage Examples

### Membuat Permohonan (User Kab/Kota)
1. Login sebagai user daerah
2. Navigasi ke menu **Permohonan**  
3. Klik **Buat Permohonan**
4. Isi form lengkap (nama subjek, daerah tujuan, dll)
5. Upload file PDF permohonan
6. Submit dan tunggu verifikasi dari provinsi

### Verifikasi Permohonan (User Provinsi)
1. Login sebagai user provinsi
2. Navigasi ke menu **Verifikasi**
3. Lihat daftar permohonan dengan status **BELUM**
4. Klik **Detail** untuk review dokumen
5. Pilih **SETUJUI** atau **TOLAK** dengan alasan
6. Sistem otomatis update status permohonan

### Ajukan Ulang (Re-submit)
1. User kab/kota buka menu **Balasan**
2. Cari permohonan dengan status **DITOLAK**  
3. Klik **Detail** untuk lihat alasan penolakan
4. Klik tombol **AJUKAN ULANG**
5. Form terbuka dengan data lama ter-isi
6. Edit data yang perlu diperbaiki dan submit ulang

## 🔧 Configuration

### File Upload Settings
```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### Validation Rules
- **PDF Files**: Max 10MB, hanya format PDF
- **File Names**: Auto-generated dengan timestamp dan random string
- **Access Control**: File hanya bisa diakses oleh owner dan pihak terkait

## 🚧 Development

### Adding New Features
1. Create migration untuk database changes
2. Update model dengan relationships
3. Create/update controllers dengan proper authorization
4. Design views dengan consistent UI
5. Add routes dengan middleware protection
6. Test semua scenarios (create, read, update, delete)

### Code Structure Best Practices
- Follow Laravel naming conventions
- Use Form Request untuk validation
- Implement Repository pattern untuk complex queries
- Create reusable Blade components
- Add proper error handling dan user feedback

## 🤝 Contributing

1. Fork repository
2. Create feature branch: `git checkout -b feature/new-feature`
3. Commit changes: `git commit -am 'Add new feature'`
4. Push to branch: `git push origin feature/new-feature`
5. Submit pull request dengan deskripsi lengkap

### Development Guidelines
- Follow PSR-12 coding standards
- Write descriptive commit messages
- Add comments untuk complex logic
- Test pada multiple user roles sebelum submit
- Update dokumentasi jika ada perubahan API

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙋‍♂️ Support

Untuk pertanyaan, bug reports, atau feature requests:
- Create issue di GitHub repository
- Contact development team
- Check documentation untuk troubleshooting

---

**Dikembangkan dengan ❤️ untuk digitalisasi layanan publik Jawa Tengah**
