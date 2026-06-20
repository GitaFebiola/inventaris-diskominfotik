<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Diskominfotik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #f0f2f5;
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
            border-top: 5px solid #17294b;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header i {
            color: #17294b;
        }

        .login-header h4 {
            font-weight: 700;
            color: #17294b;
        }

        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: 600;
            background-color: #17294b;
            border: none;
        }

        .btn-login:hover {
            background-color: #223a66;
        }

        .input-group-text {
            background-color: #17294b;
            color: #fff;
            border: 1px solid #17294b;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="login-header">
        <i class="fas fa-boxes fa-3x mb-3"></i>
        <h4>SIM INVENTARIS</h4>
        <p>Dinas Komunikasi, Informatika dan Statistik Kabupaten Bengkalis</p>
    </div>

    {{-- ALERT ERROR LOGIN --}}
    @if ($errors->any())
        <div class="alert alert-danger py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ url('/login-proses') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text"
                       name="username"
                       class="form-control"
                       value="{{ old('username') }}"
                       placeholder="Masukkan username"
                       required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password"
                       required>
            </div>
        </div>

        <button type="submit" class="btn btn-login text-white">
            MASUK <i class="fas fa-sign-in-alt ms-1"></i>
        </button>
    </form>

    <div class="text-center mt-3">
        <small class="text-muted">&copy; 2026 Diskominfotik</small>
    </div>

</div>

</body>
</html>