<?php
require_once 'db_connect.php'; 
header('Content-Type: application/json');

$response = [
    'eligibility' => [
        'is_eligible' => false,
        'message' => 'Lengkapi data IPK dan Semester untuk cek kelayakan.',
        'class' => 'alert alert-info'
    ],
    'documents_html' => '<div class="alert alert-warning">Pilih Jenis Beasiswa untuk melihat persyaratan dokumen spesifik.</div>'
];

try {
    if (!isset($conn) || !$conn) {
        throw new Exception("Koneksi database tidak tersedia.");
    }

    // Ambil input dengan filter_input()
    $scholarship_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $ipk_input = filter_input(INPUT_POST, 'ipk', FILTER_VALIDATE_FLOAT);
    $semester_input = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);

    // VALIDASI INPUT BENAR (tidak boleh null)
    if ($scholarship_id === null || $ipk_input === null || $semester_input === null) {
        echo json_encode($response);
        exit;
    }

    // VALIDASI RANGE IPK (FIX BUG IPK 8 Lolos)
    if ($ipk_input < 0 || $ipk_input > 4.0) {
        $response['eligibility'] = [
            'is_eligible' => false,
            'message' => "❌ IPK tidak valid. Rentang IPK adalah 0.00 - 4.00",
            'class' => 'alert alert-danger'
        ];
        echo json_encode($response);
        exit;
    }

    // Ambil kriteria beasiswa
    $sql_criteria = "SELECT kriteria_ipk_min, kriteria_semester_max 
                     FROM scholarship_types WHERE id = ?";
    $stmt_criteria = $conn->prepare($sql_criteria);
    $stmt_criteria->bind_param("i", $scholarship_id);
    $stmt_criteria->execute();
    $criteria = $stmt_criteria->get_result()->fetch_assoc();
    $stmt_criteria->close();

    if (!$criteria) {
        throw new Exception("Kriteria beasiswa tidak ditemukan.");
    }

    $ipk_min = (float)$criteria['kriteria_ipk_min'];
    $semester_max = (int)$criteria['kriteria_semester_max'];

    /** ---------------------
     *  LOGIKA KELAYAKAN FIX
     * --------------------- */

    if ($ipk_input >= $ipk_min && $semester_input <= $semester_max) {
        $response['eligibility'] = [
            'is_eligible' => true,
            'message' => "🎉 <b>Lolos Kelayakan Awal!</b> Anda memenuhi kriteria IPK ($ipk_input) dan Semester ($semester_input). Silakan lengkapi dokumen.",
            'class' => 'alert alert-success'
        ];
    } else {
        $response['eligibility'] = [
            'is_eligible' => false,
            'message' => "❌ Tidak Lolos. Minimal IPK: $ipk_min dan maksimal semester: $semester_max.",
            'class' => 'alert alert-danger'
        ];
    }

    // Load dokumen (tidak diubah)
    $sql_docs = "SELECT document_name, input_name, is_required 
                 FROM scholarship_requirements WHERE scholarship_type_id = ?";
    $stmt_docs = $conn->prepare($sql_docs);
    $stmt_docs->bind_param("i", $scholarship_id);
    $stmt_docs->execute();
    $result_docs = $stmt_docs->get_result();

    $documents_html = '<h4 class="mb-3 mt-4" style="color:#a9d1ff;font-weight:700;">📄 Upload Dokumen</h4>';

    if ($result_docs->num_rows > 0) {
        while ($doc = $result_docs->fetch_assoc()) {
            $req = $doc['is_required'] ? 'required' : '';
            $mark = $doc['is_required'] ? '<span style="color:red;">*</span>' : '';
            $documents_html .= '
                <div class="mb-4">
                    <label class="form-label">' . htmlspecialchars($doc['document_name']) . ' ' . $mark . '</label>
                    <input type="file" class="form-control" name="' . htmlspecialchars($doc['input_name']) . '" accept=".pdf,.jpg,.jpeg,.png" ' . $req . '>
                </div>
            ';
        }
    } else {
        $documents_html .= '<div class="alert alert-success">Tidak ada dokumen tambahan.</div>';
    }

    $stmt_docs->close();
    $response['documents_html'] = $documents_html;

    echo json_encode($response);

} catch (Exception $e) {
    $response['eligibility'] = [
        'is_eligible' => false,
        'message' => '❌ FATAL: ' . $e->getMessage(),
        'class' => 'alert alert-danger'
    ];
    echo json_encode($response);
}
?>
