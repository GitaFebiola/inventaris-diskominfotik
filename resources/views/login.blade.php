<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Diskominfotik</title>
    <!-- Menggunakan Bootstrap 5 agar tampilan rapi tanpa coding CSS manual -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f0f2f5; /* Warna background abu-abu muda agar nyaman di mata */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background-color: white;
            border-top: 5px solid #0d6efd; /* Aksen biru di atas (Logo Color) */
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            width: 80px;
            margin-bottom: 1rem;
        }
        .login-header h4 {
            font-weight: 700;
            color: #333;
        }
        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <!-- Ganti src dengan URL Logo Diskominfotik atau Logo Pemda Anda -->
            <!-- Jika belum ada logo, pakai icon saja -->
            <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
            <h4>SIM INVENTARIS</h4>
            <p>Dinas Komunikasi, Informatika dan Statistik Kabupaten Bengkalis</p>
        </div>

        <form action="/login-proses" method="POST">
            <!-- Token CSRF (Wajib jika pakai Laravel) -->
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-login">
                MASUK <i class="fas fa-sign-in-alt ms-1"></i>
            </button>
        </form>
        
        <div class="text-center mt-3">
            <small class="text-muted">&copy; 2026 Diskominfotik. All rights reserved.</small>
        </div>
    </div>

</body>
</html>