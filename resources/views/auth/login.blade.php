<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Document Request System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ==========================================================================
           GLOBAL DESIGN SYSTEM & VARIABLES
           ========================================================================== */
        :root {
            --bg: #f4f6f8;
            --surface: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --line: #e2e8f0;
            --accent: #2f6b57;
            --accent-hover: #245343;
            --accent-ring: rgba(47, 107, 87, 0.16);
            --radius: 12px;
            --approved: #2c5a47;
            --approved-bg: #e8f3ee;
            --approved-border: #cfe3d8;
            --rejected: #9b2c2c;
            --rejected-bg: #fdeaea;
            --rejected-border: #f5c6c6;
            --pending: #8a6d2b;
            --pending-bg: #fbf0dc;
            --pending-border: #f2e0b8;
        }

        /* 1. Global Reset & Remove Default Browser Focus/Scrollbars */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar,
        *::-webkit-scrollbar {
            display: none; /* Chrome/Safari/Opera */
        }

        input, select, textarea, button {
            outline: none !important;
            -webkit-tap-highlight-color: transparent;
        }

        *:focus-visible {
            outline: none !important;
        }

        body {
            padding: 40px 24px;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            letter-spacing: -0.1px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 40px 36px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 10px 25px -5px rgba(15, 23, 42, 0.05);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
        }
        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--accent);
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(47, 107, 87, 0.25);
        }
        .brand h1 { font-size: 22px; font-weight: 700; letter-spacing: 0.3px; margin: 0; color: var(--text); }
        .subtitle { color: var(--muted); font-size: 14px; margin: 2px 0 0; }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.2px;
            margin: 0 0 6px;
            color: var(--text);
        }
        .card-subtitle {
            color: var(--muted);
            font-size: 14px;
            margin: 0 0 32px;
            font-weight: 400;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            margin-bottom: 22px;
            letter-spacing: 0.1px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        input:hover {
            border-color: #cbd5e1;
        }

        input[type="password"] {
            padding-right: 48px;
        }

        input:focus {
            border-color: var(--accent);
            background: var(--surface);
            box-shadow: 0 0 0 3px var(--accent-ring);
        }

        input::placeholder {
            color: #94a3b8;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-85%);
            background: transparent;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s ease;
            border-radius: 6px;
        }

        .toggle-password:hover {
            color: var(--text);
            background: #f1f5f9;
        }

        .toggle-password:focus {
            outline: none;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }

        .button {
            width: 100%;
            background: var(--accent);
            color: #ffffff;
            border: 0;
            padding: 14px 22px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.05s ease, box-shadow 0.15s ease;
            box-shadow: 0 2px 6px rgba(47, 107, 87, 0.2);
        }
        .button:hover { 
            background: var(--accent-hover); 
            box-shadow: 0 4px 12px rgba(47, 107, 87, 0.3);
        }
        .button:active { transform: translateY(1px); }
        .button:focus-visible {
            box-shadow: 0 0 0 3px var(--accent-ring), 0 4px 12px rgba(47, 107, 87, 0.3);
        }

        .error {
            background: var(--rejected-bg);
            color: var(--rejected);
            border: 1px solid var(--rejected-border);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .error svg { flex-shrink: 0; width: 18px; height: 18px; }

        .demo-accounts {
            margin-top: 24px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid var(--line);
        }
        .demo-accounts h4 {
            margin: 0 0 16px;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .demo-accounts ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 10px;
        }
        .demo-accounts li {
            font-size: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            color: var(--text);
            background: var(--surface);
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .demo-accounts strong {
            color: var(--accent);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="brand">
                <div class="brand-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <div>
                    <h1>Document Request System</h1>
                    <p class="subtitle">Sign in to your account</p>
                </div>
            </div>

            <h2 class="card-title">Welcome Back</h2>
            <p class="card-subtitle">Enter your credentials to access the system</p>

            @if ($errors->any())
                <div class="error" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@email.com">

                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    <button type="button" class="toggle-password" aria-label="Toggle password visibility" tabindex="-1">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>

                <button type="submit" class="button">Sign In</button>
            </form>
        </div>

        <div class="demo-accounts">
            <h4>Demo Accounts</h4>
            <ul>
                <li><strong>Requester:</strong> john@gmail.com / requester123</li>
                <li><strong>Staff Reviewer:</strong> staff@gmail.com / staff123</li>
                <li><strong>Record Keeper:</strong> keeper@gmail.com / keeper123</li>
            </ul>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle
            const toggleBtn = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.querySelector('.eye-open');
            const eyeClosed = document.querySelector('.eye-closed');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    eyeOpen.style.display = isPassword ? 'none' : 'block';
                    eyeClosed.style.display = isPassword ? 'block' : 'none';
                });
            }
        });
    </script>
</body>
</html>