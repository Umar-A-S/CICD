<?php
// FILE: dashboard_student.php (FINAL & REVISI)

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
require_once 'db_connect.php'; // Menggunakan require_once untuk keamanan

// Pastikan user adalah Mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$page = isset($_GET['p']) ? $_GET['p'] : 'dashboard';

// 1. Ambil data user dari database (termasuk NIM, IPK, Semester)
$stmt = $conn->prepare("SELECT nama, nim, ipk, semester FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// 2. Cek Status Beasiswa Aktif
$is_active_scholarship = false;
$active_scholarship_info = null;

$sql_active_check = "SELECT s.nama_beasiswa, a.active_start_date, a.active_end_date
                     FROM applications a
                     JOIN scholarship_types s ON a.scholarship_type_id = s.id
                     WHERE a.user_id = ? 
                     AND a.status = 'accepted' 
                     AND a.active_end_date >= CURDATE()"; 
$stmt_active = $conn->prepare($sql_active_check);
$stmt_active->bind_param("i", $user_id);
$stmt_active->execute();
$result_active = $stmt_active->get_result();

if ($result_active->num_rows > 0) {
    $is_active_scholarship = true;
    $active_scholarship_info = $result_active->fetch_assoc();
}
$stmt_active->close();

// 3. Implementasi fungsi untuk menampilkan status (digunakan di Riwayat)
function display_status_badge($status) {
    $text = '';
    $class = '';
    switch ($status) {
        case 'draft': $text = 'Draft'; $class = 'status-draft'; break;
        case 'submitted': $text = 'Menunggu Verifikasi'; $class = 'status-submitted'; break;
        case 'in_process': $text = 'Dalam Proses Validasi'; $class = 'status-in-process'; break;
        case 'accepted': $text = 'Diterima'; $class = 'status-accepted'; break;
        case 'rejected': $text = 'Ditolak'; $class = 'status-rejected'; break;
        default: $text = 'Tidak Diketahui'; $class = 'status-draft';
    }
    return "<span class='status-badge $class'>$text</span>";
}

// 4. Ambil daftar Jenis Beasiswa untuk Form Pengajuan
$scholarships = $conn->query("SELECT id, nama_beasiswa FROM scholarship_types ORDER BY nama_beasiswa ASC");

// 5. Ambil Riwayat Pengajuan untuk halaman 'history'
$application_history = [];
if ($page === 'history' || $page === 'detail') {
    $sql_history = "SELECT a.id, s.nama_beasiswa, a.tanggal_pengajuan, a.status 
                    FROM applications a
                    JOIN scholarship_types s ON a.scholarship_type_id = s.id
                    WHERE a.user_id = ?
                    ORDER BY a.tanggal_pengajuan DESC";
    $stmt_history = $conn->prepare($sql_history);
    $stmt_history->bind_param("i", $user_id);
    $stmt_history->execute();
    $result_history = $stmt_history->get_result();
    while ($row = $result_history->fetch_assoc()) {
        $application_history[] = $row;
    }
    $stmt_history->close();
}

// Ambil pesan notifikasi/error dari session (dari submit_application.php)
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - Sistem Beasiswa</title>
    <link rel="icon" href="crown-user-svgrepo-com.svg" type="image/svg+xml">
    <style>
        /* (SEMUA STYLE CSS TETAP SAMA SEPERTI SEBELUMNYA) */
        :root{
            --accent-1: #667eea;
            --accent-2: #764ba2;
            --muted: #9aa6bf;
            --bg-dark-1: #071033;
            --bg-dark-2: #0f172a;
        }

        *{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%}
        body{
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(102,126,234,0.12), transparent),
                        radial-gradient(1000px 500px at 90% 90%, rgba(118,75,162,0.10), transparent),
                        linear-gradient(135deg,var(--bg-dark-2) 0%, var(--bg-dark-1) 100%);
            background-repeat: no-repeat, no-repeat, no-repeat;   
            background-size: cover;       
            background-attachment: fixed; 
            color: #e6eefc;
            min-height: 100vh;  
        }
        .nav-item{
            margin-bottom:4px;
        }
        .nav-item a {
            display:block;
            padding:12px 16px; 
            color:#eaf2ff; 
            border-radius:8px; 
            margin-bottom:6px; 
            font-weight:600;
            text-decoration: none;
        }
        .side-nav,
        .side-nav:hover,
        .side-nav:active,
        .side-nav:visited,
        .side-nav:focus {
            text-decoration: none !important;
        }


        .bg-shape{position:fixed; width:420px;height:420px;border-radius:36%; filter:blur(60px); opacity:0.12; z-index:0}
        .bg-shape.s1{left:-120px;top:-80px; background:linear-gradient(135deg,var(--accent-1),var(--accent-2))}
        .bg-shape.s2{right:-160px;bottom:-100px; background:linear-gradient(135deg,#00d4ff,#00ffd5)}

        /* Sidebar Styling - glass */
        .sidebar{
            position:fixed; left:0; top:0; bottom:0; width:300px; padding:30px 18px;
            background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
            border-right:1px solid rgba(255,255,255,0.04); color:#ecf4ff; z-index:50; overflow:auto
        }

        .sidebar h3{font-size:1.3rem;margin:0 0 6px 0;color:#fff}
        .sidebar p{color:var(--muted); margin-bottom:18px}

        .sidebar .avatar{width:72px;height:72px;border-radius:50%; display:inline-flex;align-items:center;justify-content:center;font-weight:700;background:linear-gradient(135deg,var(--accent-1),var(--accent-2)); color:white;margin-bottom:10px}

        .sidebar ul{list-style:none;padding:0;margin-top:12px}
        .sidebar ul li a {
            display:block;
            padding:12px 14px;
            color:#eaf2ff;
            border-radius:8px;
            margin-bottom:6px;
            text-decoration:none;
            font-weight:600
        }
        .sidebar ul li a.active {
            background:linear-gradient(90deg,var(--accent-1),var(--accent-2));
            box-shadow:0 6px 18px rgba(102,126,234,0.12);
            text-decoration: none;
        }
        .sidebar ul li a:hover {
            background:rgba(255,255,255,0.03);
            text-decoration: none
        }

        /* Main content area */
        .main-content{margin-left:300px;padding:36px;min-height:100vh;position:relative; z-index:10}

        .page-header {
            margin: 0 0 30px 0;
            padding:0; 
            color:#e6eefc
        }
        .page-header h2{margin:0;font-size:2.8rem}

        .alert{border-radius:10px;padding:12px 16px}
        .alert-info{background:linear-gradient(135deg,#0f2a4a 0%, #07203a 100%); color:#a9d1ff; border-left:4px solid rgba(102,126,234,0.5)}
        .alert-success{background:linear-gradient(135deg,#092417,#073018); color:#bfecc1; border-left:4px solid rgba(50,200,100,0.35)}
        .alert-warning{background:linear-gradient(135deg,#4a3a0f,#3a2a07); color:#ffd9a9; border-left:4px solid rgba(200,150,50,0.35)}
        .alert-danger{background:linear-gradient(135deg,#4a0f0f,#3a0707); color:#ffc9c9; border-left:4px solid rgba(200,50,50,0.35)}

        .card{background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.03); border-radius:12px; box-shadow:0 8px 30px rgba(2,6,23,0.6); margin-bottom:24px}
        .card-header{background:transparent;color:#fff;border-bottom:none;padding:18px}
        .card-body{background:transparent;padding:20px;color:#dfeafe}

        .stat-card{background: #e2eaf3ff; color:#0f172a; padding:20px;border-radius:20px;text-align:center; margin-bottom:20px}
        .stat-card p{margin:0; font-size:1rem; font-weight: 600;}
        .stat-card h3{font-size:1.6rem; margin-top:10px;margin-bottom:0}

        .form-label{color:#cfe1ff; font-weight:600; margin-bottom:8px; display:block}
        .form-control, .form-select{
            background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.04); color:#e6eefc;
            border-radius:10px; padding:10px 14px; width:100%; font-family:inherit; font-size:1rem
        }
        .form-control::placeholder{color:rgba(230,238,252,0.35)}
        .form-control:focus, .form-select:focus{outline:none; border-color:var(--accent-1); box-shadow:0 0 0 3px rgba(102,126,234,0.2)}

        .btn{border:none; border-radius:10px; padding:10px 16px; font-weight:600; cursor:pointer; transition:all 0.2s}
        .btn-primary{background:linear-gradient(90deg,var(--accent-1),var(--accent-2)); color:white;}
        .btn-primary:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(102,126,234,0.3)}
        .btn-secondary{background:#2f3b47;color:#e6eefc}
        .btn-secondary:hover{background:#3a4a54}
        .btn-outline-primary{border:2px solid var(--accent-1); color:var(--accent-1); background:transparent}
        .btn-outline-primary:hover{background:var(--accent-1); color:white}
        .btn-outline-info{border:2px solid #3498db; color:#3498db; background:transparent}
        .btn-outline-info:hover{background:#3498db; color:white}
        .btn-sm{padding:6px 12px; font-size:0.9rem}
        .btn-lg{padding:12px 20px; font-size:1.05rem}

        .status-badge{padding:6px 12px;border-radius:20px;font-weight:600; display:inline-block}
        .status-draft{background:#4a5568; color:#cbd5e0}
        .status-submitted{background:linear-gradient(135deg,#ff9a56,#ff8c3a); color:#2d2d2d}
        .status-in-process{background:linear-gradient(135deg,#4fa3ff,#3d8ae8); color:#fff}
        .status-accepted{background:linear-gradient(135deg,#4caf50,#45a049); color:#fff}
        .status-rejected{background:linear-gradient(135deg,#f44336,#da190b); color:#fff}

        .table{width:100%; border-collapse:collapse}
        .table thead{background:transparent}
        .table thead th{color:#eaf2ff; padding:12px; text-align:left; font-weight:600}
        .table tbody tr{border-bottom:1px solid rgba(255,255,255,0.05)}
        .table tbody td{padding:12px; color:#d9e6ff}
        .table tbody tr:hover{background:rgba(255,255,255,0.02)}

        .divider{height:1px; background:linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent); margin:20px 0}

        .row{display:flex; flex-wrap:wrap; gap:20px; margin-bottom:20px}
        .col-md-4{flex:1; min-width:280px}
        .col-md-6{flex:1; min-width:300px}
        .container-fluid{width:100%}

        .list-group{list-style:none; padding:0}
        .list-group-item{padding:12px; border:1px solid rgba(255,255,255,0.05); border-radius:8px; margin-bottom:8px; color:#dfeafe}
        .list-group-item:hover{background:rgba(255,255,255,0.02)}

        .text-center{text-align:center}
        .text-muted{color:var(--muted)}
        .text-danger{color:#ff6b6b}
        .mb-3{margin-bottom:12px}
        .mb-4{margin-bottom:16px}
        .mt-3{margin-top:12px}
        .mt-4{margin-top:16px}
        .mt-5{margin-top:20px}
        .p-0{padding:0}

        .d-grid{display:grid; gap:12px}
        .d-flex{display:flex}
        .flex-column{flex-direction:column}
        .justify-content-space-between{justify-content:space-between}
        .align-items-center{align-items:center}

        .shadow-sm{box-shadow:0 2px 8px rgba(0,0,0,0.1)}

        /* Responsive */
        @media (max-width: 900px){
            .sidebar{position:relative;width:100%;height:auto; margin-bottom:20px}
            .main-content{margin-left:0;padding:18px}
            .row{flex-direction:column}
            .col-md-4, .col-md-6{flex:1; min-width:auto}
        }

        .active-scholarship-card {
            background: linear-gradient(135deg, #0f172a 0%, #171d3a 100%);
            border: 1px solid rgba(102,126,234,0.1);
            color: #e6eefc;
            padding: 20px;
            border-radius: 12px;
        }

    </style>
</head>
<body>
    <div class="bg-shape s1"></div>
    <div class="bg-shape s2"></div>
    <div class="dashboard-layout">
        
        <div class="sidebar">
            <div style="text-align: center; margin-bottom: 25px; padding: 0 20px;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 28px; color: white;">
                    <?php echo strtoupper(substr($user_data['nama'], 0, 1)); ?>
                </div>
            </div>
            <h3 class="text-white" style="margin-left: 10px;"><?php echo htmlspecialchars($user_data['nama']); ?></h3>
            <p style="margin-left: 10px;">NIM : <?php echo htmlspecialchars($user_data['nim']); ?></p>
            <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 20px 15px;"></div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="side-nav <?php echo ($page == 'dashboard' ? 'active' : ''); ?>" href="?p=dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="side-nav <?php echo ($page == 'new_application' ? 'active' : ''); ?>" href="?p=new_application" style="text-decoration: none;">Pengajuan Baru</a>
                </li>
                <li class="nav-item">
                    <a class="side-nav <?php echo ($page == 'history' || $page == 'detail' ? 'active' : ''); ?>" href="?p=history">Riwayat Pengajuan</a>
                </li>
                <li class="nav-item" style="margin-top: 60px;">
                    <a class="side-nav" href="logout.php" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 8px; text-align: center;">Logout</a>
                </li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="container-fluid">
                
                <?php if ($success_message): ?>
                    <div class="alert alert-success" role="alert">✅ <?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">❌ <?php echo $error_message; ?></div>
                <?php endif; ?>

                <?php if ($page === 'dashboard'): ?>
                    
                    <div class="page-header">
                        <h2>DASHBOARD</h2>
                    </div>
                    
                    <div class="alert alert-info" role="alert">
                        👋 Selamat datang kembali, <strong><?php echo htmlspecialchars($user_data['nama']); ?></strong>! Anda dapat memulai pengajuan beasiswa baru atau melihat status pengajuan Anda saat ini.
                    </div>
                    <br>
                    
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h3 style="margin:0">STATUS BEASISWA AKTIF</h3>
                        </div>
                        <div class="card-body">
                            <?php if ($is_active_scholarship): ?>
                                <div class="active-scholarship-card">
                                    <p style="margin-bottom: 8px;">Beasiswa Aktif :</p>
                                    <h3 style="color: #667eea; font-size: 1.5rem; margin-top: 0; margin-bottom: 40px"><?php echo htmlspecialchars($active_scholarship_info['nama_beasiswa']); ?></h3>
                                    <hr style="border-top: 1px solid rgba(255,255,255,0.1); margin: 0 0 35px 0;">
                                    <div class="row" style="gap: 10px;">
                                        <div class="col-md-6" style="flex: 1; min-width: 45%;">
                                            <p class="text-muted small mb-1">Tanggal Mulai :</p><br>
                                            <p style="font-weight: 600;"><?php echo date('d M Y', strtotime($active_scholarship_info['active_start_date'])); ?></p>
                                        </div>
                                        <div class="col-md-6" style="flex: 1; min-width: 45%;">
                                            <p class="text-muted small mb-1">Tanggal Berakhir :</p><br>
                                            <p style="font-weight: 600; color: #FF9A56;"><?php echo date('d M Y', strtotime($active_scholarship_info['active_end_date'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center" style="margin-bottom: 30px">
                                    <p class="mb-0">Anda saat ini tidak memiliki beasiswa aktif yang tercatat. Silakan ajukan beasiswa baru.</p>
                                </div>
                                
                                <div style="text-align: center; padding-bottom: 20px;">
                                    <a  href="?p=new_application" class="btn btn-primary btn-lg" style="text-decoration: none;">Mulai Pengajuan</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <p>NIM</p>
                                <h3><?php echo htmlspecialchars($user_data['nim']); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <p>IPK Tercatat</p>
                                <h3><?php echo htmlspecialchars($user_data['ipk'] ?? '–'); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <p>Semester Tercatat</p>
                                <h3><?php echo htmlspecialchars($user_data['semester'] ?? '–'); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 style="margin:0">Informasi Akun Lengkap</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="margin-bottom: 15px;"><strong>Nama Lengkap :</strong> <br><br><span style="color: #667eea; font-weight: 600;"><?php echo htmlspecialchars($user_data['nama']); ?></span></p>
                                    <p><strong>NIM :</strong><br><br><span style="color: #667eea; font-weight: 600;"><?php echo htmlspecialchars($user_data['nim']); ?></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p style="margin-bottom: 15px;"><strong>IPK Saat Ini :</strong> <br><br><span style="color: #667eea; font-weight: 600;"><?php echo htmlspecialchars($user_data['ipk'] ?? 'Belum tersedia'); ?></span></p>
                                    <p><strong>Semester :</strong> <br><br><span style="color: #667eea; font-weight: 600;"><?php echo htmlspecialchars($user_data['semester'] ?? 'Belum tersedia'); ?></span></p>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div style="text-align: center; padding: 20px;">
                                <a href="?p=new_application" class="btn btn-primary btn-lg" style="text-decoration: none;">Mulai Pengajuan </a>
                            </div>
                        </div>
                    </div>
                    
                <?php elseif ($page === 'new_application'): ?>
                    
                    <div class="page-header">
                        <h2>Form Pengajuan Beasiswa Baru</h2>
                    </div>
                    
                    <?php if ($is_active_scholarship): ?>
                        <div class="alert alert-danger text-center p-4" role="alert">
                            <h4 class="alert-heading" style="margin: 10px auto 20px auto">🚫 Pengajuan Ditolak Sementara!</h4>
                            <p>Anda saat ini sedang terdaftar sebagai penerima <?php echo htmlspecialchars($active_scholarship_info['nama_beasiswa']); ?>.
                            <hr style="margin: 15px;">
                            <p class="mb-0" style="margin-bottom: 20px;">Periode beasiswa ini aktif hingga <?php echo date('d M Y', strtotime($active_scholarship_info['active_end_date'])); ?>. Anda tidak dapat mengajukan beasiswa baru sebelum periode ini berakhir.</p>
                        </div>
                    <?php else: ?>
                    <div id="eligibility-checker-result" class="alert alert-info">
                            Cek Kelayakan Awal: Silakan pilih Jenis Beasiswa dan isi IPK Anda untuk mendapatkan hasil kelayakan instan.
                        </div><br>
                        
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h3 style="margin:0">Informasi Beasiswa & Akademik</h3>
                            </div>
                            <div class="card-body">
                                <form action="submit_application.php" method="POST" enctype="multipart/form-data">
                                    
                                    <div class="mb-4">
                                        <label for="scholarship_type_id" class="form-label">Jenis Beasiswa</label>
                                        <select name="scholarship_type_id" id="scholarship_type_id" class="form-select" required>
                                            <option value="">-- Pilih Jenis Beasiswa --</option>
                                            <?php while($row = $scholarships->fetch_assoc()): ?>
                                                <option value="<?php echo $row['id']; ?>" style="color: black;"><?php echo htmlspecialchars($row['nama_beasiswa']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="ipk" class="form-label">IPK Saat Ini</label>
                                            <input type="text" class="form-control" id="ipk" name="ipk" placeholder="Contoh: 3.85" value="<?php echo htmlspecialchars($user_data['ipk'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="semester" class="form-label">Semester Saat Ini</label>
                                            <input type="number" class="form-control" id="semester" name="semester" value="<?php echo htmlspecialchars($user_data['semester'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="divider"></div>
                                    
                                    <h4 class="mb-3 mt-4" style="color: #a9d1ff; font-weight: 700;">📄 Upload Dokumen Persyaratan</h4>
                                    <p class="text-muted small">! Pastikan file dalam format PDF/JPG dan ukuran maksimal 2MB per file.</p><br><br>

                                    <div class="mb-4">
                                        <label for="dokumen_ktm" class="form-label">Upload Kartu Tanda Mahasiswa (KTM) / Identitas Diri</label>
                                        <input type="file" class="form-control" id="dokumen_ktm" name="dokumen_ktm" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>
                                    </div><br><br>
                                    <div class="mb-4">
                                        <label for="dokumen_khs" class="form-label">Upload KHS / Transkrip Nilai</label>
                                        <input type="file" class="form-control" id="dokumen_khs" name="dokumen_khs" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG | Max: 2MB</small>
                                    </div><br>

                                    <hr>
                                    <div id="dynamic-documents-area">
                                        <div class="alert alert-warning">Pilih Jenis Beasiswa untuk melihat persyaratan dokumen spesifik.</div>
                                    </div>
                                    <br><br>
                                    <div class="d-grid mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px; font-size: 1.1em;">Submit Pengajuan</button>
                                        <a href="?p=dashboard" class="btn btn-secondary" style="padding: 12px; margin-top:10px; max-width: 210px; text-align: center; text-decoration: none;">Kembali ke Dashboard</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php elseif ($page === 'history'): ?>
                    
                    <div class="page-header">
                        <h2>Riwayat Pengajuan Beasiswa</h2>
                    </div>
                    
                    <?php if (empty($application_history)): ?>
                        <div class="alert alert-warning text-center" role="alert">
                            <p style="font-size: 1.1em; margin-bottom: 15px;">📭 Anda belum memiliki riwayat pengajuan beasiswa.</p>
                            <a href="?p=new_application" class="btn btn-primary btn-lg mt-3">🚀 Ajukan Beasiswa Baru</a>
                        </div>
                    <?php else: ?>
                        <div class="card shadow-sm">
                            <div style="overflow-x:auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 35%;">Jenis Beasiswa</th>
                                            <th style="width: 25%;">Tanggal Pengajuan</th>
                                            <th style="width: 20%;">Status</th>
                                            <th style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                        <?php foreach ($application_history as $app): ?>
                                        <tr>
                                            <td><strong><?php echo $counter++; ?></strong></td>
                                            <td><?php echo htmlspecialchars($app['nama_beasiswa']); ?></td>
                                            <td><?php echo date('d M Y', strtotime($app['tanggal_pengajuan'])); ?></td>
                                            <td><?php echo display_status_badge($app['status']); ?></td>
                                            <td>
                                                <a href="?p=detail&id=<?php echo $app['id']; ?>" class="btn btn-sm btn-outline-info">Lihat Detail</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php elseif ($page === 'detail'): ?>
                    <?php 
                    // Logika detail pengajuan
                    $app_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                    $detail_data = null;
                    $applicant_docs = [];
                    
                    if ($app_id) {
                        $sql_detail = "SELECT a.*, s.nama_beasiswa, u.ipk, u.semester
                                       FROM applications a
                                       JOIN scholarship_types s ON a.scholarship_type_id = s.id
                                       JOIN users u ON a.user_id = u.id
                                       WHERE a.id = ? AND a.user_id = ?";
                        $stmt_detail = $conn->prepare($sql_detail);
                        $stmt_detail->bind_param("ii", $app_id, $user_id);
                        $stmt_detail->execute();
                        $detail_data = $stmt_detail->get_result()->fetch_assoc();
                        $stmt_detail->close();
                        
                        if ($detail_data) {
                           $sql_docs = "SELECT nama_dokumen, file_path FROM application_documents WHERE application_id = ?";
                           $stmt_docs = $conn->prepare($sql_docs);
                           $stmt_docs->bind_param("i", $app_id);
                           $stmt_docs->execute();
                           $result_docs = $stmt_docs->get_result();
                           while($doc = $result_docs->fetch_assoc()) {
                               $applicant_docs[] = $doc;
                           }
                           $stmt_docs->close();
                        }
                    }
                    ?>
                    
                    <?php if ($detail_data): ?>
                        <div class="page-header">
                            <h2>Detail Pengajuan <?php echo htmlspecialchars($detail_data['id']); ?></h2>
                        </div>
                        
                        <a href="?p=history" class="btn btn-secondary mb-4" style="text-decoration: none;" >Kembali ke Riwayat</a>
                        <br><br>
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h2>Pengajuan : <?php echo htmlspecialchars($detail_data['nama_beasiswa']); ?></h2>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
                                            <p style="margin-bottom: 10px;"><strong style="color:#e6eefc;">Tanggal Pengajuan : </strong></p>
                                            <p style="color: #667eea; font-weight: 600; font-size: 1.05em;"><?php echo date('d M Y H:i', strtotime($detail_data['tanggal_pengajuan'])); ?></p>
                                        </div>
                                        <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                                            <p style="margin-bottom: 10px;"><strong style="color:#e6eefc;">IPK/Semester : </strong></p>
                                            <p style="color: #667eea; font-weight: 600; font-size: 1.05em;"><?php echo htmlspecialchars($detail_data['ipk']); ?> / Semester <?php echo htmlspecialchars($detail_data['semester']); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
                                            <p style="margin-bottom: 10px;"><strong style="color:#e6eefc;">Status Saat Ini : </strong></p>
                                            <p><?php echo display_status_badge($detail_data['status']); ?></p>
                                        </div>
                                        <div style="background: rgba(255,255,255,0.02); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                                            <p style="margin-bottom: 10px;"><strong style="color:#e6eefc;">Catatan Admin : </strong></p>
                                            <div style="border-left: 4px solid #667eea; padding-left: 15px; color: #dfeafe;">
                                                <?php echo htmlspecialchars($detail_data['catatan'] ?? 'Belum ada catatan dari administrator.'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if ($detail_data['status'] === 'accepted'): ?>
                                    <div class="alert alert-success mt-4">
                                        <h5 class="alert-heading">🎉 Periode Aktif Beasiswa</h5>
                                        <p class="mb-0">Beasiswa aktif dari **<?php echo date('d M Y', strtotime($detail_data['active_start_date'])); ?>** hingga **<?php echo date('d M Y', strtotime($detail_data['active_end_date'])); ?>**.</p>
                                    </div>
                                <?php endif; ?>

                                <h4 class="mt-5 mb-3" style="color: #a9d1ff; font-weight: 700;">📂 Dokumen yang Diunggah</h4>
                                <?php if (empty($applicant_docs)): ?>
                                    <div class="alert alert-warning">Tidak ada dokumen yang ditemukan untuk pengajuan ini.</div>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($applicant_docs as $doc): ?>
                                        <div class="col-md-4">
                                            <div class="card shadow-sm mb-3" style="padding: 15px;">
                                                <p class="mb-2" style="font-weight: 600; color: #fff;"><?php echo htmlspecialchars($doc['nama_dokumen']); ?></p><br>
                                                <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" class="btn btn-outline-primary btn-sm" style="text-decoration: none;">Lihat File</a>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-danger text-center" role="alert">
                            ❌ Pengajuan tidak ditemukan atau Anda tidak memiliki akses ke pengajuan ini.
                        </div>
                    <?php endif; ?>
                <?php endif; // End of page content logic ?>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                try {
                    const selectScholarship = document.getElementById('scholarship_type_id');
                    const dynamicArea = document.getElementById('dynamic-documents-area');
                    const ipkInput = document.getElementById('ipk');
                    const semesterInput = document.getElementById('semester');
                    const eligibilityResult = document.getElementById('eligibility-checker-result');

                    // Jika elemen tidak ada di halaman (mis. bukan halaman new_application), hentikan lebih awal
                    if (!selectScholarship || !dynamicArea || !ipkInput || !semesterInput || !eligibilityResult) {
                        return;
                    }

                    // --- FUNGSI UTAMA CEK KELAYAKAN & LOAD DOKUMEN (Menggunakan AJAX) ---
                    function checkAndLoad() {
                        try {
                            const scholarshipId = selectScholarship.value;
                            const ipk = ipkInput.value;
                            const semester = semesterInput.value;

                            if (!scholarshipId) {
                                dynamicArea.innerHTML = '<div class="alert alert-warning">Pilih Jenis Beasiswa untuk melihat persyaratan dokumen spesifik.</div>';
                                eligibilityResult.className = 'alert alert-info';
                                eligibilityResult.innerHTML = 'Cek Kelayakan Awal: Silakan pilih Jenis Beasiswa dan isi IPK Anda untuk mendapatkan hasil kelayakan instan.';
                                return;
                            }

                            // Loading state
                            dynamicArea.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> Memuat Persyaratan...</div>';
                            eligibilityResult.className = 'alert alert-info';
                            eligibilityResult.innerHTML = 'Sedang memproses kelayakan...';

                            fetch('fetch_requirements.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: new URLSearchParams({
                                    'id': scholarshipId,
                                    'ipk': ipk,
                                    'semester': semester
                                })
                            })
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.json();
                            })
                            .then(data => {
                                // Update hasil dan dokumen
                                if (data && data.eligibility) {
                                    eligibilityResult.className = data.eligibility.class || 'alert alert-info';
                                    eligibilityResult.innerHTML = data.eligibility.message || '';
                                }
                                dynamicArea.innerHTML = data.documents_html || '';

                                const submitBtn = document.querySelector('button[type="submit"]');
                                if (submitBtn) submitBtn.disabled = (data.eligibility && data.eligibility.is_eligible === false);
                            })
                            .catch(error => {
                                console.error('Error fetching requirements:', error);
                                dynamicArea.innerHTML = '<div class="alert alert-danger">Gagal memuat persyaratan dokumen: Kesalahan Koneksi.</div>';
                                eligibilityResult.className = 'alert alert-danger';
                                eligibilityResult.innerHTML = 'Gagal melakukan cek kelayakan.';
                                const submitBtn = document.querySelector('button[type="submit"]');
                                if (submitBtn) submitBtn.disabled = true;
                            });
                        } catch (err) {
                            console.error('checkAndLoad error:', err);
                        }
                    }

                    // Pasang event listeners secara aman
                    selectScholarship.addEventListener('change', checkAndLoad);
                    ipkInput.addEventListener('change', checkAndLoad);
                    semesterInput.addEventListener('change', checkAndLoad);
                    ipkInput.addEventListener('keyup', checkAndLoad);

                    // Trigger awal bila ada nilai
                    if (selectScholarship.value || ipkInput.value) {
                        checkAndLoad();
                    }
                } catch (err) {
                    console.error('Dashboard student JS initialization error:', err);
                }
            });
    </script>
</body>
</html>