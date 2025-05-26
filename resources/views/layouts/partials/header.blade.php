
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
/* ===========================================
   HEADER SECTION - تحسينات شاملة مع تقليل المسافات
=========================================== */
.header_section {
    padding: 0;
    min-height: 65px; /* تقليل الارتفاع من 80px إلى 65px */
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* ===========================================
   NAVBAR CONTAINER - مع تقليل المسافات
=========================================== */
.custom_nav-container {
    min-height: 65px; /* تقليل الارتفاع */
    padding: 5px 0; /* تقليل الـ padding من 10px إلى 5px */
}

.custom_nav-container .navbar-nav {
    align-items: center;
    gap: 5px; /* تقليل المسافة بين العناصر من 10px إلى 5px */
}

.custom_nav-container .nav-item .nav-link {
    color: #ffffff;
    font-weight: 600;
    text-transform: uppercase;
    padding: 6px 12px; /* تقليل الـ padding من 8px 16px إلى 6px 12px */
    border-radius: 20px; /* تقليل نصف القطر قليلاً */
    transition: all 0.3s ease;
    font-size: 13px; /* تقليل حجم الخط قليلاً */
    letter-spacing: 0.3px; /* تقليل المسافة بين الأحرف */
}

.custom_nav-container .nav-item:hover .nav-link,
.custom_nav-container .nav-item.active .nav-link {
    color: #000;
    background-color: #ffbe33;
    transform: translateY(-2px);
}

/* ===========================================
   LOGO SECTION - الحفاظ على حجم اللوغو مع تقليل المسافات
=========================================== */
.navbar-brand {
    padding: 5px 0 !important; /* تقليل الـ padding من 8px إلى 5px */
    display: flex !important;
    align-items: center !important;
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    transform: scale(1.02);
}

.main-logo {
    height: 70px; /* الحفاظ على حجم اللوغو */
    max-height: 70px;
    width: auto;
    object-fit: contain;
    transition: all 0.3s ease;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    filter: contrast(1.1) brightness(1.05) drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.logo-text {
    font-size: 32px; /* الحفاظ على حجم النص */
    font-weight: bold;
    color: #ffbe33;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    letter-spacing: 1px;
}

.tagline-style {
    font-size: 10px; /* تقليل حجم النص الفرعي قليلاً */
    color: #bbb;
    margin-top: 1px; /* تقليل المسافة */
    margin-left: 5px;
    font-weight: 300;
    line-height: 1;
    letter-spacing: 0.3px;
    font-style: italic;
}

/* ===========================================
   FLOATING CART - محسن
=========================================== */
.floating-cart {
    position: fixed;
    bottom: 25px;
    left: 25px;
    background: linear-gradient(135deg, #212529 0%, #343a40 100%);
    color: #ffffff;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    z-index: 1050;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 3px solid rgba(255, 190, 51, 0.3);
}

.floating-cart:hover {
    background: linear-gradient(135deg, #ffbe33 0%, #f0ad4e 100%);
    color: #000;
    transform: scale(1.1) translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 190, 51, 0.4);
    border-color: #ffbe33;
}

.floating-cart i {
    font-size: 1.8rem;
    transition: transform 0.3s ease;
}

.floating-cart:hover i {
    transform: rotate(15deg);
}

.floating-cart .cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #ffbe33 0%, #f0ad4e 100%);
    color: #000;
    border-radius: 50%;
    font-size: 0.75rem;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border: 2px solid #212529;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* ===========================================
   DROPDOWN MENUS
=========================================== */
.dropdown-menu.bg-dark {
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    border-radius: 12px;
    overflow: hidden;
}

.dropdown-menu.bg-dark .dropdown-item {
    color: #ffffff;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 8px 16px; /* تقليل الـ padding */
}

.dropdown-menu.bg-dark .dropdown-item:hover,
.dropdown-menu.bg-dark .dropdown-item:focus {
    background-color: #ffbe33;
    color: #000;
    transform: translateX(5px);
}

/* ===========================================
   LANGUAGE SWITCHER - مع تقليل المسافات
=========================================== */
.language-switcher {
    display: flex;
    gap: 3px; /* تقليل المسافة من 5px إلى 3px */
    margin: 0 8px; /* تقليل الهامش من 10px إلى 8px */
}

.language-switcher a {
    padding: 4px 10px; /* تقليل الـ padding من 6px 12px */
    background-color: transparent;
    border: 2px solid #ffbe33;
    color: #ffbe33;
    font-weight: bold;
    border-radius: 18px; /* تقليل نصف القطر */
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 11px; /* تقليل حجم الخط */
    letter-spacing: 0.3px;
}

.language-switcher a.active,
.language-switcher a:hover {
    background-color: #ffbe33;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 190, 51, 0.3);
}

/* ===========================================
   RESPONSIVE DESIGN - مع الحفاظ على حجم اللوغو وتقليل المسافات
=========================================== */

/* Large screens (1200px+) */
@media (min-width: 1200px) {
    .header_section {
        min-height: 70px; /* تقليل الارتفاع */
    }
    
    .custom_nav-container {
        min-height: 70px;
        padding: 8px 0; /* تقليل الـ padding */
    }
    
    .main-logo {
        height: 75px; /* الحفاظ على حجم كبير للوغو */
        max-height: 75px;
    }
    
    .logo-text {
        font-size: 36px;
    }
    
    .custom_nav-container .nav-item .nav-link {
        font-size: 14px;
        padding: 8px 16px;
    }
}

/* Medium screens (768px - 1199px) */
@media (min-width: 768px) and (max-width: 1199.98px) {
    .header_section {
        min-height: 68px;
    }
    
    .custom_nav-container {
        min-height: 68px;
        padding: 6px 0;
    }
    
    .main-logo {
        height: 72px; /* الحفاظ على حجم جيد للوغو */
        max-height: 72px;
    }
    
    .logo-text {
        font-size: 34px;
    }
    
    .custom_nav-container .navbar-nav {
        gap: 4px; /* تقليل المسافة أكثر */
    }
}

/* Small screens (576px - 767px) */
@media (min-width: 576px) and (max-width: 767.98px) {
    .header_section {
        min-height: 60px;
    }
    
    .custom_nav-container {
        padding: 4px 0;
    }
    
    .main-logo {
        height: 60px; /* الحفاظ على حجم معقول للوغو */
        max-height: 60px;
    }
    
    .logo-text {
        font-size: 28px;
    }
    
    .floating-cart {
        width: 55px;
        height: 55px;
        bottom: 20px;
        left: 20px;
    }
    
    .floating-cart i {
        font-size: 1.5rem;
    }
}

/* Extra small screens (تحت 576px) */
@media (max-width: 575.98px) {
    .header_section {
        min-height: 55px; /* تقليل الارتفاع أكثر */
    }
    
    .custom_nav-container {
        min-height: 55px;
        padding: 3px 0; /* تقليل الـ padding أكثر */
    }
    
    .main-logo {
        height: 50px; /* الحفاظ على حجم مناسب للوغو */
        max-height: 50px;
    }
    
    .logo-text {
        font-size: 26px;
    }
    
    .tagline-style {
        font-size: 8px;
    }
    
    .floating-cart {
        width: 50px;
        height: 50px;
        bottom: 15px;
        left: 15px;
    }
    
    .floating-cart i {
        font-size: 1.3rem;
    }
    
    .floating-cart .cart-badge {
        width: 22px;
        height: 22px;
        font-size: 0.7rem;
        top: -6px;
        right: -6px;
    }
}

/* ===========================================
   MOBILE MENU ENHANCEMENTS - مع تقليل المسافات
=========================================== */
@media (max-width: 991.98px) {
    .custom_nav-container .navbar-collapse {
        position: fixed;
        top: 65px; /* تحديث الموضع ليتوافق مع الارتفاع الجديد */
        left: 0;
        width: 100%;
        background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        padding: 15px; /* تقليل الـ padding من 20px */
        z-index: 1000;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        border-radius: 0 0 20px 20px;
    }
    
    .custom_nav-container .navbar-nav {
        gap: 10px; /* تقليل المسافة من 15px */
    }
    
    .main-menu-items {
        width: 100%;
        margin-bottom: 15px; /* تقليل المسافة من 20px */
    }
    
    .main-menu-items .nav-item {
        width: 100%;
        text-align: center;
        margin-bottom: 6px; /* تقليل المسافة من 8px */
    }
    
    .main-menu-items .nav-link {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 12px; /* تقليل نصف القطر */
        padding: 10px 18px; /* تقليل الـ padding قليلاً */
        margin: 0 8px; /* تقليل الهامش */
        backdrop-filter: blur(10px);
    }
    
    .mobile-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px; /* تقليل المسافة من 15px */
        padding-top: 12px; /* تقليل الـ padding */
        border-top: 2px solid rgba(255, 190, 51, 0.3);
        width: 100%;
    }
    
    .dropdown-menu {
        position: static !important;
        float: none;
        width: 100%;
        margin-top: 8px; /* تقليل المسافة */
        text-align: center;
        background: rgba(0,0,0,0.8) !important;
        backdrop-filter: blur(10px);
        border-radius: 12px; /* تقليل نصف القطر */
    }
    
    .navbar-toggler {
        border: 2px solid #ffbe33;
        border-radius: 6px; /* تقليل نصف القطر */
        padding: 4px 8px; /* تقليل الـ padding */
        transition: all 0.3s ease;
    }
    
    .navbar-toggler:hover {
        background-color: #ffbe33;
        transform: scale(1.05);
    }
    
    .navbar-toggler:hover i {
        color: #000 !important;
    }
}

form.d-flex input {
    border-radius: 20px;
    padding: 6px 12px;
}

/* تمييز العنصر المختار من البحث */
.highlight-search-result {
    background: linear-gradient(45deg, #ffeb3b, #ffc107) !important;
    border: 2px solid #ff9800 !important;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4) !important;
    transform: scale(1.02) !important;
    transition: all 0.3s ease !important;
    border-radius: 8px !important;
    position: relative !important;
    z-index: 10 !important;
}

/* تحسين مربع اقتراحات البحث */
#search-suggestions {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    background: white;
    position: absolute;
    z-index: 1000;
    width: 100%;
}

#search-suggestions .list-group-item {
    border: none;
    border-bottom: 1px solid #f0f0f0;
    padding: 12px 16px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

#search-suggestions .list-group-item:hover {
    background-color: #fff8e1;
    color: #f57f17;
}

#search-suggestions .list-group-item:last-child {
    border-bottom: none;
    border-radius: 0 0 8px 8px;
}

#search-suggestions .list-group-item:first-child {
    border-radius: 8px 8px 0 0;
}

/* للتأكد من أن العنصر واضح حتى لو كان مخفي جزئياً */
.menu-item.highlight-search-result {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* ===========================================
   PRODUCT CARD QUICK ADD
=========================================== */
.product-card {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.quick-add-btn {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ffbe33 0%, #f0ad4e 100%);
    color: #000;
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    opacity: 0;
    transform: translateY(20px) scale(0.8);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 10;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(255, 190, 51, 0.4);
}

.product-card:hover .quick-add-btn {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.quick-add-btn:hover {
    background: linear-gradient(135deg, #f0ad4e 0%, #e6a043 100%);
    transform: scale(1.1) rotate(15deg);
    box-shadow: 0 6px 20px rgba(255, 190, 51, 0.6);
}

/* ===========================================
   TOAST NOTIFICATIONS
=========================================== */
#toast-container {
    z-index: 1100;
}

.toast {
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

/* ===========================================
   ANIMATIONS & EFFECTS
=========================================== */
@keyframes slideInFromTop {
    0% {
        transform: translateY(-100%);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.header_section {
    animation: slideInFromTop 0.6s ease-out;
}

@keyframes fadeInUp {
    0% {
        transform: translateY(30px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.navbar-nav .nav-item {
    animation: fadeInUp 0.6s ease-out forwards;
}

.navbar-nav .nav-item:nth-child(1) { animation-delay: 0.1s; }
.navbar-nav .nav-item:nth-child(2) { animation-delay: 0.2s; }
.navbar-nav .nav-item:nth-child(3) { animation-delay: 0.3s; }
.navbar-nav .nav-item:nth-child(4) { animation-delay: 0.4s; }
.navbar-nav .nav-item:nth-child(5) { animation-delay: 0.5s; }


/* تقارب زر الدخول وزر القائمة */
@media (max-width: 991.98px) {
    .navbar-toggler {
        margin: 0;
    }

    .header_section .btn-sm {
        padding: 6px 12px;
        font-size: 14px;
    }

    .d-lg-none.d-flex.align-items-center {
        gap: 6px; /* تقليل المسافة بينهم */
    }
    @media (max-width: 991.98px) {
  .mobile-login-only {
    display: none !important;
  }
}

}

</style>

<header class="header_section bg-dark">
  <div class="container-fluid px-4">
    <nav class="navbar navbar-expand-lg custom_nav-container justify-content-between">
      <!-- Logo -->
@php
    $logo = setting('logo');
@endphp

<a class="navbar-brand fw-bold d-flex align-items-center py-2" href="{{ route('home') }}">
    @if($logo)
        <img src="{{ asset('storage/' . $logo) }}"  
             alt="Lemongrass Restaurant Logo" 
             class="main-logo"
             loading="lazy"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
        <span class="logo-text d-none">Lemongrass
            <div class="tagline-style">Asian Fusion</div>
        </span>
    @else
        <span class="logo-text">Lemongrass
            <div class="tagline-style">Asian Fusion</div>
        </span>
    @endif
</a>

<!-- ✅ تجميع زر التوغل + زر تسجيل الدخول بجانب بعض -->
<div class="d-lg-none d-flex align-items-center gap-2 ms-auto">
    <!-- زر تسجيل الدخول -->
    @if(session()->has('customer_id'))
        @php
            $customer = \App\Models\User::find(session('customer_id'));
        @endphp
        <a href="{{ route('my_orders') }}" class="btn btn-sm btn-outline-light">
            {{ explode(' ', $customer->name ?? 'Guest')[0] }}
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-sm btn-warning fw-semibold">
            <i class="fas fa-sign-in-alt me-1"></i> {{ __('messages.login') }}
        </a>
    @endif

    <!-- زر القائمة ☰ -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars text-white fs-4"></i>
    </button>
</div>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Main Menu Items -->
        <ul class="navbar-nav main-menu-items mx-auto">
          <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a>
          </li>
          <li class="nav-item {{ Request::is('menu') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('menu') }}">{{ __('messages.menu') }}</a>
          </li>
          <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('gallery') }}">{{ __('messages.gallery') }}</a>
          </li>
          <li class="nav-item {{ Request::is('reservation') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('reservation') }}">{{ __('messages.reservation') }}</a>
          </li>
          <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('contact') }}">{{ __('messages.contact') }}</a>
          </li>
        </ul>
        @php
          $cartCount = collect(session('cart', []))->sum('quantity');
        @endphp

        <!-- Right-side Actions (User, Language) -->
        <ul class="navbar-nav mobile-actions">
          <!-- User Account -->
          @if(session()->has('customer_id'))
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fas fa-user-circle me-1"></i>
                  {{ explode(' ', \App\Models\User::find(session('customer_id'))->name ?? 'Guest')[0] }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end bg-dark border-0 shadow">
                  <li><a class="dropdown-item" href="{{ route('my_orders') }}">{{ __('messages.my_orders') }}</a></li>
                  <li><a class="dropdown-item" href="{{ route('logout') }}">{{ __('messages.logout') }}</a></li>
                </ul>
              </li>
          @else
          <li class="nav-item">
            <a class="nav-link text-white fw-semibold" href="{{ route('login') }}">
              <i class="fas fa-sign-in-alt me-1"></i> {{ __('messages.login') }}
            </a>
          </li>
          @endif

          <!-- Language Switcher -->
          <li class="nav-item language-switcher d-flex">
            <a href="{{ route('set.language', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('set.language', 'ar') }}" class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
          </li>
        </ul>
      </div>
    </nav>
    <div id="searchResultsContainer" class="container position-absolute bg-white rounded shadow-sm border px-3 py-3"
        style="top: 75px; left: 50%; transform: translateX(-50%); z-index: 2000; display: none; max-height: 70vh; overflow-y: auto; width: 90%;">
    </div>
  </div>
</header>

<!-- Floating Cart -->
<a href="{{ route('cart.index') }}" class="floating-cart">
  <i class="fa fa-shopping-cart"></i>
  <span id="floating-cart-count" class="cart-badge {{ $cartCount > 0 ? 'show' : '' }}">
    {{ $cartCount }}
  </span>
</a>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

  // Fix for toggle button
  const navbarToggler = document.querySelector('.navbar-toggler');
  const navCollapse = document.getElementById('navbarSupportedContent');
  
  // Manual toggle handler (fixes the toggle button issue)
  navbarToggler.addEventListener('click', function() {
    if (navCollapse.classList.contains('show')) {
      // If already open, close it
      bootstrap.Collapse.getInstance(navCollapse).hide();
    } else {
      // If closed, open it
      bootstrap.Collapse.getInstance(navCollapse) || new bootstrap.Collapse(navCollapse, { toggle: true });
    }
  });
  
  // Close menu when clicking nav items (except dropdowns)
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      if (window.innerWidth < 992 && navCollapse.classList.contains('show')) {
        bootstrap.Collapse.getInstance(navCollapse).hide();
      }
    });
  });
  
  // Hide the cart in navbar since we now have floating cart
  document.querySelector('.nav-item.cart-icon')?.classList.add('d-none');
  
  // Current cart count from session
  let currentCartCount = {{ $cartCount ?? 0 }};
  
  // Function to update cart count display
function updateCartCount(count) {
    document.querySelectorAll('.cart-badge').forEach(el => {
        el.textContent = count;
        if (count > 0) {
            el.classList.add('show', 'pulse');
        } else {
            el.classList.remove('show');
        }

        setTimeout(() => {
            el.classList.remove('pulse');
        }, 500);
    });
}

  
  // Listen for cart updates from add-to-cart buttons
  document.addEventListener('cartUpdated', function(e) {
    // Update with the new count from the event
    currentCartCount = e.detail.count;
    updateCartCount(currentCartCount);
  });
  
  // Intercept all "Add to Cart" form submissions
  document.addEventListener('click', function(e) {
    // Find clicked button that adds to cart
    if (e.target && (
        e.target.classList.contains('add-to-cart-btn') || 
        e.target.closest('.add-to-cart-btn')
      )) {
      
      const addToCartBtn = e.target.classList.contains('add-to-cart-btn') ? 
                          e.target : 
                          e.target.closest('.add-to-cart-btn');
      
      // Find the closest form if button is within a form
      const form = addToCartBtn.closest('form');
      
      if (form && form.getAttribute('action').includes('cart')) {
        // It's an add-to-cart form, let's handle it
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        
        // Send AJAX request
        fetch(form.getAttribute('action'), {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          // Update cart count without page refresh
          if (data.success) {
            // Get quantity being added (default to 1)
            const addedQty = parseInt(formData.get('quantity') || 1);
            
            // Update cart count
            currentCartCount += addedQty;
            
            // Update UI
            updateCartCount(currentCartCount);
            
            // Show success message
            if (data.message) {
              // Create toast notification
              showToast(data.message, 'success');
            }
          } else if (data.error) {
            // Show error
            showToast(data.error, 'danger');
          }
        })
        .catch(error => {
          console.error('Error adding to cart:', error);
          showToast('حدث خطأ أثناء إضافة المنتج إلى السلة', 'danger');
        });
      }
    }
  });
  
  // Add quick add buttons directly on product cards
  document.querySelectorAll('.product-card').forEach(card => {
    // Only add quick-add if it doesn't already exist
    if (!card.querySelector('.quick-add-btn')) {
      const productId = card.dataset.productId;
      if (productId) {
        const quickAddBtn = document.createElement('button');
        quickAddBtn.className = 'quick-add-btn';
        quickAddBtn.innerHTML = '<i class="fas fa-cart-plus"></i>';
        quickAddBtn.title = 'إضافة سريعة للسلة';
        
        quickAddBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          // AJAX call to add product with quantity 1
          fetch('/cart/add', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
              product_id: productId,
              quantity: 1
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Increment cart count
              currentCartCount++;
              updateCartCount(currentCartCount);
              showToast('تمت إضافة المنتج إلى السلة', 'success');
            } else {
              showToast(data.error || 'حدث خطأ أثناء إضافة المنتج', 'danger');
            }
          });
        });
        
        card.appendChild(quickAddBtn);
      }
    }
  });
  
  // Toast notification function
  function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
      toastContainer = document.createElement('div');
      toastContainer.id = 'toast-container';
      toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
      toastContainer.style.zIndex = '1100';
      document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.id = toastId;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    // Toast content
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;
    
    // Add to container
    toastContainer.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
      animation: true,
      autohide: true,
      delay: 3000
    });
    bsToast.show();
    
    // Remove from DOM after hidden
    toast.addEventListener('hidden.bs.toast', function() {
      toast.remove();
    });
  }
});
</script>