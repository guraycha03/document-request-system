<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document Request System</title>
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
        body::-webkit-scrollbar {
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
            padding: 24px;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            letter-spacing: -0.1px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container { 
            max-width: 960px; 
            margin: 0 auto; 
        }

        /* ==========================================================================
           CARDS & FORMS
           ========================================================================== */
        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03), 0 10px 25px -5px rgba(15, 23, 42, 0.05);
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0 0 20px;
            color: var(--text);
            text-transform: uppercase;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: #ffffff;
            margin-bottom: 18px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px var(--accent-ring) !important;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            padding-right: 40px;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
        }

        textarea { resize: vertical; min-height: 84px; }

        /* Perfect Center for Password Eye Icon */
        .input-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 18px;
        }

        .input-wrapper input {
            margin-bottom: 0;
            padding-right: 44px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            padding: 6px;
            margin: 0;
            cursor: pointer;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.15s ease, background 0.15s ease;
            z-index: 2;
        }

        .toggle-password:hover {
            color: var(--text);
            background-color: rgba(0, 0, 0, 0.04);
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            display: block;
        }

        /* Buttons */
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--accent);
            color: #ffffff;
            border: 0;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.05s ease;
        }
        .button:hover { background: var(--accent-hover); }
        .button:active { transform: translateY(1px); }

        .button-secondary {
            background: #f1f5f9;
            color: var(--text);
            border: 1px solid var(--line);
        }
        .button-secondary:hover { background: #e2e8f0; }

        /* Notifications & Alerts */
        .success {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--approved-bg);
            color: var(--approved);
            border: 1px solid var(--approved-border);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 22px;
        }

        /* Tables */
        .table-wrap { 
            overflow-x: auto;
            scrollbar-width: none;
        }
        .table-wrap::-webkit-scrollbar { display: none; }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th {
            background: #f8fafc;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--muted);
            text-align: left;
            padding: 12px 14px;
            white-space: nowrap;
        }
        td { padding: 14px; border-top: 1px solid var(--line); vertical-align: top; }
        tbody tr:hover { background: #f8fafc; }

        /* Status Badges */
        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: var(--pending-bg);
            color: var(--pending);
            border: 1px solid var(--pending-border);
            white-space: nowrap;
        }
        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #d9a13b;
        }
        .status.approved { background: var(--approved-bg); color: var(--approved); border-color: var(--approved-border); }
        .status.approved::before { background: #2f6b57; }
        .status.rejected { background: var(--rejected-bg); color: var(--rejected); border-color: var(--rejected-border); }
        .status.rejected::before { background: #c44545; }

        /* Role Badges */
        .role-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .role-badge.requester { background: #e8f3ee; color: #2c5a47; }
        .role-badge.staff_reviewer { background: #e8eef3; color: #2f5a8a; }
        .role-badge.record_keeper { background: #f3e8f3; color: #7a2f8a; }

        /* Tabs */
        .tab-header {
            display: flex;
            border-bottom: 1px solid var(--line);
            margin: -28px -28px 24px;
            padding: 0 28px;
        }
        .tab-btn {
            background: transparent;
            border: none;
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            position: relative;
            transition: color 0.15s ease;
        }
        .tab-btn:hover { color: var(--text); }
        .tab-btn.active { color: var(--accent); }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
        }
        .tab-pane { display: none; animation: fadeIn 0.15s ease; }
        .tab-pane.active { display: block; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(2px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    @include('partials.global-header', ['headerSubtitle' => auth()->user()->isRequester() ? 'Submit and track your document requests' : (auth()->user()->isStaffReviewer() ? 'Review and process pending document requests' : 'View all document request records and audit trails')])

    <div class="container">
        @if (session('success'))
            <div class="success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (auth()->user()->isRequester())
            @include('partials.requester-dashboard')
        @elseif (auth()->user()->isStaffReviewer())
            @include('partials.staff-reviewer-dashboard')
        @elseif (auth()->user()->isRecordKeeper())
            @include('partials.record-keeper-dashboard')
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabs = document.querySelectorAll('.tab-btn');
            const panes = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;

                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    panes.forEach(p => p.classList.remove('active'));
                    const targetPane = document.getElementById(targetTab);
                    if (targetPane) targetPane.classList.add('active');
                });
            });

            // Password Toggle
            const toggleBtn = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.querySelector('.eye-open');
            const eyeClosed = document.querySelector('.eye-closed');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    if (eyeOpen && eyeClosed) {
                        eyeOpen.style.display = isPassword ? 'none' : 'block';
                        eyeClosed.style.display = isPassword ? 'block' : 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>