
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css">

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
    /* ✅ Slide Panel Styles */
.slide-panel {
    position: fixed;
    top: 0;
    right: -100%;
    width: 350px;
    height: 100%;
    background: #fff;
    box-shadow: -3px 0 10px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    transition: right 0.4s ease;
    display: flex;
    flex-direction: column;
}

.slide-panel.open {
    right: 0;
}

.slide-header {
    padding: 15px 20px;
    background: #ffbe33;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.slide-content {
    padding: 20px;
    overflow-y: auto;
    flex-grow: 1;
    text-align: left;
}

.slide-content img {
    width: 100%;
    max-height: 150px;
    border-radius: 10px;
    margin-bottom: 15px;
    max-height: 200px;
    object-fit: cover;
}

.slide-price {
    font-weight: bold;
    color: #222831;
    font-size: 18px;
}

#slide-close {
    background: transparent;
    border: none;
    font-size: 22px;
    color: white;
    cursor: pointer;
}

.menu-option-checkbox {
    margin-bottom: 8px;
    font-size: 14px;
}
.menu-option-checkbox input {
    margin-right: 10px;
}
.menu-option-checkbox input[type="checkbox"],
.menu-option-checkbox input[type="radio"] {
    accent-color: #ffbe33; /* أخضر غامق */
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
            <h2>{{ __('messages.special_offers') }}</h2>
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
                                            <button class="btn btn-detail open-slide-panel"
                                                data-id="{{ $offer->id }}"
                                                data-name="{{ $offer->name }}"
                                                data-description="{{ $offer->description }}"
                                                data-image="{{ asset('storage/' . $offer->image) }}"
                                                data-price="{{ $offer->offer_price }}">
                                                {{ __('messages.details') }}
                                            </button>
                                            <button class="btn btn-cart open-slide-panel"
                                                data-id="{{ $offer->id }}"
                                                data-name="{{ $offer->name }}"
                                                data-description="{{ $offer->description }}"
                                                data-image="{{ asset('storage/' . $offer->image) }}"
                                                data-price="{{ $offer->offer_price }}">
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
                <p>{{ __('messages.no_special_offers') }}</p>
            </div>
        @endif
    </div>

    <!-- ✅ Slide Panel لتفاصيل العرض -->
<div id="offer-slide-panel" class="slide-panel menu-style-panel">
    <div class="slide-header">
        <h5 id="slide-title">Title</h5>
        <button id="slide-close">&times;</button>
    </div>
<div class="slide-content">
    <img id="slide-image" src="" alt="Offer Image">
    <p id="slide-description" class="mb-3"></p>

   <!-- ✅ السعر الأساسي -->
<p class="slide-price mb-2 d-flex justify-content-between align-items-center">
    <strong>{{ __('messages.base_price') }}:</strong>
    <span dir="ltr" style="display:inline-block; min-width: 90px; text-align: start;">
        <span id="slide-price"></span>
        {{ __('messages.currency') }}
    </span>
</p>

    <!-- ✅ الخيارات -->
    <div id="offer-options-container" class="mt-3"></div>

    <!-- ✅ السعر الإجمالي -->
<p class="slide-price mt-3 d-flex justify-content-between align-items-center">
    <strong>{{ __('messages.total') }}:</strong>
    <span dir="ltr" style="display:inline-block; min-width: 90px; text-align: start;">
        <span id="offer-slide-total"></span>
        {{ __('messages.currency') }}
    </span>
</p>

    <button id="slide-add-to-cart" class="btn btn-cart mt-3" data-id="">
        {{ __('messages.add_to_cart') }}
    </button>
</div>



</div>

</section>
<style>
   #offer-slide-panel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100%;
    background: #fff;
    box-shadow: -5px 0 20px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

@media (max-width: 576px) {
    #offer-slide-panel {
        width: 85%;
        right: -85%;
    }
}

#offer-slide-panel.open {
    right: 0;
}

#offer-slide-panel .slide-header {
    padding: 18px 20px;
    background: #ffbe33;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

#offer-slide-panel .slide-header h5 {
    font-weight: 600;
    margin: 0;
    font-size: 18px;
}

#offer-slide-panel .slide-content {
    padding: 25px;
    overflow-y: auto;
    flex-grow: 1;
}

#offer-slide-panel .slide-content img {
    width: 100%;
    border-radius: 12px;
    margin-bottom: 20px;
    height: 200px;
    object-fit: cover;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

#offer-slide-panel #slide-description {
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 15px;
}

#offer-slide-panel .slide-price {
    font-weight: bold;
    color: #222831;
    font-size: 20px;
    padding: 10px 0;
    border-top: 1px solid #eee;
    margin-top: 15px;
}

#slide-close {
    background: transparent;
    border: none;
    font-size: 28px;
    color: white;
    cursor: pointer;
    transition: transform 0.3s ease;
}

#slide-close:hover {
    transform: rotate(90deg);
}

#slide-add-to-cart {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    font-size: 16px;
    background-color: #ffbe33;
    color: white;
    border: none;
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(255, 190, 51, 0.3);
}

#slide-add-to-cart:hover {
    background-color: #f0aa18;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 190, 51, 0.4);
}

#slide-add-to-cart::before {
    content: '\f07a';
    font-family: 'FontAwesome';
    font-size: 18px;
}

</style>


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

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const panel = document.getElementById('offer-slide-panel');
        const closeBtn = document.getElementById('slide-close');
        const addToCartBtn = document.getElementById('slide-add-to-cart');

        // عند الضغط على زر Details
        document.querySelectorAll('.open-slide-panel').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('slide-title').textContent = button.dataset.name;
                document.getElementById('slide-description').textContent = button.dataset.description;

                document.getElementById('slide-image').src = button.dataset.image;
                document.getElementById('slide-price').textContent = parseFloat(button.dataset.price).toFixed(2);
                document.getElementById('offer-slide-total').textContent = parseFloat(button.dataset.price).toFixed(2);
                window.basePrice = parseFloat(button.dataset.price); // ✅ تخزين السعر الأساسي
                // تحديث ID في زر الإضافة
                addToCartBtn.setAttribute('data-id', button.dataset.id);

                // ✅ جلب الخيارات من السيرفر
fetch(`/offers/options/${button.dataset.id}`)
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('offer-options-container');
        container.innerHTML = ''; // تفريغ الخيارات القديمة

data.options.forEach(option => {
    const group = document.createElement('label');
    group.className = 'menu-option-group';
    group.innerHTML = `<label>${option.name}</label>`;

    const inputType = option.type === 'radio' ? 'radio' : 'checkbox'; // ✅ تحديد النوع
    const inputName = `option_${option.name.replace(/\s+/g, '_')}`;   // ✅ اسم موحد للراديو

    option.values.forEach(value => {
        const row = document.createElement('label');
        row.className = 'menu-option-checkbox';
        row.innerHTML = `
            <input type="${inputType}"
                   name="${inputName}"
                   class="option-checkbox offer-option"
                   data-id="${value.id}"
                   data-price="${value.price}"
                   data-label="${value.label}"
                   data-option-name="${option.name}">
            <span>${value.label} ${parseFloat(value.price) > 0 ? `(+${parseFloat(value.price).toFixed(2)} JOD)` : ''}</span>
        `;
        group.appendChild(row);
    });

    container.appendChild(group);
});


    })
    .catch(() => {
        document.getElementById('offer-options-container').innerHTML =
            `<div class="text-danger">Failed to load options.</div>`;
    });

    
                // فتح اللوحة الجانبية
                panel.classList.add('open');
            });
        });

        // عند الضغط على ×
        closeBtn.addEventListener('click', () => {
            panel.classList.remove('open');
        });

        document.addEventListener('change', function (e) {
    if (e.target.classList.contains('offer-option')) {
        let total = parseFloat(document.getElementById('slide-price').textContent) || 0;

        document.querySelectorAll('.offer-option:checked').forEach(opt => {
            total += parseFloat(opt.dataset.price || 0);
        });

        document.getElementById('offer-slide-total').textContent = total.toFixed(2);
    }
});

        // عند الضغط على Add to Cart
// عند الضغط على Add to Cart
addToCartBtn.addEventListener('click', function () {
    if (!window.isLoggedIn) {
        window.location.href = "{{ route('login') }}";
        return;
    }

    // 👇 باقي الكود الأصلي لإضافة العنصر إلى السلة
    const itemId = this.getAttribute('data-id');
    const selectedOptions = [];
    let totalPrice = basePrice;
    
    document.querySelectorAll('.option-checkbox:checked').forEach(cb => {
        selectedOptions.push({
            id: cb.dataset.id,
            value: cb.nextElementSibling?.textContent.split('(+')[0].trim(),
            additional_price: parseFloat(cb.dataset.price || 0)
        });
        totalPrice += parseFloat(cb.dataset.price || 0);
    });

    fetch("{{ route('cart.add-ajax') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            menu_item_id: itemId,
            quantity: 1,
            options: selectedOptions,
            final_price: totalPrice
        })
    })
    .then(res => res.json())
    .then(data => {
            document.dispatchEvent(new CustomEvent('cartUpdated', {
                detail: { count: data.count }
            }));

        panel.classList.remove('open');

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Item added to cart!',
            showConfirmButton: false,
            timer: 1000
        });
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to add item', 'error');
    });
});

    });
</script>

