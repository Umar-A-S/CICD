<?php
// FILE: dashboard_admin.php (REVISI PENUH)
ini_set('display_errors', 1); // Matikan display error di production, gunakan log
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

// Pastikan user adalah Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$page = isset($_GET['p']) ? $_GET['p'] : 'dashboard';

// Ambil pesan sukses atau error dari session
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

// =========================================================================
// 1. FUNGSI DAN LOGIKA PENGAMBILAN DATA
// =========================================================================

// Implementasi fungsi untuk menampilkan status
function display_status_badge_admin($status) {
    $text = '';
    $class = '';
    switch ($status) {
        case 'draft': $text = 'Draft'; $class = 'bg-secondary text-white'; break;
        case 'submitted': $text = 'Menunggu Verifikasi'; $class = 'bg-warning text-dark'; break;
        case 'in_process': $text = 'Dalam Proses Validasi'; $class = 'bg-info text-white'; break;
        case 'accepted': $text = 'Diterima'; $class = 'bg-success text-white'; break;
        case 'rejected': $text = 'Ditolak'; $class = 'bg-danger text-white'; break;
        default: $text = 'Tidak Diketahui'; $class = 'bg-light text-dark';
    }
    return "<span class='badge $class'>$text</span>";
}

// --- 1.1 Data Ringkasan Dashboard (KPI) ---
$total_submitted = $conn->query("SELECT COUNT(id) FROM applications WHERE status = 'submitted' OR status = 'in_process'")->fetch_row()[0];
$total_accepted = $conn->query("SELECT COUNT(id) FROM applications WHERE status = 'accepted'")->fetch_row()[0];
$total_rejected = $conn->query("SELECT COUNT(id) FROM applications WHERE status = 'rejected'")->fetch_row()[0];
$total_applications = $conn->query("SELECT COUNT(id) FROM applications")->fetch_row()[0];
$today_submitted = $conn->query("SELECT COUNT(id) FROM applications WHERE DATE(tanggal_pengajuan) = CURDATE()")->fetch_row()[0];
$acceptance_rate = $total_applications > 0 ? round(($total_accepted / $total_applications) * 100) : 0;

// --- 1.2 Data Pengajuan untuk List Verifikasi ---
$verification_list = [];
if ($page === 'verification') {
    $sql_verif = "SELECT a.id, u.nim, u.nama, u.ipk, u.semester, s.nama_beasiswa, a.tanggal_pengajuan, a.status 
                  FROM applications a
                  JOIN users u ON a.user_id = u.id
                  JOIN scholarship_types s ON a.scholarship_type_id = s.id
                  WHERE a.status IN ('submitted', 'in_process')
                  ORDER BY a.tanggal_pengajuan ASC";
    $result_verif = $conn->query($sql_verif);
    if ($result_verif) {
        while ($row = $result_verif->fetch_assoc()) {
            $verification_list[] = $row;
        }
    }
}

// --- 1.3 Data Detail Pengajuan (Untuk detail_verification) ---
$detail_app = null;
$applicant_docs = [];
if ($page === 'detail_verification' && isset($_GET['id'])) {
    $app_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    // Query Utama: Ambil detail pengajuan, user, dan data beasiswa aktif
    $sql_detail = "SELECT a.*, u.nim, u.nama, u.email, u.phone_number, u.ipk, u.semester, s.nama_beasiswa, 
                    s.id AS scholarship_type_id
                   FROM applications a
                   JOIN users u ON a.user_id = u.id
                   JOIN scholarship_types s ON a.scholarship_type_id = s.id
                   WHERE a.id = ?";
    $stmt_detail = $conn->prepare($sql_detail);
    $stmt_detail->bind_param("i", $app_id);
    $stmt_detail->execute();
    $detail_app = $stmt_detail->get_result()->fetch_assoc();
    $stmt_detail->close();

    // Query Dokumen: Ambil dokumen yang diunggah
    if ($detail_app) {
        $sql_docs = "SELECT nama_dokumen, file_path FROM application_documents WHERE application_id = ?";
        $stmt_docs = $conn->prepare($sql_docs);
        $stmt_docs->bind_param("i", $app_id);
        $stmt_docs->execute();
        $result_docs = $stmt_docs->get_result();
        while($row = $result_docs->fetch_assoc()) {
            $applicant_docs[] = $row;
        }
        $stmt_docs->close();
    }
}

// --- 1.4 Data User (Untuk halaman users) ---
$users_list = [];
if ($page === 'users') {
    $sql_users = "SELECT id, nim, nama, email, role, ipk, semester, phone_number FROM users ORDER BY id DESC";
    $result_users = $conn->query($sql_users);
    if ($result_users) {
        while ($row = $result_users->fetch_assoc()) {
            $users_list[] = $row;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Beasiswa</title>
    <link rel="icon" href="crown-user-svgrepo-com.svg" type="image/svg+xml">
    <style>
        :root{
            --accent-1: #667eea;
            --accent-2: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
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
        .sidebar ul li a.text-danger{color:#fca5a5}
        .sidebar ul li a.text-danger:hover{background:rgba(239,68,68,0.15)}

        .main-content{
            margin-left:260px; flex:1; padding:28px;
            background:radial-gradient(1200px 600px at 10% 10%, rgba(102,126,234,0.08), transparent),
                       linear-gradient(135deg, var(--bg-dark-2) 0%, var(--bg-dark-1) 100%);
        }

        h2{font-size:24px; font-weight:700; color:#e6f0ff; margin-bottom:18px}
        h3{font-size:18px; font-weight:700; color:#e6f0ff; margin-bottom:14px}
        h5{font-size:14px; font-weight:600; color:#cfe1ff; margin-bottom:10px}

        .card{
            border-radius:14px;
            background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
            border:1px solid rgba(255,255,255,0.03);
            box-shadow:0 10px 40px rgba(2,6,23,0.6);
            padding:24px;
            margin-bottom:24px;
        }

        .row{display:flex; gap:20px; flex-wrap:wrap; margin-bottom:24px}
        .col-md-4{flex:1; min-width:280px}

        .stat-card{
            border-radius:14px; padding:20px; color:white;
            background-clip:padding-box;
            transition:transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover{transform:translateY(-4px); box-shadow:0 12px 36px rgba(0,0,0,0.3)}
        .stat-card.bg-primary{background:linear-gradient(135deg, rgba(102,126,234,0.25), rgba(118,75,162,0.15)); border:1px solid rgba(102,126,234,0.3)}
        .stat-card.bg-success{background:linear-gradient(135deg, rgba(16,185,129,0.25), rgba(5,150,105,0.15)); border:1px solid rgba(16,185,129,0.3)}
        .stat-card.bg-warning{background:linear-gradient(135deg, rgba(245,158,11,0.25), rgba(217,119,6,0.15)); border:1px solid rgba(245,158,11,0.3)}
        .stat-card h5{color:#cfe1ff; margin-bottom:8px}
        .stat-card .number{font-size:32px; font-weight:700; color:#e6f0ff; margin:8px 0}
        .stat-card p{font-size:13px; opacity:0.9}

        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            padding:10px 16px; border-radius:10px; cursor:pointer; border:none;
            font-weight:600; text-decoration:none; transition:all 0.2s;
        }
        .btn-primary{background:linear-gradient(90deg, var(--accent-1), var(--accent-2)); color:white}
        .btn-primary:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(102,126,234,0.25)}
        .btn-secondary{background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); color:#e6eefc}
        .btn-success{background:linear-gradient(90deg, var(--success), #059669); color:white}
        .btn-success:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(16,185,129,0.25)}
        .btn-info{background:var(--info); color:white}
        .btn-lg{padding:12px 24px; font-size:15px}
        .btn-sm{padding:6px 12px; font-size:13px}

        .table-responsive{overflow-x:auto; border-radius:10px}
        .table{
            width:100%; border-collapse:collapse;
            background:rgba(255,255,255,0.01);
            border:1px solid rgba(255,255,255,0.03);
        }
        .table thead{background:rgba(102,126,234,0.08); border-bottom:1px solid rgba(255,255,255,0.05)}
        .table th{padding:12px 14px; color:#cfe1ff; font-weight:600; text-align:left}
        .table td{padding:12px 14px; border-bottom:1px solid rgba(255,255,255,0.02)}
        .table tbody tr:hover{background:rgba(102,126,234,0.05)}
        .table a{color:var(--accent-1); text-decoration:none; font-weight:600}
        .table a:hover{text-decoration:underline}
        .badge{display:inline-block; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600}
        .badge.status-draft{background:rgba(107,114,137,0.2); color:#cbd5e1}
        .badge.status-submitted{background:rgba(245,158,11,0.2); color:#fcd34d}
        .badge.status-in-process{background:rgba(59,130,246,0.2); color:#93c5fd}
        .badge.status-accepted{background:rgba(16,185,129,0.2); color:#86efac}
        .badge.status-rejected{background:rgba(239,68,68,0.2); color:#fca5a5}

        .alert{
            padding:14px 16px; border-radius:10px; margin-bottom:16px;
            border:1px solid;
        }
        .alert-success{background:linear-gradient(135deg, rgba(16,185,129,0.15), rgba(5,150,105,0.1)); color:#86efac; border-color:rgba(16,185,129,0.2)}
        .alert-danger{background:linear-gradient(135deg, rgba(239,68,68,0.15), rgba(220,38,38,0.1)); color:#fca5a5; border-color:rgba(239,68,68,0.2)}
        .alert-info{background:linear-gradient(135deg, rgba(59,130,246,0.15), rgba(37,99,235,0.1)); color:#93c5fd; border-color:rgba(59,130,246,0.2)}

        .form-group{margin-bottom:16px}
        .form-group label{display:block; color:#cfe1ff; font-weight:600; margin-bottom:6px}
        .form-control, .form-select{
            width:100%; padding:10px 12px; border-radius:10px;
            border:1px solid rgba(255,255,255,0.04);
            background:rgba(255,255,255,0.02); color:#e6eefc;
        }
        .form-control::placeholder{color:rgba(230,238,252,0.35)}
        .form-control:focus, .form-select:focus{outline:none; border-color:var(--accent-1); box-shadow:0 0 0 3px rgba(102,126,234,0.1)}

        .list-group{list-style:none}
        .list-group-item{
            padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.02);
            color:#e6eefc;
        }
        .list-group-item strong{color:#cfe1ff}

        @media (max-width:768px){
            .sidebar{width:180px}
            .main-content{margin-left:180px; padding:16px}
            .card{padding:16px}
            .col-md-4{min-width:200px}
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <ul>
                <li><a class="<?php echo ($page == 'dashboard' ? 'active' : ''); ?>" href="?p=dashboard">Dashboard</a></li>
                <li><a class="<?php echo ($page == 'verification' || $page == 'detail_verification' ? 'active' : ''); ?>" href="?p=verification">Verifikasi Pengajuan</a></li>
                <li><a class="<?php echo ($page == 'users' ? 'active' : ''); ?>" href="?p=users">Kelola User</a></li>
                <li><a class="<?php echo ($page == 'scholarship_management' ? 'active' : ''); ?>" href="admin_scholarship_management.php">Manajemen Beasiswa</a></li>
                <li><a class="<?php echo ($page == 'export_data' ? 'active' : ''); ?>" href="?p=export_data">Export Data</a></li>
                <li><a class="text-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div style="max-width:100%; padding:0">

                <?php if ($success_message): ?>
                    <div class="alert alert-success">✅ <?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger">❌ <?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <?php if ($page === 'dashboard'): ?>
                    
                    <h2>Dashboard Admin</h2>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card stat-card bg-primary">
                                <h5>Pengajuan Hari Ini</h5>
                                <div class="number"><?php echo $today_submitted; ?></div>
                                <p>Pengajuan baru yang masuk hari ini.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card bg-success">
                                <h5>Tingkat Penerimaan</h5>
                                <div class="number"><?php echo $acceptance_rate; ?>%</div>
                                <p>Persentase pengajuan diterima.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card bg-warning">
                                <h5>Perlu Diverifikasi</h5>
                                <div class="number"><?php echo $total_submitted; ?></div>
                                <p>Total pengajuan menunggu/diproses.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <h5 style="margin-bottom:20px">Distribusi Status Pengajuan Keseluruhan</h5>
                        <div style="width:100%; max-width:500px; margin:0 auto">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    
                <?php elseif ($page === 'verification'): ?>
                    
                    <h2>Verifikasi Pengajuan (<?php echo count($verification_list); ?> Data)</h2>
                    
                    <?php if (empty($verification_list)): ?>
                        <div class="alert alert-info" style="text-align:center; padding:40px">
                            🎉 Tidak ada pengajuan yang perlu diverifikasi saat ini.
                            <br><a href="?p=dashboard" class="btn btn-sm btn-info" style="margin-top:16px">Kembali ke Dashboard</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mahasiswa (NIM)</th>
                                        <th>Beasiswa</th>
                                        <th>IPK / Semester</th>
                                        <th>Tanggal Submit</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($verification_list as $app): ?>
                                    <tr>
                                        <td><strong>#<?php echo $app['id']; ?></strong></td>
                                        <td>
                                            <?php echo htmlspecialchars($app['nama']); ?>
                                            <div class="text-muted" style="font-size:13px">(<?php echo htmlspecialchars($app['nim']); ?>)</div>
                                        </td>
                                        <td><?php echo htmlspecialchars($app['nama_beasiswa']); ?></td>
                                        <td><?php echo htmlspecialchars($app['ipk'] ?? '-') . " / Smt " . htmlspecialchars($app['semester'] ?? '-'); ?></td>
                                        <td><?php echo date('d M Y', strtotime($app['tanggal_pengajuan'])); ?></td>
                                        <td><?php echo display_status_badge_admin($app['status']); ?></td>
                                        <td>
                                            <a href="?p=detail_verification&id=<?php echo $app['id']; ?>" class="btn btn-sm btn-primary" style="color: white;">Lihat</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                <br><h2>Beasiswa Aktif (<?php echo ($total_accepted);?>)</h2><br>
                <?php
                // Ambil data beasiswa aktif
                $active_scholarships = [];
                $sql_active = "SELECT a.id, u.nim, u.nama, s.nama_beasiswa, a.active_start_date, a.active_end_date
                               FROM applications a
                               JOIN users u ON a.user_id = u.id
                               JOIN scholarship_types s ON a.scholarship_type_id = s.id
                               WHERE a.status = 'accepted' AND CURDATE() BETWEEN a.active_start_date AND a.active_end_date
                               ORDER BY a.active_end_date ASC";
                $result_active = $conn->query($sql_active);
                if ($result_active) {
                    while ($row = $result_active->fetch_assoc()) {
                        $active_scholarships[] = $row;
                    }
                }
                ?>
                <?php if (empty($active_scholarships)): ?>
                    <div class="alert alert-info" style="text-align:center; padding:40px">
                        ℹ️ Tidak ada beasiswa aktif saat ini.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mahasiswa (NIM)</th>
                                    <th>Beasiswa</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($active_scholarships as $scholarship): ?>
                                <tr>
                                    <td><strong>#<?php echo $scholarship['id']; ?></strong></td>
                                    <td>
                                        <?php echo htmlspecialchars($scholarship['nama']); ?>
                                        <div class="text-muted" style="font-size:13px">(<?php echo htmlspecialchars($scholarship['nim']); ?>)</div>
                                    </td>
                                    <td><?php echo htmlspecialchars($scholarship['nama_beasiswa']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($scholarship['active_start_date'])); ?></td>
                                    <td><?php echo date('d M Y', strtotime($scholarship['active_end_date'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php elseif ($page === 'detail_verification'): ?>
                    
                    <?php if (!$detail_app): ?>
                        <div class="alert alert-danger">❌ Pengajuan tidak ditemukan atau ID tidak valid.</div>
                    <?php else: ?>
                        <a href="?p=verification" class="btn btn-secondary" style="margin-bottom:16px"> Kembali ke Verifikasi</a>
                        
                        <h3>Verifikasi Pengajuan <?php echo htmlspecialchars($detail_app['id']); ?> : <?php echo htmlspecialchars($detail_app['nama_beasiswa']); ?></h3>
                        <p style="margin-bottom:16px">Status saat ini : <span class="badge status-<?php echo $detail_app['status']; ?>"><?php echo display_status_badge_admin($detail_app['status']); ?></span></p>
                        
                        <div class="row">
                            <div class="col-md-4" style="min-width:250px">
                                <div class="card">
                                    <h5>DATA MAHASISWA</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">Nama : <?php echo htmlspecialchars($detail_app['nama']); ?></li>
                                        <li class="list-group-item">NIM : <?php echo htmlspecialchars($detail_app['nim']); ?></li>
                                        <li class="list-group-item">IPK/Semester : <?php echo htmlspecialchars($detail_app['ipk'] ?? '-') . " / Smt " . htmlspecialchars($detail_app['semester'] ?? '-'); ?></li>
                                        <li class="list-group-item">WA : <?php echo htmlspecialchars($detail_app['phone_number']); ?></li>
                                    </ul>
                                    
                                    <h5 style="margin-top:16px">DOKUMEN YANG DIUNGGAH</h5>
                                    <ul class="list-group">
                                        <?php if (empty($applicant_docs)): ?>
                                            <li class="list-group-item" style="color:var(--danger)">Dokumen tidak ditemukan.</li>
                                        <?php else: ?>
                                            <?php foreach ($applicant_docs as $doc): ?>
                                            <li class="list-group-item">
                                                <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" style="color:var(--accent-1)">📄 <?php echo htmlspecialchars($doc['nama_dokumen']); ?></a>
                                            </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-md-4" style="min-width:250px">
                                <div class="card">
                                    <h5>AKSI VERIFIKASI</h5><br>
                                    <form action="admin_verification_logic.php" method="POST">
                                        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($detail_app['id']); ?>">
                                        <input type="hidden" name="scholarship_type_id" value="<?php echo htmlspecialchars($detail_app['scholarship_type_id']); ?>">
                                        
                                        <div class="form-group">
                                            <label for="new_status">Status Baru</label>
                                            <select class="form-control" id="new_status" name="new_status" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="in_process" style="color: black;">Dalam Proses Validasi</option>
                                                <option value="accepted" style="color: black;">Diterima</option>
                                                <option value="rejected" style="color: black;">Ditolak</option>
                                            </select>
                                        </div>

                                        <!-- <div class="form-group" id="active-date-fields" style="display:none">
                                            <label for="active_start_date">Tanggal Mulai Aktif</label>
                                            <input type="date" class="form-control" id="active_start_date" name="active_start_date">
                                            <label for="active_end_date" style="margin-top:10px">Tanggal Akhir Aktif</label>
                                            <input type="date" class="form-control" id="active_end_date" name="active_end_date">
                                        </div> -->

                                        <div class="form-group">
                                            <label for="catatan">Catatan Admin</label>
                                            <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Tulis catatan untuk mahasiswa..."></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary" style="width:100%">Simpan Keputusan</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                
                <?php elseif ($page === 'users'): ?>
                    
                    <h2>Kelola User (<?php echo count($users_list); ?> User)</h2>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>IPK</th>
                                    <th>Semester</th>
                                    <th>No. HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users_list)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align:center; padding:40px; color:var(--muted)">Tidak ada user ditemukan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users_list as $user): ?>
                                    <tr>
                                        <td><strong>#<?php echo htmlspecialchars($user['id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($user['nim']); ?></td>
                                        <td><?php echo htmlspecialchars($user['nama']); ?></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" style="color:var(--accent-1); text-decoration:none; word-break:break-all">
                                                <?php echo htmlspecialchars($user['email']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($user['role'] === 'admin'): ?>
                                                <span class="badge" style="background:rgba(239,68,68,0.2); color:#fca5a5">👨‍💼 Admin</span>
                                            <?php else: ?>
                                                <span class="badge" style="background:rgba(59,130,246,0.2); color:#93c5fd">👤 Student</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo ($user['ipk'] ? number_format($user['ipk'], 2) : '-'); ?></td>
                                        <td><?php echo ($user['semester'] ? htmlspecialchars($user['semester']) : '-'); ?></td>
                                        <td><?php echo ($user['phone_number'] ? htmlspecialchars($user['phone_number']) : '-'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                <?php elseif ($page === 'export_data'): ?>
                    
                    <h2>Export Data Laporan</h2>
                    <p style="margin-bottom:24px; color:#cfe1ff">Pilih data yang ingin diexport. Laporan akan diunduh dalam format <strong>CSV</strong>:</p>
                    <div style="display:flex; gap:12px; flex-direction:column; max-width:500px">
                        <a href="export_data.php?type=all_applications" class="btn btn-primary btn-lg">Export Semua Pengajuan</a>
                        <a href="export_data.php?type=submitted_in_process" class="btn btn-info btn-lg">Export Pengajuan Aktif</a>
                        <a href="export_data.php?type=accepted_only" class="btn btn-success btn-lg">Export Daftar Penerima</a>
                    </div>
                    
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Logika Chart Dashboard ---
            const ctx = document.getElementById('myChart');
            if (ctx) {
                const chartData = {
                    labels: ['Diterima', 'Ditolak', 'Diproses / Menunggu'],
                    datasets: [{
                        label: 'Status Pengajuan',
                        data: [
                            <?php echo $total_accepted; ?>, 
                            <?php echo $total_rejected; ?>, 
                            <?php echo $total_submitted; ?>
                        ],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.7)', 
                            'rgba(220, 53, 69, 0.7)',
                            'rgba(255, 193, 7, 0.7)'   
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)',
                            'rgba(255, 193, 7, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Status Pengajuan Keseluruhan'
                            }
                        }
                    }
                });
            }

            // --- Logika Dynamic Form untuk active_start/end_date ---
            const statusSelect = document.getElementById('new_status');
            const dateFields = document.getElementById('active-date-fields');
            const startDateInput = document.getElementById('active_start_date');
            const endDateInput = document.getElementById('active_end_date');
            
            function toggleDateFields() {
                if (statusSelect.value === 'accepted') {
                    dateFields.style.display = 'block';
                    startDateInput.setAttribute('required', 'required');
                    endDateInput.setAttribute('required', 'required');
                } else {
                    dateFields.style.display = 'none';
                    startDateInput.removeAttribute('required');
                    endDateInput.removeAttribute('required');
                }
            }
            
            // Panggil saat load dan saat terjadi perubahan
            if (statusSelect) {
                toggleDateFields(); // Set status awal
                statusSelect.addEventListener('change', toggleDateFields);
            }
        });
    </script>
</body>
</html>