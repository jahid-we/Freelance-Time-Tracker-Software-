<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow p-4" style="min-width: 350px; max-width: 400px; width: 100%;">
        <h4 class="mb-3 text-center">Set New Password</h4>

        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <form action="{{ route('auth.newPassword') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required placeholder="New Password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation"
                       name="password_confirmation" required placeholder="Confirm Password">
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
