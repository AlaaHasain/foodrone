<style> 
  .testimonial-grid { 
    display: flex; 
    flex-wrap: wrap; 
    gap: 20px; 
    justify-content: center; 
    margin-top: 30px; 
  } 
 
  .testimonial-card { 
    background: #222831; 
    border: 1px solid #ffe0a3; 
    border-radius: 12px; 
    padding: 20px; 
    width: 100%; 
    max-width: 300px; 
    box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
    text-align: center; 
    transition: 0.3s; 
  } 
 
  .testimonial-card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
  } 
 
  .testimonial-message { 
    font-style: italic; 
    margin-bottom: 15px; 
    color: #ffffff; /* Changed to white for better visibility */
  } 
 
  .testimonial-name { 
    font-weight: bold; 
    color: #ffe0a3; /* Changed to gold color to match border */
    margin-top: 10px; 
    font-size: 1.1rem; /* Slightly larger font size */
  } 
 
  .stars { 
    color: #ffbe33; 
    font-size: 18px; 
  } 
</style> 
 
<section class="client_section layout_padding"> 
  <div class="container"> 
    <div class="heading_container heading_center"> 
      <h2>{{ __('messages.what_customers_say') }}</h2> 
    </div> 
 
    @if(isset($approvedTestimonials) && $approvedTestimonials->count()) 
      <div class="testimonial-grid"> 
        @foreach($approvedTestimonials->take(5) as $testimonial) 
          <div class="testimonial-card"> 
            <p class="testimonial-message">"{{ $testimonial->message }}"</p> 
            <div class="stars mb-2"> 
              @for ($i = 0; $i < 5; $i++) 
                <i class="fa fa-star" aria-hidden="true"></i> 
              @endfor 
            </div> 
            <h5 class="testimonial-name">{{ $testimonial->customer_name }}</h5> 
          </div> 
        @endforeach 
      </div> 
    @else 
      <p class="text-center mt-4">{{ __('messages.no_testimonials') }}</p>
    @endif 
  </div> 
</section>