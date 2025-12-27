<?php
// FILE: admin_scholarship_management.php

// --- Inisialisasi dasar ---
$action = $_GET['action'] ?? 'list';
$id      = isset($_GET['id']) ? (int) $_GET['id'] : null;
$edit_data = null;
$requirements = [];
$message = '';

// --- Session & Authentication ---
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
    session_set_cookie_params(
        $cookieParams['lifetime'], 
        $cookieParams['path'], 
        ini_get('session.cookie_domain'),
        $cookieParams['secure'], 
        $cookieParams['httponly']
    );
}

session_start();
include 'db_connect.php';

// Pastikan hanya admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// ============================================================================
// A. CREATE / UPDATE (SAVE DATA)
// ============================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_scholarship'])) {

    $id            = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nama_beasiswa = trim($_POST['nama_beasiswa']);
    $min_ipk       = filter_input(INPUT_POST, 'min_ipk', FILTER_VALIDATE_FLOAT);
    $min_semester  = filter_input(INPUT_POST, 'min_semester', FILTER_VALIDATE_INT);
    $durasi        = filter_input(INPUT_POST, 'durasi', FILTER_VALIDATE_INT);

    if (empty($nama_beasiswa) || $min_ipk === false || $min_semester === false || $durasi === false) {
        $message = "<div style='color: var(--danger-color);'>Input tidak lengkap atau tidak valid.</div>";
    } else {
        if ($id) {
            // UPDATE
            $stmt = $conn->prepare("
                UPDATE scholarship_types 
                SET nama_beasiswa = ?, kriteria_ipk_min = ?, kriteria_semester_max = ?, durasi = ?
                WHERE id = ?
            ");
            $stmt->bind_param("sdisi", $nama_beasiswa, $min_ipk, $min_semester, $durasi, $id);
        } else {
            // INSERT
            $stmt = $conn->prepare("
                INSERT INTO scholarship_types (nama_beasiswa, kriteria_ipk_min, kriteria_semester_max, durasi)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sdii", $nama_beasiswa, $min_ipk, $min_semester, $durasi);
        }

        if ($stmt->execute()) {
            $message = "<div style='color: var(--success-color);'>
                            Data beasiswa berhasil disimpan.
                        </div>";
        } else {
            $message = "<div style='color: var(--danger-color);'>
                            Terjadi kesalahan: " . $stmt->error . "
                        </div>";
        }
        $stmt->close();

        $action = 'list'; // kembali ke list
    }
}

// ============================================================================
// B. MODE EDIT → Ambil data beasiswa + dokumen wajib
// ============================================================================
if ($action == 'edit' && $id) {

    // Ambil data beasiswa
    $stmt = $conn->prepare("SELECT * FROM scholarship_types WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$edit_data) {
        $message = "<div style='color: var(--danger-color);'>Data tidak ditemukan.</div>";
        $action = 'list';
    } else {
        // Ambil document requirements
        $stmt_req = $conn->prepare("SELECT * FROM scholarship_requirements WHERE scholarship_type_id = ?");
        $stmt_req->bind_param("i", $id);
        $stmt_req->execute();
        $requirements = $stmt_req->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt_req->close();
    }
}

// ============================================================================
// C. DELETE
// ============================================================================
if ($action == 'delete' && $id) {
    $stmt = $conn->prepare("DELETE FROM scholarship_types WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "<div style='color: var(--success-color);'>Beasiswa berhasil dihapus.</div>";
    } else {
        $message = "<div style='color: var(--danger-color);'>
                        Gagal menghapus. Pastikan tidak ada pengajuan yang menggunakan beasiswa ini.
                    </div>";
    }
    $stmt->close();

    $action = 'list';
}

// ============================================================================
// D. Ambil semua data beasiswa untuk list view
// ============================================================================
$scholarships = $conn->query("SELECT * FROM scholarship_types ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Beasiswa Admin</title>
    <link rel="icon" href="crown-user-svgrepo-com.svg" type="image/svg+xml">
    <style>
        :root{
            --accent-1: #667eea;
            --accent-2: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --muted: #6c7a89;
            --bg-dark-1: #071033;
            --bg-dark-2: #0f172a;
        }

        *{box-sizing:border-box;margin:0;padding:0;text-decoration: none;}
        html,body{height:100%; background-color:var(--bg-dark-2)}
        body{
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto;
            color:#e6eefc;
            overflow-x:hidden;
        }

        .dashboard-layout{display:flex; min-height:100vh}

        .sidebar{
            position:fixed; left:0; top:0; width:260px; height:100vh;
            background:linear-gradient(180deg, rgba(15,23,42,0.95), rgba(7,16,51,0.95));
            border-right:1px solid rgba(255,255,255,0.03);
            padding-top:24px;
            z-index:100;
            overflow-y:auto;
        }

        .sidebar h3{padding:0 18px; margin-bottom:24px; font-size:18px; font-weight:700; color:#e6f0ff}

        .sidebar ul{list-style:none}
        .sidebar ul li a{
            display:block; padding:10px 18px; color:rgba(230,238,252,0.75); text-decoration:none;
            border-radius:8px; margin:3px 10px; transition:all 0.2s;
            border-left:3px solid transparent;
        }
        .sidebar ul li a:hover{background:rgba(102,126,234,0.15); color:#e6eefc}
        .sidebar ul li a.active{background:rgba(102,126,234,0.25); color:#fff; border-left-color:var(--accent-1)}

        .main-content{
            margin-left:260px; flex:1; padding:28px;
            background:radial-gradient(1200px 600px at 10% 10%, rgba(102,126,234,0.08), transparent),
                       linear-gradient(135deg, var(--bg-dark-2) 0%, var(--bg-dark-1) 100%);
        }

        .card{
            border-radius:14px;
            background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
            border:1px solid rgba(255,255,255,0.03);
            box-shadow:0 10px 40px rgba(2,6,23,0.6);
            padding:28px;
            margin-bottom:24px;
        }

        h2{font-size:24px; font-weight:700; color:#e6f0ff; margin-bottom:18px}
        h3{font-size:18px; font-weight:700; color:#e6f0ff; margin-bottom:14px}

        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            padding:10px 16px; border-radius:10px; cursor:pointer; border:none;
            font-weight:600; text-decoration:none; transition:all 0.2s;
        }
        .btn-success{background:linear-gradient(90deg, var(--success), #059669); color:white}
        .btn-success:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(16,185,129,0.25)}
        .btn-primary{background:linear-gradient(90deg, var(--accent-1), var(--accent-2)); color:white}
        .btn-primary:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(102,126,234,0.25)}

        .data-table{
            width:100%; border-collapse:collapse;
            background:rgba(255,255,255,0.01);
            border-radius:10px; overflow:hidden;
            border:1px solid rgba(255,255,255,0.03);
        }
        .data-table thead{background:rgba(102,126,234,0.08); border-bottom:1px solid rgba(255,255,255,0.05)}
        .data-table th{padding:12px 14px; color:#cfe1ff; font-weight:600; text-align:left}
        .data-table td{padding:12px 14px; border-bottom:1px solid rgba(255,255,255,0.02)}
        .data-table tbody tr:hover{background:rgba(102,126,234,0.05)}
        .data-table a{color:var(--accent-1); text-decoration:none; font-weight:600}
        .data-table a:hover{text-decoration:underline}

        .form-group{margin-bottom:16px}
        .form-group label{display:block; color:#cfe1ff; font-weight:600; margin-bottom:6px}
        .form-control{
            width:100%; padding:10px 12px; border-radius:10px;
            border:1px solid rgba(255,255,255,0.04);
            background:rgba(255,255,255,0.02); color:#e6eefc;
        }
        .form-control::placeholder{color:rgba(230,238,252,0.35)}
        .form-control:focus{outline:none; border-color:var(--accent-1); box-shadow:0 0 0 3px rgba(102,126,234,0.1)}

        .message{padding:12px 14px; border-radius:10px; margin-bottom:16px}
        .message-success{background:linear-gradient(135deg, rgba(16,185,129,0.15), rgba(5,150,105,0.1)); color:#86efac; border:1px solid rgba(16,185,129,0.2)}
        .message-danger{background:linear-gradient(135deg, rgba(239,68,68,0.15), rgba(220,38,38,0.1)); color:#fca5a5; border:1px solid rgba(239,68,68,0.2)}

        @media (max-width:768px){
            .sidebar{width:180px}
            .main-content{margin-left:180px; padding:16px}
            .card{padding:16px}
        }
        .doc-item input, .doc-item select{
            margin-top:6px; margin-bottom:10px;
        }
        .doc-item label{
            font-weight:600; color:#cfe1ff;
        }
        
    </style> 
</head>
<body>
    <div class="dashboard-layout">
        
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <ul>
                <li><a href="dashboard_admin.php?p=dashboard">Dashboard</a></li>
                <li><a href="dashboard_admin.php?p=verification">Verifikasi Pengajuan</a></li>
                <li><a href="admin_scholarship_management.php" class="active">Manajemen Beasiswa</a></li>
                <li><a href="dashboard_admin.php?p=export_data">Export Data</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="card">
                <h2>Manajemen Jenis Beasiswa (CRUD)</h2>
                
                <?php if (!empty($message)): ?>
                    <div class="message <?php echo strpos($message, 'success') !== false ? 'message-success' : 'message-danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($action == 'list'): ?>
                    
                    <div style="margin-bottom:20px">
                        <a href="?action=add" class="btn btn-success">+ Tambah Kategori Beasiswa</a>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Beasiswa</th>
                                <th>Min. IPK</th>
                                <th>Min. Semester</th>
                                <th>Durasi (Bulan)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $scholarships->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_beasiswa']); ?></td>
                                    <td><?php echo $row['kriteria_ipk_min']; ?></td>
                                    <td><?php echo $row['kriteria_semester_max']; ?></td>
                                    <td><?php echo $row['durasi']; ?></td>
                                    <td>
                                        <a href="?action=edit&id=<?php echo $row['id']; ?>">Edit</a> | 
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" style="color:var(--danger)" 
                                           onclick="return confirm('Yakin ingin menghapus beasiswa <?php echo htmlspecialchars($row['nama_beasiswa']); ?>? Data pengajuan terkait akan terpengaruh!');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                <?php elseif ($action == 'add' || $action == 'edit'): ?>

                    <h3><?php echo ($action == 'edit' ? 'Edit' : 'Tambah') . ' Jenis Beasiswa'; ?></h3>
                    <form action="admin_scholarship_management.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_data['id'] ?? ''); ?>">
                        
                        <div class="form-group">
                            <label for="nama_beasiswa">Nama Beasiswa</label>
                            <input type="text" class="form-control" id="nama_beasiswa" name="nama_beasiswa" 
                                   value="<?php echo htmlspecialchars($edit_data['nama_beasiswa'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="min_ipk">Minimal IPK (Contoh: 3.00)</label>
                            <input type="number" step="0.01" class="form-control" id="min_ipk" name="min_ipk" 
                                   value="<?php echo htmlspecialchars($edit_data['kriteria_ipk_min'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="min_semester">Maksimal Semester</label>
                            <input type="number" class="form-control" id="min_semester" name="min_semester" 
                                   value="<?php echo htmlspecialchars($edit_data['kriteria_semester_max'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="durasi">Durasi (bulan)</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" 
                                   value="<?php echo htmlspecialchars($edit_data['durasi'] ?? ''); ?>" required>
                        </div>
                        <h2>Document Requirements</h2>

                        <div id="doc-container">
                            <?php if (!empty($requirements)): ?>
                                <?php foreach ($requirements as $req): ?>
                                    <div class="doc-item" style="padding:12px; border:1px solid rgba(255,255,255,0.08); border-radius:10px; margin-bottom:12px;">
                                        
                                        <input type="hidden" name="doc_id[]" value="<?php echo $req['id']; ?>">

                                        <label>Document Name</label>
                                        <input type="text" class="form-control" name="document_name[]" 
                                            value="<?php echo htmlspecialchars($req['document_name']); ?>" required>

                                        <label style="margin-top:8px;">Input Name</label>
                                        <input type="text" class="form-control" name="input_name[]" 
                                            value="<?php echo htmlspecialchars($req['input_name']); ?>" required>

                                        <label style="margin-top:8px;">Required?</label>
                                        <select class="form-control" name="is_required[]">
                                            <option value="1" <?php echo $req['is_required'] ? 'selected' : ''; ?>>Required</option>
                                            <option value="0" <?php echo !$req['is_required'] ? 'selected' : ''; ?>>Optional</option>
                                        </select>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="opacity:0.6;">Belum ada dokumen. Tambahkan dokumen di bawah.</p>
                            <?php endif; ?>
                        </div>

                        <button type="button" id="addDoc" class="btn btn-success" style="margin-top:10px;">+ Tambah Dokumen</button>

                        <!-- Template dokumen baru -->
                        <template id="doc-template">
                            <div class="doc-item" style="padding:12px; border:1px solid rgba(255,255,255,0.08); border-radius:10px; margin-bottom:12px;">
                                <label>Document Name</label>
                                <input type="text" class="form-control" name="document_name[]" required>

                                <label style="margin-top:8px;">Input Name</label>
                                <input type="text" class="form-control" name="input_name[]" required>

                                <label style="margin-top:8px;">Required?</label>
                                <select class="form-control" name="is_required[]">
                                    <option value="1">Required</option>
                                    <option value="0">Optional</option>
                                </select>
                            </div>
                        </template>

                        <script>
                        document.getElementById("addDoc").addEventListener("click", function () {
                            const tpl = document.getElementById("doc-template").content.cloneNode(true);
                            document.getElementById("doc-container").appendChild(tpl);
                        });
                        </script>

                        
                        <div style="display:flex; gap:12px; margin-top:20px">
                            <button type="submit" name="save_scholarship" class="btn btn-primary">Simpan Data</button>
                            <a href="admin_scholarship_management.php" class="btn" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08);">Batal</a>
                        </div>
                    </form>

                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>