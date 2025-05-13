<section class="book_section layout_padding text-center">
  <div class="container">
    <div class="heading_container heading_center mb-5">
      <h2>Leave Your Feedback</h2>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="{{ route('testimonials.store') }}" method="POST" class="text-center">
          @csrf
          <div class="form-group">
            <input type="text" name="customer_name" class="form-control text-center" placeholder="Your Name" required>
          </div>

          <div class="form-group">
            <textarea name="message" class="form-control text-center" rows="5" placeholder="Your Testimonial" required></textarea>
          </div>

          <div class="btn_box text-center mt-4">
            <button type="submit" class="btn btn-warning">
              Submit Feedback
            </button>
          </div>
        </form>
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
      <audio id="notifSound" src="{{ asset('sounds/mixkit-confirmation-tone-2867.wav') }}" autoplay></audio>
  </div>

  <script>
    window.addEventListener('DOMContentLoaded', () => {
        const msg = document.getElementById("successMessage");
        const progressBar = document.getElementById("progressBar");
        let width = 100;

        msg.style.opacity = 1;
        msg.style.transform = "translateY(0)";

        const interval = setInterval(() => {
            width -= 1.67; // 100% ÷ 60 خطوة ≈ 3 ثواني
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


      </div>
    </div>
  </div>
</section>
