@extends('layouts.app')

@section('title', 'Home')

@section('styles')
<style>
  .stars {
    color: #ffbe33;
    font-size: 20px;
  }

  .testimonial-message {
    font-style: italic;
    margin-bottom: 10px;
  }

  .testimonial-name {
    font-weight: bold;
    color: #222831;
    margin-top: 10px;
  }
</style>
@endsection

@section('content')

{{-- Header --}}
@include('layouts.partials.header')

{{-- Slider --}}
@include('layouts.partials.slider')

{{-- Offer Section --}}
@include('layouts.partials.offer-section')

{{-- Food Section --}}
@include('layouts.partials.food-section')


{{-- Testimonial Form --}}
@include('layouts.partials.testimonial-form')

@if(isset($approvedTestimonials) && $approvedTestimonials->count() > 0)
    @include('layouts.partials.testimonials')
@endif

{{-- Footer --}}
@include('layouts.partials.footer')

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('show_success_popup'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Order Confirmed!',
        text: 'Your request has been sent successfully! For inquiries, call 0796990562',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ffbe33',
    });
</script>
@endif
@endsection

