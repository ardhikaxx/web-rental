<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - {{ $site['company_name'] ?? 'RC Trans' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>body{min-height:100vh;display:grid;place-items:center;background:linear-gradient(135deg,#0b1224,#436cae)}.auth-card{max-width:440px;width:100%}.form-control{border-radius:12px}</style>
</head>
<body>
    <div class="container">
        <div class="auth-card mx-auto">
            @include('components.flash')
            <div class="card shadow rounded-4 p-4">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-user-plus fs-1 text-brand"></i>
                    <h4 class="fw-bold mt-2">Buat Akun</h4>
                    <p class="text-muted small mb-0">Daftar untuk memesan & melacak booking dengan mudah</p>
                </div>
                <form method="post" action="{{ route('register.store') }}">
                    @csrf
                    <div class="mb-3"><label class="form-label small">Nama Lengkap</label><input type="text" name="name" value="{{ old('name') }}" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label small">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label small">No. HP / WhatsApp</label><input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label small">Password</label><input type="password" name="password" class="form-control" minlength="6" required></div>
                    <div class="mb-3"><label class="form-label small">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
                    <button class="btn btn-brand w-100"><i class="fa-solid fa-user-check me-2"></i>Daftar</button>
                </form>
                <hr>
                <p class="text-center mb-0 small">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
            </div>
        </div>
    </div>
</body>
</html>