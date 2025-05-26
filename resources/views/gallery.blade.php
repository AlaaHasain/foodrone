@extends('layouts.app')

@section('title', 'Gallery')

<style>
/* شبكة الصور */
#gallery-container {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
}

/* الكارد */
.gallery-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    background-color: #fff;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    animation: fadeInCard 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
    aspect-ratio: 1 / 1; /* ✅ مربع تمامًا، متجاوب */
    position: relative;
}

/* الصورة */
.gallery-card img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* ✅ تغطية متناسقة */
    display: block;
    transition: transform 0.4s ease;
}

/* Hover */
.gallery-card:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
}

.gallery-card:hover img {
    transform: scale(1.05);
}

/* Responsive tweaks */
@media (max-width: 576px) {
    #gallery-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Animation */
@keyframes fadeInCard {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Delays */
.gallery-item:nth-child(1) .gallery-card { animation-delay: 0.05s; }
.gallery-item:nth-child(2) .gallery-card { animation-delay: 0.1s; }
.gallery-item:nth-child(3) .gallery-card { animation-delay: 0.15s; }
.gallery-item:nth-child(4) .gallery-card { animation-delay: 0.2s; }
.gallery-item:nth-child(5) .gallery-card { animation-delay: 0.25s; }
</style>

@section('content')

{{-- Header --}}
@include('layouts.partials.header')

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">{{ __('messages.our_gallery') }}</h2>
        <div class="mb-4 text-center">
            <button class="btn btn-outline-dark me-2 filter-btn active" data-filter="all">
                {{ __('messages.all') }}
            </button>
            <button class="btn btn-outline-warning me-2 filter-btn" data-filter="restaurant">
                {{ __('messages.restaurant') }}
            </button>
            <button class="btn btn-outline-success filter-btn" data-filter="food">
                {{ __('messages.food') }}
            </button>
        </div>
        

        @if ($galleries->count())
            <div id="gallery-container">
                @foreach ($galleries as $gallery)
                    <div class="gallery-item" data-type="{{ $gallery->type }}">
                        <div class="gallery-card">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image">
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">{{ __('messages.no_images_found') }}</p>
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
