<nav>
    <div class=" d-flex justify-content-between align-items-center gap-2">

        <a href="{{route('home')}}" class="d-flex align-items-center gap-2">
            <img class="logo" src="/storage/logo.png" alt="Logo" class="logo">
            <h1 class="h1" style="white-space: nowrap;">HẢI VÂN</h1>
        </a>
    </div>
    <ul class="nav-list">
        <li class="nav-item {{ request()->routeIs('home.*') ? 'active' : '' }}" data-tooltip="Dashboard">
            <a class="nav-link  " href="{{ route('home') }}">
                <i class="fa-solid fa-house" style="color:var(--nav-font-color);"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('nhan-su.*') ? 'active' : '' }}" data-tooltip="Nhân Sự">
            <a class="nav-link " href="{{ route('nhan-su.index') }}">
                <i class="fa-solid fa-users" style="color:var(--nav-font-color);"></i>
                <span>Nhân Sự</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('luong.*') ? 'active' : '' }} " data-tooltip="Lương">
            <a class="nav-link " href="{{ route('luong') }}">
                <i class="fa-solid fa-money-bill" style="color:var(--nav-font-color);"></i>
                <span>Lương</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('hop-dong.*') ? 'active' : '' }} " data-tooltip="Hợp Đồng">
            <a class="nav-link " href="{{ route('hop-dong.index') }}">
                <i class="fa-solid fa-receipt" style="color:var(--nav-font-color);"></i>
                <span>Hợp Đồng</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('bao-hiem-yte.*') ? 'active' : '' }} " data-tooltip="Bảo Hiểm">
            <a class="nav-link " href="{{ route('bao-hiem-yte.index') }}">
                <i class="fa-solid fa-shield-halved" style="color:var(--nav-font-color);"></i>
                <span>Bảo Hiểm</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('phong-ban.*') ? 'active' : '' }}" data-tooltip="Phòng Ban">
            <a class="nav-link  " href="{{ route('phong-ban.index') }}" >
                <i class="fa-solid fa-building" style="color:var(--nav-font-color);"></i>
                <span>Phòng Ban</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('chuc-vu.*') ? 'active' : '' }}" data-tooltip="Chức Vụ">
            <a class="nav-link " href="{{ route('chuc-vu.index') }}">
                <i class="fa-solid fa-crown" style="color:var(--nav-font-color);"></i>
                <span>Chức Vụ</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('trinh-do.*') ? 'active' : '' }}" data-tooltip="Trình Độ">
            <a class="nav-link " href="{{ route('trinh-do.index') }}">
                <i class="fa-solid fa-graduation-cap" style="color:var(--nav-font-color);"></i>
                <span>Trình Độ</span>
            </a>
        </li>
        <!--  -->
        <!--  -->
        <li class="nav-item {{ request()->routeIs('phu-cap.*') ? 'active' : '' }}" data-tooltip="Phụ Cấp">
            <a class="nav-link " href="{{ route('nhan-vien-phu-cap.index') }}">
                <i class="fa-solid fa-hands-holding-child" style="color:var(--nav-font-color);"></i>
                <span>Phụ Cấp</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('cham-cong.*') ? 'active' : '' }} " data-tooltip="Chấm công">
            <a class="nav-link " href="{{ route('cham-cong.index') }}">
                <i class="fa-solid fa-calendar-days" style="color:var(--nav-font-color);"></i>
                <span>Chấm công</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item {{ request()->routeIs('chuyen-can.*') ? 'active' : '' }} " data-tooltip="Chuyên Cần">
            <a class="nav-link " href="{{ route('chuyen-can.index') }}">
                <i class="fa-solid fa-star" style="color:var(--nav-font-color);"></i> <!-- Example icon, change as needed -->
                <span>Chuyên Cần</span>
            </a>
        </li>
        <!--  -->
        <li class="nav-item " data-tooltip="Tài Khoản">
            <a class="nav-link " href="">
                <i class="fa-solid fa-user" style="color:var(--nav-font-color);"></i>
                <span>Tài Khoản</span>
            </a>
        </li>
        
       
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

    .nav-link {
        text-decoration: none;
    }
</style>