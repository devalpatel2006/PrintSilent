<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; }
        .card { max-width: 420px; margin: 80px auto; background: #fff; border: 1px solid #ddd; padding: 24px; border-radius: 8px; }
        .field { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #c9c9c9; border-radius: 6px; }
        .error { color: #b42318; margin-bottom: 12px; font-size: 14px; }
        button { width: 100%; background: #111827; color: #fff; border: none; padding: 10px; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
<div class="card">
    <h2>Admin Panel Login</h2>
    <p>Use your admin account to manage cloud print resources.</p>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div class="field">
            <label>
                <input type="checkbox" name="remember" value="1"> Remember me
            </label>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
