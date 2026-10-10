<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Document Request System')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="@yield('body-class')">

    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password Visibility Toggle Logic
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

            // Tabs Logic
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
        });
    </script>
</body>
</html>