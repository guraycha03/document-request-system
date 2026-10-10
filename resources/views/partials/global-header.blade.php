<header class="global-header">
    <div class="header-content">
        <div class="header-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/logo-img.png') }}" alt="Document Request System logo">
            </div>
            <div class="brand-text">
                <h1>Document Request System</h1>
                <p class="header-subtitle">{{ $headerSubtitle ?? 'Registrar Services Portal' }}</p>
            </div>
        </div>

        <div class="header-user-wrapper">
            <button type="button" class="user-card-btn" id="userMenuBtn" onclick="toggleUserDropdown(event)" aria-haspopup="true" aria-expanded="false">
                <div class="avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
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

<script>
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        const btn = document.getElementById('userMenuBtn');
        dropdown.classList.toggle('show');
        btn.classList.toggle('active');
        btn.setAttribute('aria-expanded', dropdown.classList.contains('show'));
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const btn = document.getElementById('userMenuBtn');
        if (dropdown && !dropdown.contains(event.target) && !btn.contains(event.target)) {
            dropdown.classList.remove('show');
            btn.classList.remove('active');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
</script>
