<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .custom_nav-container .navbar-nav {
    flex-direction: row;
    gap: 3px; /* ✅ قللنا المسافة بين الروابط */
    align-items: center;
  }

  .custom_nav-container .nav-item .nav-link {
    color: #ffffff;
    font-weight: 600;
    text-transform: uppercase;
    padding: 4px 8px;
    transition: all 0.3s ease;
  }

  .custom_nav-container .nav-item:hover .nav-link,
  .custom_nav-container .nav-item.active .nav-link {
    color: #ffbe33;
  }

  .cart-icon {
    font-size: 1.4rem;
    position: relative;
    margin-left: auto;
  }

  .cart-badge {
    position: absolute;
    top: -8px;
    right: -10px;
    background-color: #ffbe33;
    color: #fff;
    border-radius: 50%;
    font-size: 0.7rem;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>

<header class="header_section bg-dark">
  <div class="container-fluid px-4">
    <nav class="navbar navbar-expand-lg custom_nav-container justify-content-between">
      {{-- ✅ الشعار في أقصى اليسار --}}
      <a class="navbar-brand text-white fw-bold me-auto" href="{{ route('home') }}">
        Lemongrass
      </a>

      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars fs-4"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        {{-- ✅ روابط الوسط --}}
        <ul class="navbar-nav mx-auto text-center">
          <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item {{ Request::is('menu') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('menu') }}">Menu</a>
          </li>
          <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('gallery') }}">Gallery</a>
          </li>
          <li class="nav-item {{ Request::is('reservation') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('reservation') }}">Reservation</a>
          </li>
          <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
          </li>
          <li class="nav-item {{ Request::is('my-orders') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('my_orders') }}">My Order</a>
          </li>
        </ul>

        {{-- ✅ السلة في أقصى اليمين --}}
        @php
        $cartCount = collect(session('cart', []))->sum('quantity');
    @endphp
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
          <i class="fa fa-shopping-cart"></i>
          <span id="cart-count" class="cart-count cart-badge {{ $cartCount > 0 ? 'show' : '' }}">
            {{ $cartCount }}
        </span>        
        </a>
      </li>
    </ul>
    
      </div>
    </nav>
  </div>
</header>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
