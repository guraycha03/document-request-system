<header class="global-header">
    <div class="header-content">
        <div class="header-brand">
            <div class="brand-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="brand-text">
                <h1>Document Request System</h1>
                <p class="header-subtitle">{{ $headerSubtitle ?? '' }}</p>
            </div>
        </div>

        <div class="header-user-wrapper">
            <button type="button" class="user-card-btn" id="userMenuBtn" onclick="toggleUserDropdown(event)">
                <div class="user-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span class="user-role {{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
                </div>
                <svg class="dropdown-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <div class="user-dropdown-menu" id="userDropdown">
                <div class="menu-header">
                    <div class="menu-user-name">{{ auth()->user()->name }}</div>
                    <div class="menu-user-email">{{ auth()->user()->email }}</div>
                </div>
                
                <div class="menu-divider"></div>

                <a href="javascript:void(0)" class="dropdown-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<style>
    :root { --header-bg: #ffffff; }

    /* Hide scrollbars globally */
    html, body, * { -ms-overflow-style: none; scrollbar-width: none; }
    *::-webkit-scrollbar { display: none; }

    /* Completely strip default browser focus outlines and tap highlights */
    *, *:focus, *:focus-visible, *:active, button:focus, input:focus, select:focus, textarea:focus { outline: none !important; box-shadow: none; -webkit-tap-highlight-color: transparent; }

    .global-header { position: fixed; top: 0; left: 0; right: 0; background: var(--header-bg); border-bottom: 1px solid var(--line); padding: 14px 24px; z-index: 100; box-shadow: 0 1px 3px rgba(20, 30, 40, 0.06); }
    .header-content { width: 100%; max-width: 100%; display: flex; justify-content: space-between; align-items: center; gap: 16px; }
    .header-brand { display: flex; align-items: center; gap: 12px; }
    .brand-icon { display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 10px; background: var(--accent); color: #ffffff; flex-shrink: 0; box-shadow: 0 2px 8px rgba(47, 107, 87, 0.25); }
    .brand-text h1 { font-size: 18px; font-weight: 700; letter-spacing: 0.3px; margin: 0; color: var(--text); }
    .header-subtitle { font-size: 12px; color: var(--muted); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; }

    /* Account Header Wrapper */
    .header-user-wrapper { position: relative; }
    
    /* User Profile Card Button */
    .user-card-btn { display: flex; align-items: center; gap: 12px; background: #ffffff; border: 1px solid var(--line); padding: 7px 14px; border-radius: 10px; cursor: pointer; transition: all 0.15s ease; user-select: none; }
    .user-card-btn:hover, .user-card-btn:focus, .user-card-btn:focus-visible, .user-card-btn.active { background: #f8fafc; border-color: rgba(0,0,0,0.15) !important; box-shadow: 0 2px 6px rgba(0,0,0,0.04) !important; outline: none !important; }

    /* Single-line left-aligned Name and Role */
    .user-info { display: flex; flex-direction: row; align-items: center; justify-content: flex-start; gap: 8px; }
    .user-info strong { font-size: 13px; color: var(--text); line-height: 1; font-weight: 600; white-space: nowrap; }

    /* Role Badge */
    .user-role { display: inline-flex; align-items: center; padding: 2px 7px; border-radius: 999px; font-size: 9px; font-weight: 600; letter-spacing: 0.4px; text-transform: uppercase; background: #f4f6f8; color: var(--muted); border: 1px solid var(--line); white-space: nowrap; }
    .user-role.requester { background: #e8f3ee; color: #2c5a47; border-color: transparent; }
    .user-role.staff_reviewer { background: #e8eef3; color: #2f5a8a; border-color: transparent; }
    .user-role.record_keeper { background: #f3e8f3; color: #7a2f8a; border-color: transparent; }

    .dropdown-chevron { color: var(--muted); transition: transform 0.2s ease; flex-shrink: 0; }
    .user-card-btn.active .dropdown-chevron { transform: rotate(180deg); }

    /* Dropdown Modal Menu */
    .user-dropdown-menu { display: none; position: absolute; top: calc(100% + 8px); right: 0; width: 210px; background: #ffffff; border: 1px solid var(--line); border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.05); padding: 8px; z-index: 110; animation: fadeIn 0.15s ease-out; }
    .user-dropdown-menu.show { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }

    .menu-header { padding: 6px 10px; }
    .menu-user-name { font-size: 13px; font-weight: 600; color: var(--text); }
    .menu-user-email { font-size: 11px; color: var(--muted); word-break: break-all; }
    .menu-divider { height: 1px; background: var(--line); margin: 6px 0; }

    .dropdown-item { display: flex; align-items: center; gap: 10px; width: 100%; padding: 8px 10px; border: 0; background: transparent; border-radius: 8px; font-size: 13px; font-weight: 500; color: var(--text); text-decoration: none; cursor: pointer; transition: background 0.15s ease; box-sizing: border-box; }
    .dropdown-item:hover { background: #f4f6f8; }

    .logout-form { margin: 0; }
    .logout-item { color: #dc2626; }
    .logout-item:hover { background: #fef2f2 !important; }

    body { padding-top: 90px; }

    @media (max-width: 640px) {
        .header-content { flex-direction: column; align-items: flex-start; }
        .header-user-wrapper { width: 100%; }
        .user-card-btn { width: 100%; justify-content: space-between; }
        .user-dropdown-menu { width: 100%; }
        body { padding-top: 130px; }
    }
</style>

<script>
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        const btn = document.getElementById('userMenuBtn');
        dropdown.classList.toggle('show');
        btn.classList.toggle('active');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const btn = document.getElementById('userMenuBtn');
        if (dropdown && !dropdown.contains(event.target) && !btn.contains(event.target)) {
            dropdown.classList.remove('show');
            btn.classList.remove('active');
        }
    });
</script>