<header style="grid-area: header;">
    <i class="fa-solid fa-bars"></i>
    <div class="acc__container">
        <button class="theme-toggle" onclick="toggleTheme()">
            <i class="fa-solid fa-sun"></i>
            <i class="fa-solid fa-moon" style="display:none;"></i>
        </button>
        <div class="acc__avatar" id="userProfileBtn" onclick="toggleUserDropdown()">
            <i class="fa-solid fa-circle-user d-flex align-items-center justify-content-center"></i>
        </div>
        <span class="acc__name" id="userInfoDisplay">
            @php
                $user = request()->attributes->get('current_user');
            @endphp
            {{ $user && $user->info ? $user->info : ($user ? $user->username : '') }}
        </span>
        <div class="dropdown" id="userDropdown" style="display:none; position: absolute; right: 10px; top: 60px; min-width: 180px; z-index: 999;">
            <ul class="dropdown-menu show" style="display:block; position:static;">
                <li><a class="dropdown-item" href="{{ route('profile') }}">Hồ sơ</a></li>
                <li><a class="dropdown-item" href="{{ route('password.change') }}">Đổi Mật Khẩu</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Đăng Xuất</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
<style>
    header h1,
    header h2,
    header h3,
    header h4,
    header h5,
    header h6,
    header a,
    header p,
    header span {
        font-family: var(--font-primary);
        color: var(--text) !important;
    }

    header a {
        color: var(--background-color);
    }

    .fa-bars {
        cursor: pointer;
        color: var(--text);
        font-size: 20px;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .fa-bars:hover {
        background-color: var(--background-color-hover);
    }

    .fa-moon {
        border: 1px solid var(--text);
        color: var(--text);
        display: flex;
        justify-content: center;
        align-items: center;
        /* padding: 5px; */
        border-radius: 50%;
        width: 32px;
        aspect-ratio: 1;
        cursor: pointer;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px 10px 10px;
        color: #fff;
        font-size: 18px;
        font-weight: 600;
    }

    header .logo {
        font-size: 24px;
        font-weight: 700;
    }

    .acc__container {
        display: flex;
        align-items: center;
        gap: 20px;
        justify-content: space-around;
    }

    .acc__avatar {
        border-radius: 50%;
        width: 32px;
        aspect-ratio: 1;
        cursor: pointer;
        overflow: hidden;
        outline: 1px solid var(--text);
    }

    .acc__avatar i,
    .acc__avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;

    }

    .acc__name {
        font-size: 18px;
        font-weight: 600;
        color: var(--background-color);
    }
</style>

<script>
    // Toggle navigation collapse
    function toggleNavigation() {
        const nav = document.querySelector('nav');
        const body = document.querySelector('body');
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        
        nav.classList.toggle('collapsed');
        
        // Add animation classes to header and main
        if (nav.classList.contains('collapsed')) {
            body.style.gridTemplateColumns = '80px 1fr';
            header.classList.add('nav-collapsed');
            if (main) main.classList.add('nav-collapsed');
        } else {
            body.style.gridTemplateColumns = '250px 1fr';
            header.classList.remove('nav-collapsed');
            if (main) main.classList.remove('nav-collapsed');
        }
    }
    
    // Add click event to menu button
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.querySelector('.fa-bars');
        if (menuButton) {
            menuButton.addEventListener('click', toggleNavigation);
        }
    });
</script>
<script>
    function toggleTheme() {
        const body = document.body;
        const currentTheme = body.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        body.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);

        // Toggle icon visibility
        const sunIcon = document.querySelector('.theme-toggle .fa-sun');
        const moonIcon = document.querySelector('.theme-toggle .fa-moon');
        if (newTheme === 'dark') {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'flex';
        } else {
            sunIcon.style.display = 'flex';
            moonIcon.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme') || 'light'; // Default to light if no theme saved
        document.body.setAttribute('data-theme', savedTheme);

        const sunIcon = document.querySelector('.theme-toggle .fa-sun');
        const moonIcon = document.querySelector('.theme-toggle .fa-moon');
        if (savedTheme === 'dark') {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'flex';
        } else {
            sunIcon.style.display = 'flex';
            moonIcon.style.display = 'none';
        }
    });
</script>
<script>
function toggleUserDropdown() {
    var dropdown = document.getElementById('userDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(event) {
    var dropdown = document.getElementById('userDropdown');
    var btn = document.getElementById('userProfileBtn');
    if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script>