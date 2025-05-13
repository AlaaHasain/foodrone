@if(session('success')) 
<div id="successMessage" style="
position: fixed;
top: 20px;
right: 20px;
background: #ffc107;
color: #333;
padding: 15px 25px;
border-radius: 10px;
font-size: 16px;
font-weight: 500;
box-shadow: 0 4px 12px rgba(0,0,0,0.15);
z-index: 9999;
opacity: 0;
transform: translateY(-20px);
transition: all 0.4s ease;
width: fit-content;
max-width: 300px;
">
    <span style="margin-right: 10px;">✅</span> 
    <span>{{ session('success') }}</span> 
    <div style="overflow: hidden; border-radius: 5px; margin-top: 8px;">
        <div id="progressBar" style="bottom: 0; left: 0; height: 4px; background: rgba(255, 255, 255, 0.7); width: 100%; transition: width 0.1s linear;"></div>
    </div> 
</div> 

<audio id="contactSound" src="{{ asset('sounds/mixkit-confirmation-tone-2867.wav') }}"></audio>
 
<script> 
    window.addEventListener('DOMContentLoaded', () => { 
        const msg = document.getElementById("successMessage"); 
        const progressBar = document.getElementById("progressBar");
        const contactSound = document.getElementById("contactSound");
        let width = 100; 
 
        msg.style.opacity = 1; 
        msg.style.transform = "translateY(0)"; 
        
        // Play the sound
        contactSound.play().catch(err => {
            console.log("Audio playback failed:", err);
        });
 
        const interval = setInterval(() => { 
            width -= 1.67; 
            progressBar.style.width = width + "%"; 
            if (width <= 0) { 
                clearInterval(interval); 
                msg.style.opacity = 0; 
                msg.style.transform = "translateY(-20px)"; 
                setTimeout(() => msg.remove(), 300); 
            } 
        }, 50); 
    }); 
</script> 
@endif 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<section class="contact_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Contact Us</h2>
    </div>

    <div class="row mt-5">
      <!-- الفورم -->
      <div class="col-lg-6 col-12 mb-4">
        <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
          @csrf
          <div class="form-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="form-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="form-group mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
          </div>
          <div class="form-group mb-3">
            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
          </div>
          <div class="btn_box text-center mt-4">
            <button type="submit" id="submitBtn" class="btn btn-warning">Send Message</button>
          </div>
        </form>
      </div>

      <!-- الخريطة -->
      <div class="col-lg-6 col-12 mb-4">
        <div class="ratio ratio-16x9 rounded shadow">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3384.865849304104!2d35.907002299999995!3d31.964535899999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca1f60c004967%3A0x59ef904d876cb622!2sLemongrass%20Thai%20Restaurant!5e0!3m2!1sar!2sjo!4v1745750112282!5m2!1sar!2sjo" 
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>
