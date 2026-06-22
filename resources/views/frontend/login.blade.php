<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In — Print Silently</title>
  <meta name="description" content="Sign in to your Print Silently account." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bg: #05070e;
      --surface: rgba(12, 17, 32, 0.92);
      --surface-hover: rgba(20, 28, 52, 0.95);
      --border: rgba(255, 255, 255, 0.08);
      --border-focus: rgba(124, 92, 255, 0.5);
      --text: #edf2ff;
      --text-muted: rgba(237, 242, 255, 0.6);
      --accent: #7c5cff;
      --accent-2: #00d3ff;
      --error: #f87171;
      --success: #34d399;
      font-family: "Inter", system-ui, sans-serif;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background:
        radial-gradient(circle at 20% 20%, rgba(124, 92, 255, 0.15), transparent 40%),
        radial-gradient(circle at 80% 80%, rgba(0, 211, 255, 0.1), transparent 40%),
        var(--bg);
      color: var(--text);
      padding: 24px;
    }

    .auth-container {
      width: 100%;
      max-width: 460px;
    }

    .auth-brand {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 36px;
    }

    .auth-brand img {
      height: 52px;
      border-radius: 12px;
    }

    .auth-brand-name {
      font-size: 1.3rem;
      font-weight: 800;
      letter-spacing: -0.02em;
    }

    .auth-brand-tag {
      font-size: 0.85rem;
      color: var(--text-muted);
    }

    .auth-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 40px 36px;
      backdrop-filter: blur(24px);
      box-shadow:
        0 32px 80px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    .auth-card h1 {
      font-size: 1.6rem;
      font-weight: 800;
      margin-bottom: 8px;
      letter-spacing: -0.03em;
    }

    .auth-card .subtitle {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 32px;
      line-height: 1.6;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--text);
    }

    .form-group input {
      width: 100%;
      padding: 14px 16px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border);
      border-radius: 14px;
      color: var(--text);
      font-size: 0.95rem;
      font-family: inherit;
      outline: none;
      transition: border-color 200ms ease, box-shadow 200ms ease;
    }

    .form-group input::placeholder {
      color: var(--text-muted);
    }

    .form-group input:focus {
      border-color: var(--border-focus);
      box-shadow: 0 0 0 3px rgba(124, 92, 255, 0.15);
    }

    .form-options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      font-size: 0.88rem;
    }

    .form-options label {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--text-muted);
      cursor: pointer;
    }

    .form-options input[type="checkbox"] {
      accent-color: var(--accent);
      width: 16px;
      height: 16px;
    }

    .error-message {
      background: rgba(248, 113, 113, 0.1);
      border: 1px solid rgba(248, 113, 113, 0.25);
      border-radius: 12px;
      padding: 12px 16px;
      color: var(--error);
      font-size: 0.88rem;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-submit {
      width: 100%;
      padding: 16px;
      border: none;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      color: #fff;
      font-size: 1rem;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      transition: transform 180ms ease, box-shadow 180ms ease;
      box-shadow: 0 16px 48px rgba(124, 92, 255, 0.2);
    }

    .btn-submit:hover {
      transform: translateY(-1px);
      box-shadow: 0 20px 56px rgba(124, 92, 255, 0.3);
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    .auth-footer {
      text-align: center;
      margin-top: 24px;
      font-size: 0.9rem;
      color: var(--text-muted);
    }

    .auth-footer a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
      transition: color 180ms ease;
    }

    .auth-footer a:hover {
      color: var(--accent-2);
    }

    @media (max-width: 480px) {
      .auth-card {
        padding: 28px 22px;
      }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    {{-- Brand --}}
    <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
      <div class="auth-brand">
        <img src="{{ asset('images/logo.jpg') }}" alt="Print Silently">
        <div>
          <div class="auth-brand-name">Print Silently</div>
          <div class="auth-brand-tag">Print. Ship. Deliver.</div>
        </div>
      </div>
    </a>

    {{-- Card --}}
    <div class="auth-card">
      <h1>Welcome back</h1>
      <p class="subtitle">Sign in to access your dashboard, printers, and API keys.</p>

      @if($errors->any())
        <div class="error-message">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M8 4.5v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="8" cy="11" r="0.75" fill="currentColor"/></svg>
          {{ $errors->first() }}
        </div>
      @endif

      @if(session('success'))
        <div class="error-message" style="background: rgba(52,211,153,0.1); border-color: rgba(52,211,153,0.25); color: var(--success);">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 8.5l2 2 3.5-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="form-group">
          <label for="email">Email address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="jane@company.com" required autofocus>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="form-options">
          <label>
            <input type="checkbox" name="remember" value="1"> Remember me
          </label>
        </div>

        <button type="submit" class="btn-submit">Sign in</button>
      </form>
    </div>

    {{-- Footer --}}
    <div class="auth-footer">
      Don't have an account? <a href="{{ route('register') }}">Create one</a>
    </div>
  </div>
</body>
</html>
