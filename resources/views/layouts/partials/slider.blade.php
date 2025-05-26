<!-- CSS -->
<style>
  .carousel-indicators li {
    background-color: #ffbe33;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    transition: width 0.3s ease;
  }
  .carousel-indicators .active {
    width: 20px;
    background-color: #e69c00;
  }

  .carousel-item {
    min-height: 400px;
  }

  .hero-slide {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
  }

  .overlay {
    position: absolute;
    top: 0; left: 0;
    height: 100%; width: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
  }

  .detail-box {
    position: relative;
    z-index: 2;
    color: white;
  }

  .detail-box h1 { font-size: 48px; font-weight: 700; margin-bottom: 20px; }
  .detail-box p { font-size: 18px; line-height: 1.6; margin-bottom: 25px; }

  .btn1 {
    background-color: #ffbe33;
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s ease;
  }

  .btn1:hover {
    background-color: #e69c00;
  }

  @media (max-width: 768px) {
    .hero-slide { height: 70vh; }
    .detail-box h1 { font-size: 28px; }
    .detail-box p { font-size: 15px; }
    .btn1 { padding: 10px 25px; font-size: 14px; }
  }
</style>

<!-- HTML -->
<section class="slider_section">
  <div id="customCarousel1" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="hero-slide" style="background-image: url('{{ asset('images/lemongrass-s-4251-jpg20130703-15384-2j4hkh_original.jpg') }}')">
          <div class="overlay"></div>
          <div class="container">
            <div class="detail-box col-md-7 col-lg-6">
              <h1>{{ __('messages.slide_1_title') }}</h1>
              <p>{{ __('messages.slide_1_text') }}</p>
              <div class="btn-box">
                <a href="{{ route('menu') }}" class="btn1">{{ __('messages.order_now') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <div class="hero-slide" style="background-image: url('{{ asset('images/lemongrass-s-4251-jpg20130703-15384-2j4hkh_original.jpg') }}')">
          <div class="overlay"></div>
          <div class="container">
            <div class="detail-box col-md-7 col-lg-6">
              <h1>{{ __('messages.slide_2_title') }}</h1>
              <p>{{ __('messages.slide_2_text') }}</p>
              <div class="btn-box">
                <a href="{{ route('menu') }}" class="btn1">{{ __('messages.order_now') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <div class="hero-slide" style="background-image: url('{{ asset('images/lemongrass-s-4251-jpg20130703-15384-2j4hkh_original.jpg') }}')">
          <div class="overlay"></div>
          <div class="container">
            <div class="detail-box col-md-7 col-lg-6">
              <h1>{{ __('messages.slide_3_title') }}</h1>
              <p>{{ __('messages.slide_3_text') }}</p>
              <div class="btn-box">
                <a href="{{ route('menu') }}" class="btn1">{{ __('messages.order_now') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Indicators -->
    <div class="container">
      <ol class="carousel-indicators">
        <li data-bs-target="#customCarousel1" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#customCarousel1" data-bs-slide-to="1"></li>
        <li data-bs-target="#customCarousel1" data-bs-slide-to="2"></li>
      </ol>
    </div>
  </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
