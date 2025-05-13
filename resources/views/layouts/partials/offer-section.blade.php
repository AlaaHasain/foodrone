<!-- Glide.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.theme.min.css">
<!-- Font Awesome for cart icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- CSS -->
<style>
    .offer_section {
        padding: 60px 0;
        background-color: #f8f9fa;
    }

    .heading_container {
        margin-bottom: 40px;
    }

    .heading_container h2 {
        font-size: 32px;
        font-weight: bold;
        color: #222831;
        position: relative;
        padding-bottom: 10px;
    }

    .heading_container h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: #ffbe33;
    }

    .offer-card {
        background: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 370px;
        text-align: center;
        margin: 0 5px 20px;
    }

    .offer-card:hover {
        transform: translateY(-5px);
    }

    .offer-img {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .offer-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .offer-card:hover .offer-img img {
        transform: scale(1.05);
    }

    .offer-body {
        padding: 15px;
        background: #f9f9f9;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .offer-body h5 {
        font-size: 18px;
        font-weight: bold;
        color: #222831;
        margin-bottom: 8px;
    }

    .offer-prices {
        margin-bottom: 10px;
    }

    .old-price {
        color: #999;
        text-decoration: line-through;
        font-size: 16px;
    }

    .new-price {
        color: #ffbe33;
        font-size: 20px;
        font-weight: bold;
        margin-left: 8px;
    }

    /* Buttons container */
    .buttons-container {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .btn-detail {
        background: #ffbe33;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        transition: 0.3s;
        cursor: pointer;
        flex: 1;
        margin-right: 5px;
    }

    .btn-detail:hover {
        background: #e69c00;
    }

    /* Add to cart button */
    .btn-cart {
        background: #222831;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        transition: all 0.3s;
        cursor: pointer;
        flex: 0.5;
        margin-left: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cart:hover {
        background: #333d4d;
        transform: translateY(-2px);
    }

    .btn-cart i {
        font-size: 14px;
    }

    /* تنسيق نقاط التنقل - تم تعديلها */
    .glide__bullets {
        position: relative;
        display: flex;
        justify-content: center;
        margin-top: 30px;
        /* زيادة المسافة من أعلى */
        padding-top: 15px;
        /* إضافة padding إضافي */
    }

    .glide__bullet {
        width: 12px;
        height: 12px;
        background-color: #ccc;
        border-radius: 50%;
        margin: 0 5px;
        padding: 0;
        border: none;
        box-shadow: none;
        transition: all 0.3s ease;
    }

    .glide__bullet:hover,
    .glide__bullet:focus {
        background-color: #ffbe33;
        border: none;
        box-shadow: 0 0 5px rgba(255, 190, 51, 0.5);
    }

    .glide__bullet--active {
        background-color: #ffbe33;
        width: 14px;
        height: 14px;
    }

    /* تنسيق الـ Modal */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: pulse-animation 0.5s ease-in-out 1;
    }

    @keyframes pulse-animation {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        50% {
            transform: scale(1.05);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal-header {
        background-color: #ffbe33;
        color: white;
        border-bottom: none;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 15px 20px;
    }

    .modal-title {
        font-weight: bold;
    }

    .modal-body {
        padding: 20px;
        line-height: 1.6;
    }

    .modal-footer {
        border-top: none;
        padding: 15px 20px;
    }

    /* رسالة عدم وجود عروض - إضافة جديدة */
    .no-offers-message {
        font-size: 18px;
        color: #666;
        padding: 40px 0;
        text-align: center;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 80%;
    }

    .no-offers-message i {
        font-size: 36px;
        color: #ffbe33;
        display: block;
        margin-bottom: 15px;
    }

    /* تحسين للأجهزة المحمولة */
    @media (max-width: 992px) {
        .glide__slide {
            height: auto;
        }

        .offer-card {
            height: auto;
            min-height: 350px;
        }
    }

    @media (max-width: 768px) {
        .heading_container h2 {
            font-size: 28px;
        }
    }
</style>

<!-- HTML -->
<section class="offer_section layout_padding-bottom text-center">
    <div class="container">
        <div class="heading_container heading_center mb-5">
            <h2>Special Offers</h2>
        </div>

        @if (count($offers) > 0)
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach ($offers as $offer)
                            <li class="glide__slide">
                                <div class="card offer-card">
                                    <div class="offer-img">
                                        <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->name }}"
                                            loading="lazy">
                                    </div>
                                    <div class="offer-body">
                                        <h5>{{ $offer->name }}</h5>
                                        <div class="offer-prices">
                                            <span class="old-price">${{ number_format($offer->old_price, 2) }}</span>
                                            <span class="new-price">${{ number_format($offer->offer_price, 2) }}</span>
                                        </div>
                                        <div class="buttons-container">
                                            <button class="btn btn-detail"
                                                onclick="openOfferModal({{ $offer->id }})">Details</button>
                                            <button class="btn btn-cart add-to-cart-btn" data-id="{{ $offer->id }}">
                                                <i class="fa fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- نقاط التنقل -->
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    @foreach ($offers as $key => $offer)
                        <button class="glide__bullet" data-glide-dir="={{ $key }}"></button>
                    @endforeach
                </div>
            </div>
        @else
            <div class="no-offers-message">
                <i class="fas fa-exclamation-circle"></i>
                <p>No special offers available now. Please check back later!</p>
            </div>
        @endif
    </div>
</section>

<!-- Modals للعروض -->
@foreach ($offers as $offer)
    <div class="modal fade" id="offerModal{{ $offer->id }}" tabindex="-1"
        aria-labelledby="offerModalLabel{{ $offer->id }}" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $offer->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    {{ $offer->description }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- jQuery + Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Glide.js -->
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/glide.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).off('click', '.add-to-cart-btn').on('click', '.add-to-cart-btn', function (e) {
            e.preventDefault();

            let itemId = $(this).data('id');

            $.ajax({
                url: "{{ route('cart.add-ajax') }}",
                method: "POST",
                data: {
                    menu_item_id: itemId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // تحديث عداد السلة
                    $('.cart-count').each(function() {
                        $(this).text(response.count);

                        if (response.count > 0) {
                            $(this).addClass('show');
                        } else {
                            $(this).removeClass('show');
                        }

                        $(this).addClass('pulse');
                        setTimeout(() => $(this).removeClass('pulse'), 500);
                    });


                },
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // التحقق من وجود عناصر العروض أولاً
        if (document.querySelector('.glide')) {
            new Glide('.glide', {
                type: 'slider', // تغيير من carousel إلى slider لمنع التمرير اللانهائي
                perView: 3, // عرض 3 عناصر في الشاشة الواحدة
                gap: 20, // المسافة بين العناصر
                bound: true, // منع التمرير إلى ما بعد آخر عنصر
                breakpoints: { // استجابة للشاشات المختلفة
                    992: {
                        perView: 2
                    },
                    768: {
                        perView: 1
                    }
                },
                rewind: false, // منع العودة للبداية تلقائياً عند الوصول للنهاية
                autoplay: 1500, // تمرير تلقائي كل 1.5 ثانية
                hoverpause: true // إيقاف التمرير التلقائي عند تمرير الماوس فوق العناصر
            }).mount();
        }
    });

    function openOfferModal(id) {
        // إعادة تعيين أي تأثيرات سابقة
        const modalContent = $('#offerModal' + id).find('.modal-content');
        modalContent.css('animation', 'none');

        // إعادة تشغيل التأثير بإعادة تطبيق الـ animation
        setTimeout(function() {
            modalContent.css('animation', 'pulse-animation 0.5s ease-in-out 1');
            $('#offerModal' + id).modal('show');
        }, 10);
    }
</script>
