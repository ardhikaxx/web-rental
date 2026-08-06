<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ $site['company_name'] ?? 'RC Trans' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>body{min-height:100vh;display:grid;place-items:center;background:linear-gradient(135deg,#0b1224,#1750ae).auth-card{max-width:420px;width:100%}.form-control{border-radius:12px}</style>
</head>
<body>
    <div class="container">
        <div class="auth-card mx-auto">
            @include('components.flash')
            <div class="card shadow rounded-4 p-4">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-car-side fs-1 text-brand"></i>
                    <h4 class="fw-bold mt-2">{{ $site['company_name'] ?? 'RC Trans' }}</h4>
                    <p class="text-muted small mb-0">Masuk untuk mengelola akun atau dashboard</p>
                </div>
                <form method="post" action="{{ route('login.attempt') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="pw" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('pw').type=document.getElementById('pw').type=='password'?'text':'password'"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <button class="btn btn-brand w-100"><i class="fa-solid fa-right-to-bracket me-2"></i>Masuk</button>
                </form>
                <hr>
                <p class="text-center mb-0 small">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
            </div>
        </div>
    </div>
</body>
</html>