<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow border-0" style="width: 400px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo-telu.png') }}" alt="Logo" width="80" class="mb-3">
                <h4 class="fw-bold">Login Sistem</h4>
                <small class="text-muted">Logistik Telkom University</small>
            </div>

            @if($errors->any())
                <div class="alert alert-danger text-center p-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="username@student.telkomuniversity.ac.id" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="******" required>
                </div>
                <button type="submit" class="btn btn-danger w-100 py-2">Masuk</button>
            </form>
        </div>
    </div>

</body>
</html>