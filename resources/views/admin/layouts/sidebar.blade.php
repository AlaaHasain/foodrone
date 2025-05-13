<style>
    /* Main container to handle the sidebar and content layout */
    .admin-container {
        display: flex;
        min-height: 100vh;
        position: relative;
    }
    
    /* Content area that adjusts based on sidebar state */
    .content-area {
        flex: 1;
        margin-left: 260px; /* Same as sidebar width */
        transition: margin-left 0.3s ease;
        width: calc(100% - 260px);
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

@php
    $userCount = \App\Models\User::count();
@endphp

<!-- Main container that wraps sidebar and content -->
<div class="admin-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Lemongrass</h2>
            <button class="sidebar-toggle" id="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item" data-title="Dashboard">
                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
        
            <a href="{{ route('admin.users.index') }}" class="menu-item" data-title="Users">
                <i class="fas fa-users"></i><span>Users ({{ $userCount }})</span>
            </a>
        
            <a href="{{ route('admin.menu-items.index') }}" class="menu-item" data-title="Menu Items">
                <i class="fas fa-utensils"></i><span>Menu Items</span>
            </a>
        
            {{-- ✅ قسم التصنيفات --}}
            <a href="{{ route('admin.categories.index') }}" class="menu-item" data-title="Categories">
                <i class="fas fa-tags"></i><span>Categories</span>
            </a>
        
            {{-- ✅ قسم الطاولات QR --}}
            <a href="{{ route('admin.tables.index') }}" class="menu-item" data-title="QR Tables">
                <i class="fas fa-qrcode"></i><span>QR Tables</span>
            </a>
        
            <a href="{{ route('admin.orders.index') }}" class="menu-item" data-title="Orders">
                <i class="fas fa-shopping-cart"></i><span>Orders</span>
            </a>
        
            <a href="{{ route('admin.reservations.index') }}" class="menu-item" data-title="Reservations">
                <i class="fas fa-calendar-alt"></i>
                <span>
                    Reservations
                    @if(isset($pendingReservationsCount) && $pendingReservationsCount > 0)
                        <span class="badge badge-danger">{{ $pendingReservationsCount }}</span>
                    @endif
                </span>
            </a>
        
            <a href="{{ route('admin.galleries.index') }}" class="menu-item" data-title="Gallery">
                <i class="fas fa-images"></i><span>Gallery</span>
            </a>
        
            <a class="menu-item" href="{{ route('admin.contact-messages.index') }}" data-title="Contact Messages" id="contact-messages-link">
                <i class="fas fa-envelope"></i>
                <span>
                    Contact Messages
                    <span class="badge badge-danger" id="sidebar-messages-badge" style="display: none;">0</span>
                </span>
            </a>
        
            <a href="{{ route('admin.testimonials.index') }}" class="menu-item position-relative" id="testimonialLink" data-title="Testimonials">
                <i class="fas fa-comment-dots"></i>
                <span>
                    Testimonials
                    <span class="badge badge-danger" id="testimonialAlert" style="display: none;">0</span>
                </span>
            </a>
        
            <audio id="testimonialSound" src="{{ asset('sounds/mixkit-confirmation-tone-2867.wav') }}" preload="auto"></audio>
        
            <a href="{{ route('admin.footer-info.index') }}" class="menu-item" data-title="Footer Info">
                <i class="fas fa-shoe-prints"></i><span>Footer Info</span>
            </a>
        
            <a href="{{ route('admin.settings.index') }}" class="menu-item" data-title="Settings">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>
        </div>        
    </div>
</div>

<script>
    let lastTestimonialCount = 0;

    function checkNewTestimonials() {
        fetch("{{ route('admin.testimonials.pendingCount') }}")
            .then(response => response.json())
            .then(data => {
                const newCount = data.count;
                const badge = document.getElementById('testimonialAlert');
                const sound = document.getElementById('testimonialSound');

                if (newCount > 0) {
                    badge.style.display = 'inline-block';
                    badge.textContent = newCount;
                } else {
                    badge.style.display = 'none';
                }

                if (newCount > lastTestimonialCount) {
                    // New testimonial came in
                    if (sound) sound.play();
                }

                lastTestimonialCount = newCount;
            })
            .catch(error => {
                console.error("Error checking testimonials:", error);
            });
    }

    // Start polling
    document.addEventListener("DOMContentLoaded", () => {
        checkNewTestimonials(); // First load
        setInterval(checkNewTestimonials, 10000); // Every 10 seconds
    });
</script>

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
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarBadge = document.getElementById('sidebar-messages-badge');
        
        function checkUnreadMessages() {
            fetch('{{ route("admin.contact-messages.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const count = data.count;
                    
                    if (count > 0) {
                        sidebarBadge.textContent = count;
                        sidebarBadge.style.display = 'inline-block';
                    } else {
                        sidebarBadge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error checking unread messages:', error));
        }
        
        // Check immediately and then every 30 seconds
        checkUnreadMessages();
        setInterval(checkUnreadMessages, 30000);
    });
</script>