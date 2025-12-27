<?php
// FILE: register.php

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

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard_student.php"); // Asumsi redirect ke mahasiswa
    exit;
}

error_reporting(E_ALL);
$error_message = '';
$success_message = '';
$nama = $nim = $email = $phone_number = ''; // Inisialisasi variabel untuk persistence form

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama'] ?? '');
    $nim = trim($_POST['nim'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone_number = trim($_POST['phone_number'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validasi input
    if (empty($nama) || empty($nim) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number)) {
        $error_message = "Semua kolom wajib diisi.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Konfirmasi password tidak cocok.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format email tidak valid.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password minimal 6 karakter.";
    } elseif (!preg_match('/^\+?\d{6,15}$/', $phone_number)) {
        $error_message = "Nomor WhatsApp tidak valid (masukkan 6-15 digit, boleh dengan +).";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Cek apakah NIM atau Email sudah terdaftar
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE nim = ? OR email = ?");
        $stmt_check->bind_param("ss", $nim, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error_message = "NIM atau Email sudah terdaftar. Silakan login.";
        } else {
            // Insert user baru sebagai 'student'
            // Perhatikan kolom IPK dan Semester di set NULL di awal
            $stmt_insert = $conn->prepare("INSERT INTO users (nama, nim, email, password, role, phone_number) VALUES (?, ?, ?, ?, 'student', ?)");
            $stmt_insert->bind_param("sssss", $nama, $nim, $email, $hashed_password, $phone_number);
            
            if ($stmt_insert->execute()) {
                $success_message = "Registrasi berhasil! Silakan <a href='index.php'>Login</a>.";
                // Clear input fields after successful registration
                $nama = $nim = $email = $phone_number = '';
            } else {
                $error_message = "Registrasi gagal: " . $conn->error;
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun Mahasiswa</title>
    <link rel="icon" href="crown-user-svgrepo-com.svg" type="image/svg+xml">
    <style>
        :root{
            --accent-1: #667eea;
            --accent-2: #764ba2;
            --muted: #93a2b3ff;
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
            min-height:100vh;
            color: #e6eefc;
            display:flex; align-items:center; justify-content:center;
            padding:32px;
            padding-top:calc(32px + env(safe-area-inset-top));
            padding-bottom:calc(32px + env(safe-area-inset-bottom));
        }

        .bg-shape{position:fixed; width:420px;height:420px;border-radius:36%; filter:blur(60px); opacity:0.12; z-index:0}
        .bg-shape.s1{left:-120px;top:-80px; background:linear-gradient(135deg,var(--accent-1),var(--accent-2))}
        .bg-shape.s2{right:-160px;bottom:-100px; background:linear-gradient(135deg,#00d4ff,#00ffd5)}

        .register-wrapper{position:relative; z-index:2; width:100%; max-width:920px; display:flex; gap:28px; align-items:stretch}
        .register-illustration{flex:0 0 360px; padding:36px; border-radius:12px; background:linear-gradient(180deg, rgba(102,126,234,0.16), rgba(118,75,162,0.12)); color:#fff}
        .illustration-title{margin-top:18px; margin-bottom:8px;}
        .illustration-text{text-align:justify}
        .register-card{flex:1; border-radius:12px; background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.03); box-shadow:0 10px 40px rgba(2,6,23,0.6); padding:28px}

        .brand-badge{display:inline-block; padding:8px 12px; border-radius:999px; background:rgba(255,255,255,0.06); color:#fff; font-weight:700}
        h3.card-title{color:#e6f0ff; margin-bottom:10px}
        .form-label{display:block; margin-bottom:8px; color:#cfe1ff; font-weight:600}
        .form-control{width:100%; padding:10px 12px; border-radius:10px; border:1px solid rgba(255,255,255,0.04); background:rgba(255,255,255,0.02); color:#e6eefc}
        .form-control::placeholder{color:rgba(230,238,252,0.35)}

        .row{display:flex; gap:16px; flex-wrap:wrap}
        .col-md-6{flex:1; min-width:220px}

        .btn{display:inline-flex; align-items:center; justify-content:center; padding:12px 18px; border-radius:10px; cursor:pointer; border:none}
        .btn-success{background:linear-gradient(90deg,var(--accent-1),var(--accent-2)); color:white; font-weight:700}

        .alert{padding:12px 14px; border-radius:10px}
        .alert-success{background:linear-gradient(135deg,#092417,#073018); color:#bfecc1}
        .alert-danger{background:linear-gradient(135deg,#4a0f0f,#3a0707); color:#ffc9c9}

        .text-center{text-align:center}
        .text-muted{color:var(--muted)}
        .mb-3{margin-bottom:12px}
        .mt-3{margin-top:12px}

        @media (max-width:900px){
            body{align-items:flex-start}
            .register-wrapper{flex-direction:column; align-items:flex-start}
            .bg-shape{display:none}
        }
    </style>
</head>
<body>
    <div class="bg-shape s1"></div>
    <div class="bg-shape s2"></div>

    <main class="register-wrapper">
        <aside class="register-illustration">
            <h2 class="illustration-title">Daftarkan Diri Anda</h2>
            <p class="text-muted illustration-text">Raih kesempatan mendapatkan program beasiswa dan raih impian anda. Isi form di samping untuk mendaftar. Pastikan data yang diisi valid !!</p>
        </aside>

        <section class="register-card">
            <h3 class="card-title">Registrasi Akun Mahasiswa</h3>
            <p class="text-muted">Isi data diri Anda untuk membuat akun.</p><br>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success mb-3"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mb-3"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <input type="hidden" name="role" value="student">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" required value="<?php echo htmlspecialchars($nama); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                        <input type="text" class="form-control" id="nim" name="nim" required value="<?php echo htmlspecialchars($nim); ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Nomor WhatsApp (Ex: 62812...)</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required value="<?php echo htmlspecialchars($phone_number); ?>">
                    </div>
                </div>

                <hr style="border-color:rgba(255,255,255,0.03); margin:18px 0">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <div style="display:flex; gap:12px; align-items:center; margin-top:16px;">
                    <button type="submit" class="btn btn-success" style="flex:1;">Daftar Akun</button>
                </div>
            </form>

            <p class="text-center mt-3 text-muted" style="margin-top:18px;">Sudah punya akun? <a href="index.php" style="text-decoration: none; font-weight: bold;">Login di sini</a></p>
        </section>
    </main>
</body>
</html>