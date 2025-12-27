<?php
// Skrip ini bertugas mengecek kelayakan berdasarkan input IPK dan ID Beasiswa
include 'db_connect.php'; 
header('Content-Type: application/json');

// Pastikan request menggunakan POST dan parameter lengkap
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ipk']) && isset($_POST['scholarship_type_id'])) {
    
    $ipk = (float)$_POST['ipk'];
    $scholarship_type_id = (int)$_POST['scholarship_type_id'];

    // Cegah input IPK negatif
    if ($ipk < 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'IPK tidak boleh bernilai negatif.',
            'is_eligible' => false
        ]);
        exit;
    }

    // Ambil syarat beasiswa dari database
    $stmt = $conn->prepare("SELECT nama_beasiswa, min_ipk, min_semester FROM scholarship_types WHERE id = ?");
    $stmt->bind_param("i", $scholarship_type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {

        $syarat = $result->fetch_assoc();
        $min_ipk = (float)$syarat['min_ipk'];
        $nama_beasiswa = htmlspecialchars($syarat['nama_beasiswa']);

        // =============================
        // 🔍 VALIDASI BERDASARKAN IPK
        // =============================

        // 1️⃣ IPK tidak boleh lebih dari batas maksimal
        if ($ipk > 4.0) {
            $response = [
                'status' => 'warning',
                'message' => "IPK Anda ($ipk) melebihi batas maksimal (4.0). Silakan periksa kembali data Anda.",
                'is_eligible' => false
            ];
        }
        // 2️⃣ IPK kurang dari syarat minimal
        elseif ($ipk < $min_ipk) {
            $response = [
                'status' => 'warning',
                'message' => "IPK Anda ($ipk) kurang dari syarat minimal ($min_ipk) untuk $nama_beasiswa.",
                'is_eligible' => false
            ];
        }
        // 3️⃣ IPK valid dan memenuhi syarat
        else {
            $response = [
                'status' => 'success',
                'message' => "Selamat! IPK Anda ($ipk) memenuhi syarat minimal ($min_ipk) untuk $nama_beasiswa.",
                'is_eligible' => true
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Jenis beasiswa tidak valid.',
            'is_eligible' => false
        ];
    }

    $stmt->close();
    echo json_encode($response);
    
} else {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Data input tidak lengkap.',
        'is_eligible' => false
    ]);
}
?>
