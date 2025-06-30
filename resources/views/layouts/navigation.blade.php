<nav >
    <div class=" d-flex justify-content-between align-items-center gap-2">

        <a href="{{route('home')}}" class="d-flex align-items-center gap-2">
            <img class="logo" src="/storage/logo.png" alt="Logo" class="logo">
            <h1 class="h1" style="white-space: nowrap;">HẢI VÂN</h1>
        </a>
    </div>
    <ul class="nav-list">
        @php
            use App\Helpers\PermissionHelper;
            $navigationItems = PermissionHelper::getNavigationItems();
        @endphp
        
        @foreach($navigationItems as $item)
            <li class="nav-item {{ request()->routeIs($item['route'].'*') ? 'active' : '' }}" data-tooltip="{{ $item['text'] }}">
                <a class="nav-link" href="{{ route($item['route']) }}">
                    <i class="{{ $item['icon'] }}" style="color:var(--nav-font-color);"></i>
                    <span>{{ $item['text'] }}</span>
                </a>
            </li>
        @endforeach
        
        <!-- Đã xóa nút Hồ sơ và Đăng xuất ở navigation -->
    </ul>
</nav>
<style>
    .tam{
        color: var(--font-color) !important;
    }
    .logo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    nav {
        grid-area: nav;
        padding: 18px 15px;
        font-size: 18px;
        font-weight: 600;
        background-color: var(--nav-background);
        transition: all 0.5s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: start;
        flex-direction: column;
        gap: 30px;
        width: 250px;
        overflow: hidden;
    }

    /* Collapsed navigation styles */
    nav.collapsed {
        width: 80px;
        padding: 18px 10px;
    }

    nav.collapsed .logo {
        width: 40px;
        height: 40px;
    }

    nav.collapsed h1 {
        display: none;
        opacity: 0;
        transform: translateX(-20px);
    }

    nav.collapsed .nav-link {
        justify-content: center;
        gap: 0;
        padding: 5px;
    }

    nav.collapsed .nav-link span {
        display: none;
        opacity: 0;
        transform: translateX(-20px);
    }

    /* Animation for text elements */
    nav h1,
    nav .nav-link span,
    nav .nav-link {
        transition: all 0.3s ease;
    }

    /* Ensure icons remain visible */
    nav.collapsed .nav-link i {
        display: flex !important;
        opacity: 1;
        transform: translateX(0);
    }

    /* Tooltip styles for collapsed navigation */
    nav.collapsed .nav-item {
        position: relative;

    }

    /* nav.collapsed .nav-item:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        background-color: var(--dark-color);
        color: var(--background-color);
        padding: 8px 12px;
        border-radius: 4px;
        white-space: nowrap;
        z-index: 1000;
        margin-left: 10px;
        font-size: 14px;
        box-shadow: var(--box-shadow);
        opacity: 0;
        animation: fadeInTooltip 0.3s ease forwards;
    } */

    @keyframes fadeInTooltip {
        from {
            opacity: 0;
            transform: translateY(-50%) translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

     .nav-link {
        display: flex;
        align-items: center;
        gap: 30px;
        width: 100%;
        padding: 5px 5px 5px 20px;
        cursor: pointer;
        font-size: 20px;
        font-weight: 600;
        line-height: 24px;
        text-decoration: none;
    }
  
    .logout-btn {
        color: #dc3545 !important;
    }
    
    .logout-btn:hover {
        background-color: #dc3545 !important;
        color: white !important;
    }

    .nav-item {
        width: 100%;
        height: 36px;
        display: flex;
        border-radius: 5px;
        overflow: visible;
    }



     .nav-item:hover {
        background-color: var(--background-color-hover);
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
    .nav-item.active{
        background-color: #9b9a9a;
    }

    .nav-item .nav-link i {
        min-width: 22px;
        max-width: 22px;
        height: 22px;
        align-self: center;
        display: flex;
        justify-content: center;
    }

    .nav-item .nav-link i::before {
        font-size: 22px;
    }
</style>

<script>
function logoutWithJS(event) {
    event.preventDefault();
    
    // Clear cookies using JavaScript
    document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "user_type=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
    // Submit the form
    document.getElementById('logoutForm').submit();
}
</script>