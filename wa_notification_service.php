<?php
// FILE: wa_notification_service.php (REVISI)
// Layanan ini dipanggil oleh submit_application.php dan admin_verification_logic.php

// Pastikan db_connect.php menyediakan $conn
include_once 'db_connect.php'; 

/**
 * Fungsi untuk mencatat riwayat notifikasi ke tabel 'notifications'.
 * Ini harus dipanggil SETIAP KALI mencoba mengirim notifikasi.
 */
function log_notification($conn, $user_id, $application_id, $message_body, $status) {
    // Pastikan status adalah 'success' atau 'failed'
    $status = ($status === true) ? 'success' : 'failed';

    // ASUMSI: Tabel notifications memiliki kolom status_kirim (VARCHAR)
    $sql_log = "INSERT INTO notifications (user_id, application_id, pesan, tanggal_kirim, status_kirim) 
                VALUES (?, ?, ?, NOW(), ?)";
    
    $stmt_log = $conn->prepare($sql_log);
    
    // Pastikan application_id bisa berupa NULL jika notifikasi tidak terikat pengajuan (misal: notifikasi registrasi)
    // Di sini kita asumsikan application_id selalu ada.
    $stmt_log->bind_param("iiss", $user_id, $application_id, $message_body, $status);
    
    if (!$stmt_log->execute()) {
        error_log("Error logging WA notification: " . $stmt_log->error);
        $stmt_log->close();
        return false;
    }
    
    $stmt_log->close();
    return true;
}


/**
 * Fungsi utama untuk mengirim notifikasi WA.
 */
function send_wa_notification($conn, $user_id, $application_id, $message_body) {
    
    // --- Konfigurasi API ---
    // GANTI DENGAN ENDPOINT DAN TOKEN API WHATSAPP ANDA YANG SEBENARNYA
    $api_token = "YOUR_WA_API_TOKEN_HERE"; // Contoh: Token Fonnte/Twilio
    $api_url = "https://your-wa-gateway.com/api/send-message"; 
    // -----------------------
    
    // 1. Ambil nomor WA user dari DB
    $stmt_user = $conn->prepare("SELECT phone_number FROM users WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result = $stmt_user->get_result();
    $user = $result->fetch_assoc();
    $stmt_user->close();

    if (!$user || empty($user['phone_number'])) {
        error_log("Gagal mengirim WA: Nomor WA tidak ditemukan untuk User ID: $user_id");
        // Log kegagalan karena tidak ada nomor WA
        log_notification($conn, $user_id, $application_id, $message_body, false);
        return false;
    }

    $target_wa = $user['phone_number'];
    
    // 2. IMPLEMENTASI KIRIM WA MENGGUNAKAN cURL
    
    $data = [
        'target' => $target_wa, // Nomor tujuan
        'message' => $message_body
        // Tambahkan parameter lain sesuai kebutuhan API Anda
    ];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $api_token,
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    $is_sent_success = false;

    if (!$err) {
        $api_response = json_decode($response, true);
        // Sesuaikan validasi sukses berdasarkan respons API Anda
        if (isset($api_response['status']) && $api_response['status'] == 'success') {
            $is_sent_success = true;
        } else {
            error_log("Gagal mengirim WA (API Response): " . $response);
        }
    } else {
        error_log("Gagal mengirim WA (cURL Error): " . $err);
    }

    // 3. Log Notifikasi ke tabel notifications
    log_notification($conn, $user_id, $application_id, $message_body, $is_sent_success);

    return $is_sent_success;
}
?>