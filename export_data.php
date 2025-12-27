<?php
// FILE: export_data.php

// Configure session cookie parameters to improve compatibility on mobile browsers
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$cookieParams = [
    'lifetime' => 0,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
];
if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params($cookieParams);
} else {
    session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], ini_get('session.cookie_domain'), $cookieParams['secure'], $cookieParams['httponly']);
}
session_start();
include 'db_connect.php';

// Cek autentikasi dan role Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$report_type = isset($_GET['type']) ? $_GET['type'] : '';

if (empty($report_type)) {
    // Jika diakses tanpa parameter, arahkan kembali ke dashboard admin
    header("Location: dashboard_admin.php?p=export_data");
    exit;
}

// 1. Tentukan Query Berdasarkan Tipe Laporan
switch ($report_type) {
    case 'all_applications':
        $filename = "Laporan_Semua_Pengajuan_" . date('Ymd') . ".csv";
        $sql = "SELECT 
            a.id AS 'ID Pengajuan',
            u.nim AS 'NIM Mahasiswa',
            u.nama AS 'Nama Mahasiswa',
            s.nama_beasiswa AS 'Jenis Beasiswa',
            a.status AS 'Status',
            a.tanggal_pengajuan AS 'Tgl. Pengajuan',
            a.tanggal_keputusan AS 'Tgl. Keputusan',
            a.catatan AS 'Catatan Admin'
        FROM applications a
        JOIN users u ON a.user_id = u.id
        JOIN scholarship_types s ON a.scholarship_type_id = s.id
        ORDER BY a.tanggal_pengajuan DESC";
        break;
        
    case 'accepted_only':
        $filename = "Laporan_Beasiswa_Diterima_" . date('Ymd') . ".csv";
        $sql = "SELECT 
            u.nim AS 'NIM',
            u.nama AS 'Nama Lengkap',
            s.nama_beasiswa AS 'Jenis Beasiswa',
            u.ipk AS 'IPK',
            u.semester AS 'Semester',
            a.tanggal_keputusan AS 'Tgl. Diterima'
        FROM applications a
        JOIN users u ON a.user_id = u.id
        JOIN scholarship_types s ON a.scholarship_type_id = s.id
        WHERE a.status = 'accepted'
        ORDER BY s.nama_beasiswa, u.nim";
        break;
        
    default:
        // Tipe laporan tidak dikenal
        $_SESSION['error_message'] = "Tipe laporan tidak valid.";
        header("Location: dashboard_admin.php?p=export_data");
        exit;
}

// 2. Persiapan Header untuk Download CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// 3. Ambil data dari database
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Output data ke file CSV
    $output = fopen('php://output', 'w');
    
    // Tulis Header CSV (Nama kolom)
    $fields = $result->fetch_fields();
    $header = [];
    foreach ($fields as $field) {
        $header[] = $field->name;
    }
    // Menggunakan titik koma (;) sebagai delimiter untuk kompatibilitas Excel Indonesia
    fputcsv($output, $header, ';'); 

    // Tulis baris data
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row, ';');
    }

    fclose($output);
    exit;
} else {
    // Jika tidak ada data
    $_SESSION['error_message'] = "Tidak ada data yang tersedia untuk laporan $report_type.";
    header("Location: dashboard_admin.php?p=export_data");
    exit;
}
?>