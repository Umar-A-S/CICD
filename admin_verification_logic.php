<?php
// FILE: admin_verification_logic.php (REVISI PENUH)
// print_r($_POST);
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
// Pastikan file ini ada dan berisi fungsi send_wa_notification
include 'wa_notification_service.php'; 

// Cek autentikasi dan role Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['application_id'])) {
    
    $app_id = filter_input(INPUT_POST, 'application_id', FILTER_VALIDATE_INT);
    $new_status = $_POST['new_status'];
    $admin_note = $_POST['catatan'];
    $valid_statuses = ['submitted', 'in_process', 'accepted', 'rejected']; // 'submitted' ditambahkan agar Admin bisa mengembalikan ke status 'perlu perbaikan'
    $kategori_id = filter_input(INPUT_POST, 'scholarship_type_id', FILTER_VALIDATE_INT);
    
    // Inisialisasi variabel tanggal aktif
    // $active_start_date = null;
    // $active_end_date = null;

    if (!$app_id || !in_array($new_status, $valid_statuses)) {
        $_SESSION['error_message'] = "❌ Data tidak valid atau status tidak diizinkan.";
        header("Location: dashboard_admin.php?p=detail_verification&id=" . $app_id);
        exit;
    }

    // Cek dan setting tanggal otomatis jika statusnya adalah 'accepted'
    if ($new_status === 'accepted') {

        // Ambil durasi kategori beasiswa
        $sql_durasi = "SELECT durasi FROM scholarship_types WHERE id = ?";
        $stmt_durasi = $conn->prepare($sql_durasi);
        $stmt_durasi->bind_param("i", $kategori_id);
        $stmt_durasi->execute();
        $result_durasi = $stmt_durasi->get_result();
        $row_durasi = $result_durasi->fetch_assoc();
        $durasi_bulan = $row_durasi['durasi'];
        $stmt_durasi->close();

        // Generate tanggal otomatis
        $active_start_date = date('Y-m-d H:i:s'); 
        $active_end_date   = date('Y-m-d H:i:s', strtotime("+$durasi_bulan months"));

    } else {
        // Jika bukan accepted, kosongkan tanggal aktif
        $active_start_date = null;
        $active_end_date = null;
    }

    $conn->begin_transaction();
    try {

        // Update status + tanggal otomatis
        $sql_update = "UPDATE applications 
                    SET status = ?, 
                        catatan = ?, 
                        tanggal_pengajuan = NOW(),
                        active_start_date = ?,
                        active_end_date = ?
                    WHERE id = ?";

        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param(
            "ssssi",
            $new_status,
            $admin_note,
            $active_start_date,
            $active_end_date,
            $app_id
        );
        
        $stmt_update->execute();
        $stmt_update->close();


        // 2. Ambil user_id dan phone_number untuk notifikasi
        $stmt_user = $conn->prepare("
            SELECT a.user_id, u.phone_number, s.nama_beasiswa
            FROM applications a 
            JOIN users u ON a.user_id = u.id
            JOIN scholarship_types s ON a.scholarship_type_id = s.id
            WHERE a.id = ?
        ");
        $stmt_user->bind_param("i", $app_id);
        $stmt_user->execute();
        $user_data = $stmt_user->get_result()->fetch_assoc();
        $user_id = $user_data['user_id'];
        $nama_beasiswa = $user_data['nama_beasiswa'];
        $stmt_user->close();

        // 3. Siapkan pesan notifikasi WA
        $status_text = '';
        switch ($new_status) {
            case 'in_process':
                $status_text = "sedang *Dalam Proses Validasi* oleh Admin. Berkas Anda sudah dianggap Valid. Catatan Admin: $admin_note";
                break;
            case 'submitted':
                $status_text = "dikembalikan ke status *Menunggu Verifikasi* (Perlu Perbaikan). Silakan cek catatan admin dan perbaiki berkas. Catatan Admin: $admin_note";
                break;
            case 'accepted':
                $start_formatted = date('d M Y', strtotime($active_start_date));
                $end_formatted = date('d M Y', strtotime($active_end_date));
                $status_text = "telah *DITERIMA*! 🎉 Beasiswa *$nama_beasiswa* Anda aktif mulai $start_formatted sampai $end_formatted. Catatan Admin: $admin_note";
                break;
            case 'rejected':
                $status_text = "telah *DITOLAK*. 😔 Alasan: $admin_note";
                break;
        }
        
        $wa_message = "Hai Mahasiswa, Status pengajuan Beasiswa *$nama_beasiswa* Anda (#$app_id) $status_text. Silakan cek detailnya di portal. (Sistem Informasi Beasiswa)";
        
        // 4. Kirim Notifikasi WA (Asumsi fungsi send_wa_notification sudah diimplementasikan di 'wa_notification_service.php')
        send_wa_notification($conn, $user_id, $app_id, $wa_message);

        $conn->commit();

        $_SESSION['success_message'] = "✅ Status Pengajuan #$app_id berhasil diubah menjadi '$new_status' dan notifikasi WA dikirim.";
        header("Location: dashboard_admin.php?p=detail_verification&id=" . $app_id);
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "❌ Error Verifikasi: " . $e->getMessage();
        // Redirect kembali ke halaman detail verifikasi
        header("Location: dashboard_admin.php?p=detail_verification&id=" . $app_id);
        exit;
    }

} else {
    // Jika akses langsung tanpa POST
    header("Location: dashboard_admin.php");
    exit;
}
?>