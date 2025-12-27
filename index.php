<?php
// FILE: index.php (FINAL & FIX)

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
    // Fallback for older PHP: set most important flags
    session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], ini_get('session.cookie_domain'), $cookieParams['secure'], $cookieParams['httponly']);
}
session_start();
include 'db_connect.php'; 

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_student.php");
    }
    exit;
}

// INISIALISASI PESAN KOSONG
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($email) || empty($password)) {
        $error_message = "Email dan password harus diisi.";
    } else {
        $stmt = $conn->prepare("SELECT id, password, role, nama FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Login Berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama'] = $user['nama'];

                if ($user['role'] === 'admin') {
                    header("Location: dashboard_admin.php");
                } else {
                    header("Location: dashboard_student.php");
                }
                exit;
            } else {
                $error_message = "Password salah.";
            }
        } else {
            $error_message = "Email tidak ditemukan atau tidak terdaftar.";
        }
        $stmt->close();
    }
}

// Logika Registrasi... (Jika ada POST register, akan di-handle di register.php)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $error_message = "Silakan gunakan halaman <a href='register.php' class='alert-link'>Registrasi</a> untuk mendaftar.";
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Beasiswa</title>
    <link rel="icon" href="crown-user-svgrepo-com.svg" type="image/svg+xml">
    <style>
        :root{
            --accent-1: #667eea;
            --accent-2: #764ba2;
            --muted: #6c7a89;
            --glass-bg: rgba(255,255,255,0.08);
        }

        html,body{
            height:100%; 
            margin:0;
            overflow-x:hidden;
        }
        body{
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(102,126,234,0.18), transparent),
                        radial-gradient(1000px 500px at 90% 90%, rgba(118,75,162,0.14), transparent),
                        linear-gradient(135deg, #0f172a 0%, #071033 100%);
            background-attachment: fixed;
            display:flex;
            align-items:center;
            justify-content:center;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            padding:20px;
        }

        /* Decorative shapes */
        .bg-shape{
            position: absolute;
            width: 480px;
            height: 480px;
            border-radius: 40%;
            filter: blur(60px);
            opacity: 0.14;
            z-index: 0;
        }

        .bg-shape.s1{background: linear-gradient(135deg, var(--accent-1), var(--accent-2)); left:-120px; top:-80px;}
        .bg-shape.s2{background: linear-gradient(135deg, #00d4ff, #00ffd5); right:-160px; bottom:-100px;}

        .login-wrapper{
            position:relative;
            z-index: 2;
            width:100%;
            max-width:980px;
            display:flex;
            gap:28px;
            align-items:stretch;
            max-height:90vh;
            overflow-y:auto;
        }

        .login-card{
            flex:1 1 420px;
            border-radius:14px;
            background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
            border: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 10px 40px rgba(2,6,23,0.6);
            backdrop-filter: blur(8px);
            overflow:hidden;
        }

        .login-illustration{
            flex:0 0 auto;
            min-width:280px;
            max-width:380px;
            border-radius:14px;
            padding:36px;
            color:#fff;
            background: linear-gradient(180deg, rgba(102,126,234,0.16), rgba(118,75,162,0.12));
            display:flex;
            flex-direction:column;
            justify-content:center;
            gap:18px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
        }

        .login-illustration h1{font-size:24px; margin:0; font-weight:700;}
        .login-illustration p{color:rgba(255,255,255,0.9); margin:0; opacity:0.95}

        .brand-badge{
            display:inline-block; padding:8px 12px; border-radius:999px; color:#fff; font-weight:700; font-size: 40px;
        }

        .card-body-custom{padding:34px;}

        .form-title{font-size:20px; font-weight:700; color:#e6eefc; margin-bottom:6px}
        .form-sub{color:var(--muted); margin-bottom:18px}

        .form-control{
            border-radius:10px; border:1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.02); color:#e7eefc;
            padding:12px 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control::placeholder{color:rgba(231,238,252,0.45)}

        .form-label{color:rgba(231,238,252,0.9); font-weight:600}

        .btn-primary{
            background: linear-gradient(90deg,var(--accent-1),var(--accent-2));
            border:none; padding:12px 18px; border-radius:10px; font-weight:700;
            box-shadow: 0 8px 24px rgba(102,126,234,0.18);
        }

        .btn-primary:active{transform:translateY(1px)}

        .helper-row{display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:6px}

        .small-link{color:rgba(231,238,252,0.8); font-weight:600}

        .actions{margin-top:18px; display:flex; gap:12px; justify-content:flex-end; align-items:center; flex-wrap:wrap}
        .btn-outline{border-radius:10px; padding:10px 14px; font-weight:600; cursor:pointer; color:rgba(231,238,252,0.95); text-decoration:none; border:1px solid rgba(255,255,255,0.03); background:transparent}
        .actions .btn{margin:0}

        .alert-custom{border-radius:10px; padding:10px 14px; background:rgba(255,80,80,0.06); border:1px solid rgba(255,80,80,0.12); color:#ffdada}

        .mb-3{margin-bottom:12px}
        .text-muted{color:var(--muted)}

        @media (max-width:900px){
            /* Mobile adjustments: avoid vertical clipping by aligning to top and allowing flow */
            body{align-items:flex-start; padding:12px 12px 28px;}
            .bg-shape{display:none}
            .login-wrapper{flex-direction:column; max-width:560px; max-height:none; margin-top:18px; margin-bottom:18px; overflow-y:visible}
            .login-illustration{min-width:auto; max-width:100%; padding:18px}
            .form-title{font-size:18px}
            .form-sub{font-size:13px}
            .actions{justify-content:space-between; flex-direction:column-reverse; align-items:stretch}
            .actions .btn, .actions .btn-outline{width:100%; text-align:center}
        }
    </style>
</head>
<body>
    <div class="bg-shape s1"></div>
    <div class="bg-shape s2"></div>

    <div class="login-wrapper">
        <div class="login-illustration">
            <div style="display:flex; align-items:center; justify-content: center;">
                <div>
                    <div class="brand-badge">Sistem Pengajuan Beasiswa</div>
                </div>
            </div><br><br>
            <h1>Selamat Datang</h1>
            <p>Masuk untuk mengelola pengajuan beasiswa Anda. Pastikan data yang Anda masukkan sesuai dengan identitas.</p>
            <div style="margin-top:12px; font-size:13px; opacity:0.9">Butuh bantuan? Hubungi admin kampus atau lihat panduan pengajuan.</div>
        </div>

        <div class="login-card">
            <div class="card-body-custom">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px">
                    <div>
                        <div class="form-title">Masuk ke Akun Anda</div>
                        <div class="form-sub">Masukkan email dan kata sandi Anda</div>
                    </div>
                    <div style="text-align:right;">
                        <small class="text-muted">Akses aman</small>
                    </div>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="alert-custom" role="alert"><?php echo $error_message; ?></div><br>
                <?php endif; ?>

                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label><br><br>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@xxx.xxx" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label><br><br>
                        <div style="position:relative; display:flex; align-items:center;">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" required>
                            <button type="button" id="togglePassword" style="position:absolute; right:12px; background:none; border:none; cursor:pointer; color:rgba(231,238,252,0.6); font-size:18px; padding:4px;">👁️</button>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:12px">
                        <div style="display:flex; align-items:center; gap:8px">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" class="small-link">Ingat saya</label>
                        </div>
                        <div>
                            <a href="#" class="small-link" style="text-decoration: none;">Lupa kata sandi?</a>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="register.php" class="btn-outline">Daftar</a>
                        <button type="submit" name="login" class="btn btn-primary">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleBtn = this;
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        });
    </script>
</body>
</html>