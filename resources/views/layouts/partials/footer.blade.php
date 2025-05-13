<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .footer_section {
    background: #222831;
    color: white;
    padding: 60px 0 20px;
    font-family: 'Poppins', sans-serif;
    
  }

  .footer_section h4 {
    color: #ffbe33;
    font-weight: 600;
    margin-bottom: 25px;
    font-size: 22px;
    position: relative;
    padding-bottom: 10px;
  }

  .footer_section h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background-color: #ffbe33;
  }

  .footer_section p {
    color: #f1f1f1;
    line-height: 1.8;
  }

  .footer_section .footer-logo {
    font-size: 28px;
    font-weight: bold;
    color: white;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 20px;
    letter-spacing: 1px;
  }

  .footer_section .footer-logo:hover,
  .footer_section .contact_link_box a:hover,
  .footer_section .footer_social a:hover,
  .footer_section .footer-info a:hover {
    color: #ffbe33;
    text-decoration: none;
  }

  .footer_section .contact_link_box a {
    display: flex;
    align-items: center;
    color: #f1f1f1;
    text-decoration: none;
    margin-bottom: 15px;
    transition: all 0.3s ease;
  }

  .footer_section .contact_link_box a i {
    width: 35px;
    height: 35px;
    background: rgba(255, 190, 51, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: #ffbe33;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .footer_section .contact_link_box a:hover i {
    background: #ffbe33;
    color: #fff;
  }

  /* Improved social media icons styling - Fixed */
  .footer_section .social_box {
    display: flex;
    justify-content: flex-start;
    margin-top: 10px;
    gap: 15px;
  }

  .footer_section .social_box a {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
  }

  .footer_section .social_box a:hover {
    background: #ffbe33;
  }

  .footer_section .social_box a i {
    color: #ffbe33;
    font-size: 18px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  
  .footer_section .social_box a:hover i {
    color: #222831;
  }

  .footer_section .footer-info {
    margin-top: 40px;
    padding-top: 20px;
    text-align: center;
    color: #f1f1f1;
    font-size: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  .footer_section .footer-info p {
    margin-bottom: 10px;
  }

  .opening-hours-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .opening-hours-list li {
    padding: 8px 0;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
  }

  .opening-hours-list li:last-child {
    border-bottom: none;
  }

  @media (max-width: 767px) {
    .footer-col {
      margin-bottom: 30px;
    }
    
    .footer_section .social_box {
    justify-content: flex-start !important;
  }
  }
</style>

@php
  // استرجاع بيانات الفوتر من قاعدة البيانات
  $footerInfo = \App\Models\FooterInfo::first();
@endphp

<footer class="footer_section">
  <div class="container">
    <div class="row">
      <!-- Contact Info + Social Links -->
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>Contact Us</h4>
          <div class="contact_link_box">
            @if($footerInfo && $footerInfo->address)
            <a href="https://maps.google.com/?q={{ urlencode($footerInfo->address) }}" target="_blank">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <span>{{ $footerInfo->address }}</span>
            </a>
            @else
            <a href="#">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <span>Amman, Boulevard Al-Abdali</span>
            </a>
            @endif
            
            @if($footerInfo && $footerInfo->phone)
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerInfo->phone) }}">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>{{ $footerInfo->phone }}</span>
            </a>
            @else
            <a href="tel:0796990562">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>0796990562</span>
            </a>
            @endif
            
            @if($footerInfo && $footerInfo->email)
            <a href="mailto:{{ $footerInfo->email }}">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>{{ $footerInfo->email }}</span>
            </a>
            @else
            <a href="mailto:alaahassain9@gmail.com">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>alaahassain9@gmail.com</span>
            </a>
            @endif
          </div>
        </div>
        
        <!-- Social Links Section -->
        <div class="footer_social_section" style="margin-top: 30px;">
          <h4>Social Links</h4>
          <div class="social_box">
            @if($footerInfo && $footerInfo->facebook)
            <a href="{{ $footerInfo->facebook }}" target="_blank" title="Facebook">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            @else
            <a href="https://facebook.com" target="_blank" title="Facebook">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            @endif
            
            @if($footerInfo && $footerInfo->whatsapp)
            <a href="{{ $footerInfo->whatsapp }}" target="_blank" title="WhatsApp">
              <i class="fa fa-whatsapp" aria-hidden="true"></i>
            </a>
            @else
            <a href="https://wa.me/962796990562" target="_blank" title="WhatsApp">
              <i class="fa fa-whatsapp" aria-hidden="true"></i>
            </a>
            @endif
            
            @if($footerInfo && $footerInfo->instagram)
            <a href="{{ $footerInfo->instagram }}" target="_blank" title="Instagram">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            @else
            <a href="https://instagram.com" target="_blank" title="Instagram">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            @endif
            
            @if($footerInfo && $footerInfo->twitter)
            <a href="{{ $footerInfo->twitter }}" target="_blank" title="Twitter">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            @endif
            
            @if($footerInfo && $footerInfo->youtube)
            <a href="{{ $footerInfo->youtube }}" target="_blank" title="YouTube">
              <i class="fa fa-youtube-play" aria-hidden="true"></i>
            </a>
            @endif
          </div>
        </div>
      </div>

      <!-- About Section (separate in the middle) -->
      <div class="col-md-4 footer-col">
        <div class="footer_detail">
          <a href="{{ route('home') }}" class="footer-logo">
            {{ setting('restaurant_name') }}
          </a>
          
          <h4>About Us</h4>
          @if($footerInfo && $footerInfo->about)
          <p>{{ $footerInfo->about }}</p>
          @else
          <p>Welcome to our restaurant. We offer a unique dining experience with delicious food and excellent service. Visit us today and enjoy our special dishes prepared by our talented chefs.</p>
          @endif
        </div>
      </div>

      <!-- Opening Hours -->
      <div class="col-md-4 footer-col">
        <h4>Opening Hours</h4>
        @if($footerInfo && $footerInfo->working_hours)
          @php
            $hours = nl2br($footerInfo->working_hours);
            if (strpos($hours, '<li>') === false) {
              // إذا لم تكن البيانات على شكل قائمة، نقوم بتحويلها
              $lines = explode('<br />', $hours);
              echo '<ul class="opening-hours-list">';
              foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) == 2) {
                  echo '<li><span>' . trim($parts[0]) . '</span><span>' . trim($parts[1]) . '</span></li>';
                } else {
                  echo '<li><span colspan="2">' . trim($line) . '</span></li>';
                }
              }
              echo '</ul>';
            } else {
              echo $hours;
            }
          @endphp
        @else
        <ul class="opening-hours-list">
          <li>
            <span>Monday - Friday</span>
            <span>8:00 AM - 10:00 PM</span>
          </li>
          <li>
            <span>Saturday - Sunday</span>
            <span>10:00 AM - 11:00 PM</span>
          </li>
        </ul>
        @endif
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-info">
      <p>
        &copy; <span id="displayYear"></span> 
        {{ $footerInfo && $footerInfo->copyright ? $footerInfo->copyright : setting('restaurant_name') . ' - All Rights Reserved' }}
      </p>
    </div>
  </div>
</footer>

<script>
  document.getElementById('displayYear').innerText = new Date().getFullYear();
</script>