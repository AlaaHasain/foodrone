<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- هنا روابط الخطوط والفونت اوسم والستايلات --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- هنا ستايلك اللي كتبته كامل (ممكن نخليه بملف CSS لاحقاً لو بدك ترتيب أكثر) --}}
    <style>
        :root {
            /* لوحة ألوان جديدة متناسقة */
            --primary-color: #26a69a; /* أخضر-أزرق للعناصر الرئيسية */
            --primary-hover: #00897b; /* أخضر-أزرق أغمق للتأثيرات */
            --secondary-color: #f5f7fa; /* رمادي فاتح للخلفيات الثانوية */
            --dark-color: #1a2a36; /* داكن للنصوص والخلفيات الداكنة */
            --light-color: #ffffff; /* أبيض للخلفيات والنصوص على خلفية داكنة */
            --medium-color: #e1e8ed; /* رمادي متوسط للحدود والفواصل */
            --sidebar-bg: #152036; /* خلفية الشريط الجانبي */
            --sidebar-active: #26a69a; /* لون العنصر النشط في الشريط الجانبي */
            --sidebar-hover: #1e2e45; /* لون التحويم في الشريط الجانبي */
            --success-color: #2ecc71; /* أخضر للعناصر الناجحة */
            --warning-color: #f39c12; /* برتقالي للتحذيرات */
            --danger-color: #e74c3c; /* أحمر للأخطاء والحالات الخطرة */
            --info-color: #3498db; /* أزرق فاتح للمعلومات */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        /* إخفاء Scrollbar في جميع المتصفحات */

        body {
            background-color: #f5f7fa;
            color: var(--dark-color);
            overflow-x: hidden;
                -ms-overflow-style: none;  /* IE 10+ */
    scrollbar-width: none;     /* Firefox */
        }

        h1,
        h2 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: var(--light-color);
            padding: 20px 0;
            transition: all 0.3s;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
        }

        .sidebar-header h2 {
            color: var(--primary-color);
            margin-bottom: 5px;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 0.5px;
            transition: opacity 0.3s;
        }

        .sidebar-collapsed .sidebar-header h2 {
            opacity: 0;
            display: none;
        }

        .sidebar-toggle {
            position: absolute;
            top: 5px;
            right: 10px;
            background: none;
            border: none;
            color: var(--light-color);
            font-size: 16px;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item, 
        .sidebar-menu a {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--light-color);
            text-decoration: none;
            margin: 2px 0;
            border-left: 3px solid transparent;
        }

        .menu-item:hover,
        .sidebar-menu a:hover {
            background-color: var(--sidebar-hover);
            border-left: 3px solid var(--primary-color);
        }

        .menu-item.active,
        .sidebar-menu a.active {
            background-color: var(--sidebar-active);
            border-left: 3px solid var(--light-color);
        }

        .menu-item i,
        .sidebar-menu a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 16px;
            color: var(--primary-color);
        }

        .menu-item span,
        .sidebar-menu a span {
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.3s;
            font-weight: 500;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 11px;
            margin-left: 8px;
            background-color: var(--danger-color);
            color: var(--light-color);
        }
        
        .badge-danger {
            background-color: var(--danger-color);
        }

        .sidebar-collapsed .menu-item span,
        .sidebar-collapsed .sidebar-menu a span {
            opacity: 0;
            width: 0;
            display: none;
        }
        
        .sidebar-collapsed .menu-item,
        .sidebar-collapsed .sidebar-menu a {
            padding: 15px 0;
            justify-content: center;
        }
        
        .sidebar-collapsed .menu-item i,
        .sidebar-collapsed .sidebar-menu a i {
            margin-right: 0;
            font-size: 18px;
        }
        
        .sidebar-collapsed .badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 3px 5px;
            font-size: 8px;
            min-width: 15px;
            height: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        } */
        /* إضافة CSS للشريط الجانبي عند الطي */
/* إضافة CSS للشريط الجانبي عند الطي */
/* #sidebar {
    transition: all 0.3s ease;
    width: 250px;
    min-width: 250px;
}

#sidebar.sidebar-collapsed {
    width: 0;
    min-width: 0;
    overflow: hidden;
}

#main-content {
    transition: all 0.3s ease;
}

#main-content.main-content-expanded {
    margin-right: 0; /* للتخطيط RTL - لا هامش عند إخفاء الشريط الجانبي */
} */

/* تنسيق أيقونات القائمة عند طي الشريط الجانبي */
/* #sidebar.sidebar-collapsed .menu-item i {
    font-size: 1.5rem;
    margin: 0 auto;
    display: flex;
    justify-content: center;
} */

/* إخفاء النص في عناصر القائمة عند طي الشريط الجانبي */
/* #sidebar.sidebar-collapsed .menu-item span {
    display: none;
} */

/* تنسيق عناصر القائمة عند طي الشريط الجانبي */
#sidebar.sidebar-collapsed .menu-item {
    text-align: center;
    padding: 12px 0;
    display: flex;
    justify-content: center;
}

/* تنسيق زر التبديل */
#sidebar-toggle {
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1000;
    position: relative;
}

#sidebar-toggle i {
    transition: all 0.3s ease;
}

/* تنسيق زر التبديل عندما يكون خارج الشريط الجانبي */
/* #sidebar-toggle.toggle-outside {
    position: fixed;
    right: 0;  
    top: 20px;
    background-color: #343a40; 
    padding: 10px;
    border-radius: 0 5px 5px 0;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
}  */

/* عندما يكون الشريط الجانبي مخفياً، نخفي كل المحتوى داخله */
/* #sidebar.sidebar-collapsed * {
    visibility: hidden;
} */

/* نجعل زر التبديل دائماً مرئي حتى عندما يكون الشريط الجانبي مخفياً */
#sidebar-toggle, #sidebar-toggle i {
    visibility: visible !important;
}
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s;
                overflow-y: auto; /* ✅ أضف هذا */
        }

        .main-content-expanded {
            margin-left: 70px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--medium-color);
        }

        .header h1 {
            color: var(--dark-color);
            font-size: 2.2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid var(--primary-color);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--light-color);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s;
            border-left: 4px solid var(--primary-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            margin-bottom: 10px;
            color: var(--dark-color);
            font-weight: 600;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .content-section {
            background-color: var(--light-color);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            color: var(--dark-color);
            font-size: 1.8rem;
        }

        .action-btn {
            background-color: var(--primary-color);
            color: var(--light-color);
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(38, 166, 154, 0.3);
        }

        .action-btn:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 4px 8px rgba(38, 166, 154, 0.4);
            transform: translateY(-1px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: var(--secondary-color);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--medium-color);
        }

        tr:hover {
            background-color: rgba(74, 111, 165, 0.05);
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            text-align: center;
        }

        .status.completed {
            background-color: rgba(39, 174, 96, 0.15);
            color: #27ae60;
        }

        .status.pending {
            background-color: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }

        .status.preparing {
            background-color: rgba(243, 156, 18, 0.15);
            color: #f39c12;
        }

        .status.published {
            background-color: rgba(39, 174, 96, 0.15);
            color: #27ae60;
        }

        .status.draft {
            background-color: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }

        .status.featured {
            background-color: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }

        .action-icons {
            display: flex;
            gap: 10px;
        }

        .action-icons i {
            cursor: pointer;
            color: var(--dark-color);
            transition: all 0.3s;
        }

        .action-icons i:hover {
            color: var(--primary-color);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: var(--light-color);
            padding: 30px;
            border-radius: 10px;
            width: 500px;
            max-width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-color);
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-color);
            border-radius: 6px;
            font-family: "Open Sans", sans-serif;
            transition: border 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border: 1px solid var(--primary-color);
            outline: none;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .secondary-btn {
            background-color: var(--medium-color);
            color: var(--dark-color);
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .secondary-btn:hover {
            background-color: #d1d8e0;
        }

        .tab-container {
            margin-bottom: 20px;
        }

        .tabs {
            display: flex;
            list-style-type: none;
            border-bottom: 1px solid var(--medium-color);
            margin-bottom: 20px;
        }

        .tab-item {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }

        .tab-item.active {
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
            border: 1px solid var(--medium-color);
        }

        .image-upload {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .upload-box {
            width: 100px;
            height: 100px;
            border: 2px dashed var(--medium-color);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .upload-box:hover {
            border-color: var(--primary-color);
        }

        .card {
            background: var(--light-color);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            color: var(--dark-color);
            border-top: 1px solid var(--medium-color);
            font-size: 14px;
        }

        /* @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-header h2 {
                display: none;
            }

            .menu-item span,
            .sidebar-menu a span {
                display: none;
            }
            
            .menu-item,
            .sidebar-menu a {
                padding: 15px 0;
                justify-content: center;
            }
            
            .menu-item i,
            .sidebar-menu a i {
                margin-right: 0;
                font-size: 18px;
            }

            .main-content {
                margin-left: 70px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .badge {
                position: absolute;
                top: 8px;
                right: 8px;
                padding: 3px 5px;
                font-size: 8px;
            } */
        }
    </style>
@yield('styles')

<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div class="dashboard-container">
    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

    {{-- Main Content --}}
    <div class="main-content" id="main-content">
        @php
    $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
@endphp

<div class="header">
    <h1>Admin Dashboard</h1>

    <div class="user-info">
        <a href="{{ route('admin.contact-messages.index') }}" style="position: relative; margin-right: 20px; color: inherit;">
            <i class="fas fa-envelope fa-lg"></i>
            @if($unreadMessagesCount > 0)
                <span style="
                    position: absolute;
                    top: -5px;
                    right: -10px;
                    background: red;
                    color: white;
                    padding: 2px 6px;
                    border-radius: 50%;
                    font-size: 12px;
                ">
                    {{ $unreadMessagesCount }}
                </span>
            @endif
        </a>

        {{-- <img src="{{ asset('images/admin.png') }}" alt="Admin" style="width: 40px; height: 40px; border-radius: 50%;"> --}}
    </div>
</div>

        @yield('content')
    </div>
</div>

{{-- سكريبتات التنقل والـ modals --}}
<script>
   // Toggle sidebar
   document.addEventListener('DOMContentLoaded', function() {
    // اضافة أيقونة للرابط الناقص
    const reservationLink = document.querySelector('a[href*="admin.reservations.index"]');
    if (reservationLink && !reservationLink.querySelector('i')) {
        // إنشاء أيقونة جديدة وإضافتها
        const icon = document.createElement('i');
        icon.className = 'fas fa-calendar-alt';
        
        // إضافة الأيقونة في بداية الرابط
        reservationLink.insertBefore(icon, reservationLink.firstChild);
        
        // إضافة كلاس menu-item للرابط
        reservationLink.className = 'menu-item';
        
        // وضع النص داخل عنصر span
        const text = reservationLink.innerHTML.replace(/<i.*?<\/i>/, '');
        let newHtml = reservationLink.innerHTML.replace(text, `<span>${text}</span>`);
        
        // التأكد من عدم وجود span مزدوج
        newHtml = newHtml.replace(/<span><span>/g, '<span>').replace(/<\/span><\/span>/g, '</span>');
        reservationLink.innerHTML = newHtml;
    }
    
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    
    // تحديد عناصر القائمة
    const menuItems = document.querySelectorAll('.menu-item');
    
    if (sidebarToggle && sidebar && mainContent) {
        // تغيير أيقونة الزر من الثلاث شحطات إلى أيقونة أخرى
        const toggleIcon = sidebarToggle.querySelector('i');
        if (toggleIcon) {
            toggleIcon.className = 'fas fa-chevron-left'; // استخدام أيقونة سهم بدلاً من الشحطات
        }
        
        // نقل زر التبديل خارج الشريط الجانبي إذا كان الشريط مخفياً عند تحميل الصفحة
        if (sidebar.classList.contains('sidebar-collapsed')) {
            sidebarToggle.classList.add('toggle-outside');
            toggleIcon.className = 'fas fa-chevron-right';
        }
        
        // حدث النقر على زر التبديل
        sidebarToggle.addEventListener('click', function() {
            toggleSidebar();
        });
    }
    
    // دالة لتبديل حالة الشريط الجانبي
    function toggleSidebar() {
        sidebar.classList.toggle('sidebar-collapsed');
        mainContent.classList.toggle('main-content-expanded');
        
        // تغيير أيقونة الزر بين سهم لليسار وسهم لليمين
        // وتحريك الزر خارج/داخل الـ sidebar
        const icon = sidebarToggle.querySelector('i');
        if (icon) {
            if (sidebar.classList.contains('sidebar-collapsed')) {
                icon.className = 'fas fa-chevron-right';
                sidebarToggle.classList.add('toggle-outside');
            } else {
                icon.className = 'fas fa-chevron-left';
                sidebarToggle.classList.remove('toggle-outside');
            }
        }
    }

    // Tab navigation for content sections
    const contentTabs = document.querySelectorAll('.content-tab');

    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            const targetSection = this.getAttribute('data-section');
            if (!targetSection) return; // نتجاهل إذا لم يكن هناك data-section

            // Remove active class from all menu items
            menuItems.forEach(item => item.classList.remove('active'));
            // Add active class to clicked menu item
            this.classList.add('active');

            // Hide all content tabs
            contentTabs.forEach(tab => {
                tab.style.display = 'none';
            });

            // Show the target content tab
            const targetTab = document.getElementById(targetSection);
            if (targetTab) {
                targetTab.style.display = 'block';
            }
        });
    });

    // Modal functionality
    const addOrderBtn = document.getElementById('add-order-btn');
    const addOrderBtn2 = document.getElementById('add-order-btn-2');
    const addOrderModal = document.getElementById('add-order-modal');
    const closeOrderModal = document.getElementById('close-order-modal');

    const addReservationBtn = document.getElementById('add-reservation-btn');
    const addReservationBtn2 = document.getElementById('add-reservation-btn-2');
    const addReservationModal = document.getElementById('add-reservation-modal');
    const closeReservationModal = document.getElementById('close-reservation-modal');

    const addMenuItemBtn = document.getElementById('add-menu-item-btn');
    const addMenuItemModal = document.getElementById('add-menu-item-modal');
    const closeMenuItemModal = document.getElementById('close-menu-item-modal');

    // Order Modal
    if (addOrderBtn && addOrderModal && closeOrderModal) {
        addOrderBtn.addEventListener('click', function() {
            addOrderModal.style.display = 'flex';
        });

        if (addOrderBtn2) {
            addOrderBtn2.addEventListener('click', function() {
                addOrderModal.style.display = 'flex';
            });
        }

        closeOrderModal.addEventListener('click', function() {
            addOrderModal.style.display = 'none';
        });
    }

    // Reservation Modal
    if (addReservationBtn && addReservationModal && closeReservationModal) {
        addReservationBtn.addEventListener('click', function() {
            addReservationModal.style.display = 'flex';
        });

        if (addReservationBtn2) {
            addReservationBtn2.addEventListener('click', function() {
                addReservationModal.style.display = 'flex';
            });
        }

        closeReservationModal.addEventListener('click', function() {
            addReservationModal.style.display = 'none';
        });
    }

    // Menu Item Modal
    if (addMenuItemBtn && addMenuItemModal && closeMenuItemModal) {
        addMenuItemBtn.addEventListener('click', function() {
            addMenuItemModal.style.display = 'flex';
        });

        closeMenuItemModal.addEventListener('click', function() {
            addMenuItemModal.style.display = 'none';
        });
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (addOrderModal && event.target === addOrderModal) {
            addOrderModal.style.display = 'none';
        }
        if (addReservationModal && event.target === addReservationModal) {
            addReservationModal.style.display = 'none';
        }
        if (addMenuItemModal && event.target === addMenuItemModal) {
            addMenuItemModal.style.display = 'none';
        }
    });

    // Tab navigation for menu item form
    const tabItems = document.querySelectorAll('.tab-item');
    const tabContents = document.querySelectorAll('.tab-content');

    tabItems.forEach(item => {
        item.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            if (!targetTab) return;

            // Remove active class from all tab items
            tabItems.forEach(item => item.classList.remove('active'));
            // Add active class to clicked tab item
            this.classList.add('active');

            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.remove('active');
            });

            // Show the target tab content
            const targetContent = document.getElementById(targetTab);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
});
</script>
</body>
</html>
