@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

{{-- Header --}}
@include('layouts.partials.header')

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Our Gallery</h2>
        <div class="mb-4 text-center">
            <button class="btn btn-outline-dark me-2 filter-btn active" data-filter="all">All</button>
            <button class="btn btn-outline-warning me-2 filter-btn" data-filter="restaurant">Restaurant</button>
            <button class="btn btn-outline-success filter-btn" data-filter="food">Food</button>
        </div>
        

        @if ($galleries->count())
            <div class="row" id="gallery-container">
                @foreach ($galleries as $gallery)
                    <div class="col-md-4 mb-4 gallery-item" data-type="{{ $gallery->type }}">
                        <div class="card shadow border-0 rounded-4 overflow-hidden">
                            <div class="ratio ratio-4x3">
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="Gallery Image">

                            </div>
                            <div class="card-body text-center">
                                <span class="badge bg-dark text-white text-capitalize px-3 py-2"
                                    style="font-size: 14px;">
                                    {{ $gallery->type }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">No images found yet.</p>
        @endif
    </div>
</section>
 
{{-- Footer --}}
@include('layouts.partials.footer')

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    const type = item.getAttribute('data-type');
                    if (filter === 'all' || type === filter) {
                        item.classList.remove('d-none');
                    } else {
                        item.classList.add('d-none');
                    }
                });

                // تفعيل الزر المحدد
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    });
</script>
