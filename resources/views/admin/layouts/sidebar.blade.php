<style>
   /* إخفاء Scrollbar في جميع المتصفحات */
body, html {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
}

body::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Edge */
}

   /* Main container to handle the sidebar and content layout */
    .admin-container {
        display: flex;
        min-height: 100vh;
        position: relative;
    }
    
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden; /* نمنع scroll من الجسم */
}

.dashboard-container {
    height: 100vh;
    display: flex;
    overflow: hidden; /* مهم لمنع التمرير غير المقصود */
}

    /* Content area that adjusts based on sidebar state */
    .content-area {
        flex: 1;
        margin-left: 260px; /* Same as sidebar width */
        transition: margin-left 0.3s ease;
        width: calc(100% - 260px);
            overflow-y: auto; /* ✅ هنا يكون التمرير العمودي */
    max-height: 100vh; /* ✅ نحدد أقصى ارتفاع */
    padding: 20px; /* اختياري: عشان ما تلزق المحتويات */
    }
    
    .content-area.sidebar-collapsed {
        margin-left: 80px; /* Same as collapsed sidebar width */
        width: calc(100% - 80px);
    }
    
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background-color: #222831;
        color: #fff;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        z-index: 1000;
        overflow-y: auto; 
            -ms-overflow-style: none;  /* إخفاء شريط التمرير في IE و Edge */
    scrollbar-width: none; 
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #1b1f23;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
    }

    .sidebar-menu {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .sidebar {
    scrollbar-width: thin;
    scrollbar-color: #393e46 #222831;
}

/* For Webkit browsers (Chrome, Safari) */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: #222831;
}

.sidebar::-webkit-scrollbar-thumb {
    background-color: #393e46;
    border-radius: 6px;
}

    .menu-item {
        position: relative;
        padding: 0.9rem 1rem;
        color: #ccc;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .menu-item:hover,
    .menu-item.active {
        background-color: #393e46;
        color: #fff;
    }

    .sidebar.collapsed .menu-item span {
        display: none;
    }

    .sidebar.collapsed .menu-item::after {
        content: attr(data-title);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        background-color: #444;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        white-space: nowrap;
        font-size: 13px;
        opacity: 0;
        pointer-events: none;
        transition: 0.3s;
        z-index: 1001; /* Make sure tooltip appears above content */
    }

    .sidebar.collapsed .menu-item:hover::after {
        opacity: 1;
        margin-left: 10px;
    }

    .sidebar.collapsed .sidebar-header h2 {
        display: none;
    }

    .sidebar.collapsed .menu-item {
        justify-content: center;
    }

    .badge-danger {
        background-color: #ff4d4d;
        color: #fff;
        border-radius: 50px;
        padding: 0.2rem 0.5rem;
        font-size: 0.75rem;
        margin-left: 5px;
    }
    
    /* Media queries for responsive behavior */
    @media (max-width: 768px) {
        .sidebar {
            width: 260px;
            transform: translateX(-100%);
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .sidebar.mobile-visible {
            transform: translateX(0);
        }
        
        .content-area {
            margin-left: 0;
            width: 100%;
        }
        
        .content-area.sidebar-collapsed {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
<style>
.pulse-animation {
    animation: pulse 1.5s infinite;
}

.sidebar.collapsed .sidebar-logo,
.sidebar.collapsed .sidebar-logo-text {
    display: none !important;
}

@keyframes pulse {
    0%   { transform: scale(1); opacity: 1; }
    50%  { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
.sidebar-logo {
    height: 60px;
    width: auto;
    object-fit: contain;
    display: block;
    margin: 0 auto;
    transition: all 0.3s ease;
}

</style>


@php
    $userCount = \App\Models\User::count();
@endphp

<!-- Main container that wraps sidebar and content -->
<div class="admin-container">
    <!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar" id="sidebar"> <!-- ✅ هذا السطر مفقود عندك -->
    <div class="sidebar-header">
        <div class="sidebar-logo-wrapper" style="display: flex; align-items: center;">
            @php $logo = setting('logo'); @endphp

            @if($logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="sidebar-logo" style="height: 80px;">
            @else
                <h2 class="sidebar-logo-text" style="margin: 0;">Lemongrass</h2>
            @endif
        </div>

        <button class="sidebar-toggle" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item" data-title="Dashboard">
                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
        
@if(session('admin_role') === 'super_admin')
<a href="{{ route('admin.users.index') }}" class="menu-item">
    <i class="fas fa-users"></i><span>Users</span>
</a>
@endif

        
@if(in_array(session('admin_role'), ['staff', 'admin', 'super_admin']))
<a href="{{ route('admin.orders.index') }}" class="menu-item">
    <i class="fas fa-shopping-cart"></i>
    <span>Orders</span>
    <span id="ordersAlert" class="badge-danger" style="display: none; margin-left: auto;"></span>
</a>
@endif

        
@if(in_array(session('admin_role'), ['admin', 'super_admin']))
<a href="{{ route('admin.menu-items.index') }}" class="menu-item">
    <i class="fas fa-utensils"></i><span>Menu Items</span>
</a>

<a href="{{ route('admin.options.index') }}" class="menu-item">
    <i class="fas fa-sliders-h"></i><span>Options</span>
</a>

<a href="{{ route('admin.categories.index') }}" class="menu-item">
    <i class="fas fa-tags"></i><span>Categories</span>
</a>

<a href="{{ route('admin.tables.index') }}" class="menu-item">
    <i class="fas fa-qrcode"></i><span>QR Tables</span>
</a>

<a href="{{ route('admin.reservations.index') }}" class="menu-item">
    <i class="fas fa-calendar-alt"></i>
    <span>Reservations</span>
    <span id="reservationAlert" class="badge-danger" style="display: none; margin-left: auto;"></span>
</a>

<a href="{{ route('admin.galleries.index') }}" class="menu-item">
    <i class="fas fa-images"></i><span>Gallery</span>
</a>

<a href="{{ route('admin.contact-messages.index') }}" class="menu-item">
    <i class="fas fa-envelope"></i>
    <span>Contact Messages</span>
    <span id="sidebar-messages-badge" class="badge-danger" style="display: none; margin-left: auto;"></span>
</a>

<a href="{{ route('admin.testimonials.index') }}" class="menu-item">
    <i class="fas fa-comment-dots"></i>
    <span>Testimonials</span>
    <span id="testimonialAlert" class="badge-danger" style="display: none; margin-left: auto;"></span>
</a>

@endif

        
            <audio id="testimonialSound" src="{{ asset('sounds/mixkit-confirmation-tone-2867.wav') }}" preload="auto"></audio>
        
@if(session('admin_role') === 'super_admin')
<a href="{{ route('admin.footer-info.index') }}" class="menu-item">
    <i class="fas fa-shoe-prints"></i><span>Footer Info</span>
</a>

<a href="{{ route('admin.settings.index') }}" class="menu-item">
    <i class="fas fa-cog"></i><span>Settings</span>
</a>
@endif

<hr style="border-color: #444; margin: 1rem 0;">

<a href="{{ route('admin.logout') }}" class="menu-item" data-title="Logout">
    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
</a>

        </div>        
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const contentArea = document.getElementById("content-area");
        const toggleBtn = document.getElementById("sidebar-toggle");

        // Check if sidebar state is saved in localStorage
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
        
        if (isCollapsed) {
            sidebar.classList.add("collapsed");
            contentArea.classList.add("sidebar-collapsed");
        }

        // Toggle sidebar on button click
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            contentArea.classList.toggle("sidebar-collapsed");
            
            // Store sidebar state
            localStorage.setItem("sidebarCollapsed", sidebar.classList.contains("collapsed"));
        });
        
        // Mobile detection and toggle
        const mobileToggle = function() {
                if (!sidebar || !contentArea) return; // 🛑 الحماية من null

            if (window.innerWidth <= 768) {
                if (!sidebar.classList.contains('mobile-toggled')) {
                    sidebar.classList.add('mobile-toggled');
                    sidebar.classList.add('collapsed');
                    contentArea.classList.add('sidebar-collapsed');
                }
            } else {
                sidebar.classList.remove('mobile-toggled');
                // Only restore desktop state if it was manually toggled before
                if (isCollapsed) {
                    sidebar.classList.add("collapsed");
                    contentArea.classList.add("sidebar-collapsed");
                } else {
                    sidebar.classList.remove("collapsed");
                    contentArea.classList.remove("sidebar-collapsed");
                }
            }
        };
        
        // Run on load and resize
        mobileToggle();
        window.addEventListener('resize', mobileToggle);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarBadge = document.getElementById('sidebar-messages-badge');

        function checkUnreadMessages() {
            fetch('/admin/contact-messages/unread-count', {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    const count = data.count || 0;
                    if (count > 0) {
                        sidebarBadge.textContent = count;
                        sidebarBadge.style.display = 'inline-block';
                        sidebarBadge.classList.add('pulse-animation');
                    } else {
                        sidebarBadge.style.display = 'none';
                        sidebarBadge.classList.remove('pulse-animation');
                    }
                })
                .catch(error => {
                    console.error('Error checking unread messages:', error);
                });
        }

        // تشغيل أول مرة، ثم كل 30 ثانية
        checkUnreadMessages();
        setInterval(checkUnreadMessages, 30000);
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ordersBadge = document.getElementById('ordersAlert');

    function checkNewOrders() {
        fetch("{{ route('admin.orders.pendingCount') }}")
            .then(res => res.json())
            .then(data => {
                const count = data.count || 0;
                if (count > 0) {
                    ordersBadge.textContent = count;
                    ordersBadge.style.display = 'inline-block';
                    ordersBadge.classList.add('pulse-animation');
                } else {
                    ordersBadge.style.display = 'none';
                    ordersBadge.classList.remove('pulse-animation');
                }
            })
            .catch(error => {
                console.error('Error checking orders:', error);
            });
    }

    // تشغيل أول مرة ثم كل 15 ثانية
    checkNewOrders();
    setInterval(checkNewOrders, 15000);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const testimonialBadge = document.getElementById('testimonialAlert');
    const reservationBadge = document.getElementById('reservationAlert');

    function checkTestimonials() {
        fetch("{{ route('admin.testimonials.pendingCount') }}")
            .then(res => res.json())
            .then(data => {
                const count = data.count || 0;
                if (count > 0) {
                    testimonialBadge.textContent = count;
                    testimonialBadge.style.display = 'inline-block';
                    testimonialBadge.classList.add('pulse-animation');
                } else {
                    testimonialBadge.style.display = 'none';
                    testimonialBadge.classList.remove('pulse-animation');
                }
            });
    }

    function checkReservations() {
        fetch("{{ route('admin.reservations.pendingCount') }}")
            .then(res => res.json())
            .then(data => {
                const count = data.count || 0;
                if (count > 0) {
                    reservationBadge.textContent = count;
                    reservationBadge.style.display = 'inline-block';
                    reservationBadge.classList.add('pulse-animation');
                } else {
                    reservationBadge.style.display = 'none';
                    reservationBadge.classList.remove('pulse-animation');
                }
            });
    }

    // أول استدعاء + تحديث كل 15 ثانية
    checkTestimonials();
    checkReservations();
    setInterval(() => {
        checkTestimonials();
        checkReservations();
    }, 15000);
});
</script>
