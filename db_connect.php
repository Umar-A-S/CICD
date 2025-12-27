<?php
// FILE: db_connect.php (Versi Aman untuk AJAX)

// Include centralized logger if available
if (file_exists(__DIR__ . '/logger.php')) {
    require_once __DIR__ . '/logger.php';
}

// Pengaturan Koneksi Database
$servername = "localhost";
// PASTIKAN KREDENSIAL INI BENAR
$username = "root"; 
$password = "313233"; 
$dbname = "beasiswa_db"; 

// Membuat Koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek Koneksi
if ($conn->connect_error) {
    // ❗ PENTING: Untuk lingkungan AJAX, jika koneksi gagal,
    // kita set $conn menjadi NULL atau FALSE.
    // Kita TIDAK menggunakan die() atau exit() di sini
    // agar file yang meng-include (fetch_requirements.php)
    // dapat menangani error ini dengan JSON yang valid di blok try-catch-nya.
    
    // Simpan pesan error sebelum set $conn = null
    $error_message = $conn->connect_error;
    
    // Opsional: Log error ke file log server (gunakan logger jika tersedia)
    if (function_exists('log_error')) {
        log_error("KONEKSI DATABASE GAGAL: " . $error_message);
    } else {
        error_log("KONEKSI DATABASE GAGAL: " . $error_message);
    }
    
    $conn = null;
} else {
    // Koneksi Berhasil
    $conn->set_charset("utf8mb4");
}


// Fungsi untuk menyiapkan data user default (opsional)
function setup_default_data($conn) {
    if ($conn) { // Cek koneksi
        // Hash password 'admin123'
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

        // Cek apakah admin sudah ada
        $check_admin = "SELECT id FROM users WHERE role = 'admin'";
        $result = $conn->query($check_admin);
        
        if ($result->num_rows == 0) {
            // Tambahkan user admin default
            $sql_admin = "INSERT INTO users (nama, email, password, role) 
                          VALUES ('Admin Kampus', 'admin@kampus.ac.id', '$hashed_password', 'admin')";
            $conn->query($sql_admin);
        }
    }
}

// setup_default_data($conn); 

// Hapus tag penutup PHP untuk mencegah whitespace tambahan di output