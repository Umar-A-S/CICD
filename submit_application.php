<?php
// FILE: submit_application.php (REVISI FINAL - AMAN DARI MANIPULASI DOKUMEN FRONTEND)

require_once 'db_connect.php'; 
require_once 'wa_notification_service.php';

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

// --- Pastikan user login ---
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    $_SESSION['error_message'] = "Akses ditolak. Silakan login kembali.";
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$upload_dir = 'uploads/'; // Direktori penyimpanan file (pastikan ada dan memiliki izin tulis!)

// =================================================================================
// LOGIKA UTAMA: CEK AKTIF & PROSES SUBMIT
// =================================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Ambil data POST & Sanitize
    $scholarship_type_id = filter_input(INPUT_POST, 'scholarship_type_id', FILTER_VALIDATE_INT);
    $ipk = filter_input(INPUT_POST, 'ipk', FILTER_VALIDATE_FLOAT);
    $semester = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);
    
    // Validasi input dasar
    if (!$scholarship_type_id || !$ipk || !$semester || $ipk > 4.0 || $semester < 1) {
        $_SESSION['error_message'] = "Validasi Gagal: Pastikan semua data akademik terisi dengan benar.";
        header("Location: dashboard_student.php?p=new_application");
        exit;
    }

    // --- KEAMANAN A: Cek Beasiswa Aktif ---
    $sql_active_check = "SELECT id FROM applications 
                         WHERE user_id = ? AND status = 'accepted' AND active_end_date >= CURDATE()";
    $stmt_active = $conn->prepare($sql_active_check);
    $stmt_active->bind_param("i", $user_id);
    $stmt_active->execute();
    if ($stmt_active->get_result()->num_rows > 0) {
        $_SESSION['error_message'] = "Pengajuan Gagal. Anda masih memiliki beasiswa aktif.";
        $stmt_active->close();
        header("Location: dashboard_student.php?p=new_application");
        exit;
    }
    $stmt_active->close();

    // ----------------------------------------------------------------------
    // --- PERBAIKAN KRITIS: AMBIL DAFTAR DOKUMEN DARI DATABASE ---
    // ----------------------------------------------------------------------
    $required_documents = [];
    
    // Dokumen Wajib Umum (Hardcoded di sini karena selalu wajib)
    $required_documents['dokumen_ktm'] = ['name' => 'KTM/Identitas Diri', 'required' => true];
    $required_documents['dokumen_khs'] = ['name' => 'KHS/Transkrip Nilai', 'required' => true];

    // Ambil dokumen spesifik dari tabel SCHOLARSHIP_REQUIREMENTS
    $sql_req = "SELECT document_name, input_name, is_required 
                FROM scholarship_requirements 
                WHERE scholarship_type_id = ?";
    $stmt_req = $conn->prepare($sql_req);
    $stmt_req->bind_param("i", $scholarship_type_id);
    $stmt_req->execute();
    $result_req = $stmt_req->get_result();
    
    while($row = $result_req->fetch_assoc()) {
        // Gabungkan dokumen umum dan spesifik
        $required_documents[$row['input_name']] = [
            'name' => htmlspecialchars($row['document_name']), 
            'required' => (bool)$row['is_required']
        ];
    }
    $stmt_req->close();
    
    if (empty($required_documents)) {
         $_SESSION['error_message'] = "Gagal: Persyaratan dokumen untuk beasiswa ini belum diatur oleh Admin.";
         header("Location: dashboard_student.php?p=new_application");
         exit;
    }
    // ----------------------------------------------------------------------

    // 2. Mulai Transaksi Database
    $conn->begin_transaction();
    $success = false;
    $uploaded_files = []; // Untuk rollback/penghapusan file jika gagal

    try {
        
        // A. INSERT data ke tabel applications
        $sql_app = "INSERT INTO applications (user_id, scholarship_type_id, status, tanggal_pengajuan) 
                    VALUES (?, ?, 'submitted', NOW())";
        $stmt_app = $conn->prepare($sql_app);
        $stmt_app->bind_param("ii", $user_id, $scholarship_type_id);
        
        if (!$stmt_app->execute()) {
            throw new Exception("Gagal menyimpan data pengajuan utama. Error: " . $stmt_app->error);
        }
        $application_id = $conn->insert_id;
        $stmt_app->close();

        // B. PROSES UPLOAD dan INSERT Dokumen (Iterasi berdasarkan daftar yang diambil dari DB)
        $allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];

        foreach ($required_documents as $input_name => $doc_info) {
            $doc_name = $doc_info['name'];
            $is_required = $doc_info['required'];

            $file_exists = isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0;

            if ($is_required && !$file_exists) {
                 // GAGAL: Dokumen wajib tidak diunggah
                throw new Exception("Dokumen '$doc_name' wajib diunggah.");
            }

            if ($file_exists) {
                $file = $_FILES[$input_name];
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                
                if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                    throw new Exception("Format file '$doc_name' (.{$file_extension}) tidak didukung. Hanya PDF, JPG, JPEG, PNG.");
                }
                
                // Buat nama file unik: [APP_ID]_[NAMA_INPUT]_[TIMESTAMP].[EXT]
                $new_file_name = $application_id . '_' . $input_name . '_' . time() . '.' . $file_extension;
                $file_path = $upload_dir . $new_file_name;
                
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    $uploaded_files[] = ['name' => $doc_name, 'path' => $file_path];

                    // INSERT path dokumen ke tabel application_documents
                    $sql_doc = "INSERT INTO application_documents (application_id, nama_dokumen, file_path) 
                                VALUES (?, ?, ?)";
                    $stmt_doc = $conn->prepare($sql_doc);
                    $stmt_doc->bind_param("iss", $application_id, $doc_name, $file_path);
                    
                    if (!$stmt_doc->execute()) {
                        throw new Exception("Gagal menyimpan data dokumen '$doc_name' ke DB.");
                    }
                    $stmt_doc->close();

                } else {
                    throw new Exception("Gagal memindahkan file '$doc_name' ke server. Periksa izin folder '$upload_dir'.");
                }
            }
            // Jika dokumen tidak wajib (is_required=false) dan file tidak ada, lewati (OK)
        }
        
        // C. UPDATE data IPK dan Semester terbaru user
        $sql_update_user = "UPDATE users SET ipk = ?, semester = ? WHERE id = ?";
        $stmt_user = $conn->prepare($sql_update_user);
        $stmt_user->bind_param("dii", $ipk, $semester, $user_id); 
        $stmt_user->execute();
        $stmt_user->close();

        // D. Commit Transaksi
        $conn->commit();
        $success = true;
        
    } catch (Exception $e) {
        // Rollback Transaksi jika terjadi Error
        $conn->rollback();
        $error_message = "Pengajuan Gagal. Pesan Error: " . $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        
        // Hapus file yang mungkin sempat terupload
        foreach ($uploaded_files as $file) {
            if (file_exists($file['path'])) {
                unlink($file['path']);
            }
        }
    }

    // 3. Notifikasi dan Redirect
    if ($success) {
        // Kirim Notifikasi WA
        $message = "🎉 Pengajuan beasiswa Anda (ID: $application_id) telah berhasil diajukan dan menunggu verifikasi admin.";
        // Tambahkan cek keberhasilan pengiriman notifikasi jika perlu
        send_wa_notification($conn, $user_id, $application_id, $message); 
        
        $_SESSION['success_message'] = "Pengajuan beasiswa Anda berhasil disubmit! Silakan cek Riwayat Pengajuan.";
        header("Location: dashboard_student.php?p=history");
    } else {
        header("Location: dashboard_student.php?p=new_application");
    }
    exit;
} else {
    header("Location: dashboard_student.php");
    exit;
}
?>