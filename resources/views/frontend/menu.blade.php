@extends('layouts.app')

@section('title', 'QR Menu')

@section('content')
<meta name="qr-token" content="{{ $token }}">
<script>
    if (window.location.pathname.includes('/qr/') && !window.location.pathname.includes('/order/')) {
        localStorage.removeItem('qr_order_token');
    }
</script>

<style>
        /* تدرج الألوان المحدث ليتماشى مع اللوجو */
        :root {
            --primary-green: #1a5d1a;
            --secondary-green: #2d8f47;
            --light-green: #4caf50;
            --accent-green: #66bb6a;
            --light-mint: #e8f5e8;
            --cream-bg: #f8fff8;
            --white-soft: #ffffff;
            --text-dark: #1b5e20;
            --text-medium: #2e7d32;
            --border-light: rgba(76, 175, 80, 0.2);
            --shadow-soft: rgba(27, 94, 32, 0.1);
            --shadow-hover: rgba(27, 94, 32, 0.25);
            --success-green: #4caf50;
            --dark-green: #1b5e20;
        }

        /* الحاوي الرئيسي */
        .qr-menu-container {
            max-width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--cream-bg) 0%, #f1f8e9 100%);
            min-height: calc(100vh - 60px);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* منطقة الهيدر والعلامة التجارية */
        .restaurant-header {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px 0;
            background: linear-gradient(135deg, var(--white-soft) 0%, var(--light-mint) 100%);
            border-radius: 20px;
            box-shadow: 0 8px 25px var(--shadow-soft);
            border: 1px solid var(--border-light);
        }

        .sidebar-logo-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .sidebar-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 8px 20px var(--shadow-hover);
            border: 3px solid var(--success-green);
            background: var(--white-soft);
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .sidebar-logo:hover {
            transform: scale(1.05);
        }

        .sidebar-logo-text {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-green);
            text-shadow: 0 2px 4px rgba(27, 94, 32, 0.1);
            letter-spacing: -0.5px;
        }

        .table-info {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-medium);
            margin-bottom: 10px;
            background: var(--light-mint);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);
        }

        /* التابات والتصنيفات */
        .category-tabs-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, rgba(248, 255, 248, 0.98) 0%, rgba(241, 248, 233, 0.98) 100%);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px var(--shadow-soft);
            border-bottom: 1px solid var(--border-light);
        }

        .category-tabs {
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 8px;
            gap: 10px;
        }

        .category-tabs::-webkit-scrollbar {
            display: none;
        }

        .category-tab {
            flex: 0 0 auto;
            padding: 12px 20px;
            border-radius: 25px;
            background: linear-gradient(135deg, var(--white-soft) 0%, var(--light-mint) 100%);
            border: 2px solid var(--border-light);
            font-weight: 700;
            color: var(--text-medium);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            font-size: 14px;
            box-shadow: 0 2px 8px var(--shadow-soft);
        }

        .category-tab.active,
        .category-tab:hover {
            background: linear-gradient(135deg, var(--success-green) 0%, var(--primary-green) 100%);
            color: white;
            box-shadow: 0 6px 20px var(--shadow-hover);
            transform: translateY(-3px);
            border-color: var(--accent-green);
        }

        /* عناوين التصنيفات */
        .category-header {
            margin: 30px 0 15px;
            padding: 15px 0 10px;
            border-bottom: 3px solid;
            border-image: linear-gradient(90deg, var(--success-green), var(--secondary-green), var(--success-green)) 1;
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            scroll-margin-top: 100px;
        }

        .category-header::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px;
            width: 60px;
            height: 3px;
            background: var(--success-green);
            border-radius: 2px;
        }
.category-header {
    scroll-margin-top: 180px; /* مسافة من الأعلى عند التمرير */
    padding-top: 10px;
}

.category-tabs-container {
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
    border-bottom: 1px solid #eee;
}

        /* التمرير الأفقي للعناصر */
        .menu-items-scroll {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            gap: 15px;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .menu-items-scroll::-webkit-scrollbar {
            display: none;
        }

        /* كروت المنيو المحسنة مع صور أكبر */
        .menu-card {
            flex: 0 0 180px;
            background: linear-gradient(135deg, var(--white-soft) 0%, #fefefe 100%);
            border-radius: 18px;
            box-shadow: 0 4px 15px var(--shadow-soft);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 280px;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-light);
            position: relative;
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--success-green), var(--secondary-green), var(--success-green));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 35px var(--shadow-hover);
            border-color: var(--success-green);
        }

        .menu-card:hover::before {
            opacity: 1;
        }

        .menu-card-img {
            position: relative;
            width: 100%;
            height: 140px;
            overflow: hidden;
        }

        .menu-card img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .menu-card:hover img {
            transform: scale(1.1);
        }

        .menu-card-body {
            padding: 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .menu-card-body h5 {
            margin: 0 0 8px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .menu-card-body p.description {
            font-size: 12px;
            margin-bottom: 10px;
            color: var(--text-medium);
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 32px;
            line-height: 1.4;
        }

        .menu-card-footer {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: auto;
        }

        .price {
            font-weight: 800;
            font-size: 16px;
            color: var(--secondary-green);
            text-shadow: 0 1px 2px rgba(45, 143, 71, 0.1);
        }

        .card-buttons {
            display: flex;
            gap: 6px;
        }

        .cart-btn {
            padding: 8px 12px;
            background: linear-gradient(135deg, var(--success-green) 0%, var(--primary-green) 100%);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 1;
            box-shadow: 0 2px 8px var(--shadow-soft);
        }

        .cart-btn:hover {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-hover);
        }

        .category-tab {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-tab.active {
    background-color: #007bff;
    color: white;
}

.category-section {
    scroll-margin-top: 100px; /* مسافة من الأعلى عند التمرير */
}

        /* شارات التصنيف */
        .category-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, var(--light-mint) 100%);
            color: var(--text-dark);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            box-shadow: 0 2px 8px var(--shadow-soft);
            border: 1px solid var(--border-light);
        }

        /* التاجات المميزة */
        .special-tag {
            display: inline-block;
            margin-right: 4px;
            padding: 3px 8px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        .special-tag.new {
            background: linear-gradient(135deg, var(--success-green), var(--primary-green));
            color: white;
        }

        .special-tag.popular {
            background: linear-gradient(135deg, #ff9800, #f57c00);
            color: white;
        }

        .special-tag.spicy {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
        }

        /* العربة العائمة */
        .floating-cart {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--success-green) 0%, var(--primary-green) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: grab;
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
            font-size: 20px;
            transition: all 0.3s ease;
            border: 3px solid var(--white-soft);
        }

        .floating-cart:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(76, 175, 80, 0.5);
        }

        .floating-cart:active {
            cursor: grabbing;
            transform: scale(0.95);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(244, 67, 54, 0.4);
            border: 2px solid white;
        }

        /* لوحة التمرير الجانبية */
        #qr-slide-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 380px;
            height: 100%;
            background: linear-gradient(135deg, var(--white-soft) 0%, var(--cream-bg) 100%);
            box-shadow: -5px 0 25px var(--shadow-hover);
            z-index: 9999;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            border-left: 3px solid var(--success-green);
        }

        #qr-slide-panel.open {
            right: 0;
        }

        #qr-slide-panel .slide-header {
            padding: 20px 25px;
            background: linear-gradient(135deg, var(--success-green) 0%, var(--primary-green) 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px var(--shadow-soft);
        }

        #qr-slide-panel .slide-content {
            padding: 25px;
            overflow-y: auto;
            flex-grow: 1;
        }

        #qr-slide-panel .slide-content img {
            width: 100%;
            border-radius: 15px;
            margin-bottom: 20px;
            max-height: 180px;
            object-fit: cover;
            box-shadow: 0 4px 15px var(--shadow-soft);
        }

        #qr-slide-panel .slide-price {
            font-weight: 800;
            color: var(--secondary-green);
            font-size: 20px;
            text-shadow: 0 1px 2px rgba(45, 143, 71, 0.1);
        }

        #qr-slide-close {
            background: transparent;
            border: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        #qr-slide-close:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        /* مجموعات الخيارات */
        .menu-option-group {
            margin-bottom: 20px;
            padding: 15px;
            background: var(--white-soft);
            border-radius: 12px;
            border: 1px solid var(--border-light);
        }

        .menu-option-group label {
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
            color: var(--text-dark);
            font-size: 16px;
        }

        .menu-option-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .menu-option-checkbox:hover {
            background: var(--light-mint);
        }

        .menu-option-checkbox input {
            margin-right: 12px;
            accent-color: var(--success-green);
            transform: scale(1.2);
        }

        #qr-slide-add-to-cart {
            background: linear-gradient(135deg, var(--success-green) 0%, var(--primary-green) 100%);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 800;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px var(--shadow-soft);
            margin-top: 20px;
        }

        #qr-slide-add-to-cart:hover {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--shadow-hover);
        }

        /* تخطيط الشبكة */
        .menu-items-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        /* الاستجابة للشاشات الأكبر */
        @media (min-width: 540px) {
            .menu-items-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .menu-card {
                flex: 0 0 200px;
                height: 300px;
            }
            
            .menu-card-img {
                height: 200px;
            }
            
            .restaurant-header {
                padding: 25px 0;
            }
            
            .sidebar-logo-text {
                font-size: 32px;
            }
            
            #qr-slide-panel {
                width: 420px;
            }
        }

        @media (max-width: 480px) {
            .qr-menu-container {
                padding: 10px;
            }
            
            .restaurant-header {
                margin-bottom: 20px;
                padding: 15px 0;
            }
            
            .menu-card {
                flex: 0 0 165px;
                height: 260px;
            }
            
            .menu-card-img {
                height: 200px;
            }
            
            .floating-cart {
                width: 55px;
                height: 55px;
                bottom: 70px;
                right: 15px;
            }
            
            #qr-slide-panel {
                width: 100%;
            }
        }
    </style>

<div class="qr-menu-container">
    <!-- Restaurant Header -->
    <div class="restaurant-header">
        <div class="sidebar-logo-wrapper">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Restaurant Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <h1 class="restaurant-title">Lemongrass</h1>
        @if(isset($table))
        <div class="table-info">Table #{{ $table->table_number }}</div>
    @endif

    </div>
    
    <!-- Category Tabs -->
    <div class="category-tabs-container">
        <div class="category-tabs">
            <button class="category-tab active" data-category="all">All Menu</button>
            @foreach($categories as $category)
                @if($category->menuItems->count())
                    <button class="category-tab" data-category="{{ $category->id }}" data-target="#cat-{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- All Menu Items View -->
    <div id="allMenuView">
        @foreach($categories as $category)
            @if($category->menuItems->count())
                <div class="category-header" id="cat-{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                </div>
                <div class="menu-items-scroll">
                    @foreach($category->menuItems as $item)
                       <div class="menu-card menu-item cat-{{ $category->id }}">
                            @if($item->image)
                                <div class="menu-card-img">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                                    <div class="category-badge">{{ $category->name }}</div>
                                </div>
                            @endif
                            <div class="menu-card-body">
                                <h5>
                                    {{ $item->name }}
                                    @if($item->is_new)
                                        <span class="special-tag new">New</span>
                                    @endif
                                    @if($item->is_popular)
                                        <span class="special-tag popular">Popular</span>
                                    @endif
                                </h5>
                                <p class="description">{{ $item->description }}</p>
                                <div class="menu-card-footer">
                                    <span class="price">{{ number_format($item->price, 2) }} JOD</span>
                                    <div class="card-buttons">
                                        <button class="cart-btn small-btn add-to-cart-btn" data-id="{{ $item->id }}">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                        <button class="cart-btn small-btn open-qr-slide-panel" data-id="{{ $item->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </div>
                                </div>                                                                                                                                                              
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <!-- Category Filtered View -->
    <div id="categoryFilteredView" style="display: none;">
        <div class="menu-items-grid">
            <!-- Items will be displayed here when filtering by category -->
        </div>
    </div>
</div>

<!-- ✅ Slide Panel لتفاصيل الصنف في QR Menu -->
<div id="qr-slide-panel" class="slide-panel">
    <div class="slide-header">
        <h5 id="qr-slide-title">Title</h5>
        <button id="qr-slide-close">&times;</button>
    </div>
    <div class="slide-content">
        <img id="qr-slide-image" src="" alt="Item Image">
        <p id="qr-slide-description"></p>
        
        <div id="qr-slide-options" class="mt-3"></div>

        <p class="slide-price mt-3">Total: <span id="qr-slide-price"></span> JOD</p>
        <button id="qr-slide-add-to-cart" class="btn btn-cart mt-3" data-id="">Add to Cart</button>
    </div>
</div>

<!-- Floating Cart Icon -->
<div id="floating-cart" class="floating-cart">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-count" id="floating-cart-count">0</span>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const qrSlidePanel = document.getElementById('qr-slide-panel');
    const qrCloseBtn = document.getElementById('qr-slide-close');
    const qrAddToCartBtn = document.getElementById('qr-slide-add-to-cart');

    // ✅ التأكد من وجود العناصر قبل إضافة Event Listeners
    if (qrAddToCartBtn) {
        qrAddToCartBtn.addEventListener('click', function () {
            const itemId = this.getAttribute('data-id');

            const selectedOptions = [];
            document.querySelectorAll('.qr-option-checkbox:checked').forEach(opt => {
                selectedOptions.push({
                    name: opt.dataset.optionName,
                    value: opt.dataset.value,
                    additional_price: parseFloat(opt.dataset.price || 0)
                });
            });

            const finalPrice = selectedOptions.reduce((sum, opt) => sum + opt.additional_price, basePrice);

            fetch("{{ route('qr.cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: 1,
                    final_price: finalPrice,
                    options: selectedOptions
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    let cartCounter = document.getElementById('floating-cart-count');
                    if (cartCounter) {
                        let currentCount = parseInt(cartCounter.textContent) || 0;
                        cartCounter.textContent = currentCount + 1;
                    }

                    if (qrSlidePanel) {
                        qrSlidePanel.classList.remove('open');
                    }
                }
            });
        });
    }

    const qrOptionsContainer = document.getElementById('qr-slide-options');
    const qrTotalEl = document.getElementById('qr-slide-price');
    let basePrice = 0;

    // ✅ فتح الـ Slide Panel للعرض والإضافة
    document.querySelectorAll('.open-qr-slide-panel, .add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const itemId = this.getAttribute('data-id');

            fetch(`/qr/item/${itemId}`)
                .then(res => res.json())
                .then(item => {
                    if (qrAddToCartBtn) {
    qrAddToCartBtn.setAttribute('data-id', item.id);

    // ✅ تعطيل الزر إذا ما في سعر
    if (basePrice > 0) {
        qrAddToCartBtn.disabled = false;
        qrAddToCartBtn.classList.remove('disabled');
    } else {
        qrAddToCartBtn.disabled = true;
        qrAddToCartBtn.classList.add('disabled');
    }
}

                    basePrice = parseFloat(item.price);
                    
                    const titleEl = document.getElementById('qr-slide-title');
                    const descEl = document.getElementById('qr-slide-description');
                    const imageEl = document.getElementById('qr-slide-image');
                    
                    if (titleEl) titleEl.textContent = item.name;
                    if (descEl) descEl.textContent = item.description || 'No description';
                    if (imageEl) imageEl.src = `/storage/${item.image}`;
                    if (qrTotalEl) qrTotalEl.textContent = basePrice.toFixed(2);
                    if (qrAddToCartBtn) qrAddToCartBtn.setAttribute('data-id', item.id);

                    if (qrOptionsContainer) {
                        qrOptionsContainer.innerHTML = '';
                        if (item.options && item.options.length > 0) {
                            item.options.forEach(option => {
                                const group = document.createElement('div');
                                group.className = 'menu-option-group';
                                group.innerHTML = `<label>${option.name}</label>`;

                                const inputType = option.type === 'radio' ? 'radio' : 'checkbox';
                                const inputName = `qr_option_${option.id}`;

                                option.values.forEach(value => {
                                    const label = document.createElement('label');
                                    label.className = 'menu-option-checkbox';
                                    label.innerHTML = `
                                        <input type="${inputType}" name="${inputName}"
                                            class="qr-option-checkbox"
                                            data-option-name="${option.name}"
                                            data-value="${value.value}"
                                            data-price="${value.additional_price || 0}">
                                        <span>${value.value} ${value.additional_price > 0 ? `(+${parseFloat(value.additional_price).toFixed(2)} JOD)` : ''}</span>
                                    `;
                                    group.appendChild(label);
                                });

                                qrOptionsContainer.appendChild(group);
                            });
                        }
                    }

                    if (qrSlidePanel) {
                        qrSlidePanel.classList.add('open');
                    }
                });
        });
    });

    // ✅ إغلاق الـ Slide Panel
    if (qrCloseBtn) {
        qrCloseBtn.addEventListener('click', () => {
            if (qrSlidePanel) {
                qrSlidePanel.classList.remove('open');
            }
        });
    }

    // ✅ تحديث السعر مع الخيارات
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('qr-option-checkbox')) {
        let total = basePrice;
        document.querySelectorAll('.qr-option-checkbox:checked').forEach(cb => {
            total += parseFloat(cb.dataset.price || 0);
        });

        if (qrTotalEl) {
            qrTotalEl.textContent = total.toFixed(2);
        }

        // ✅ تعطيل أو تفعيل الزر حسب قيمة السعر
        if (qrAddToCartBtn) {
            if (total > 0) {
                qrAddToCartBtn.disabled = false;
                qrAddToCartBtn.classList.remove('disabled');
            } else {
                qrAddToCartBtn.disabled = true;
                qrAddToCartBtn.classList.add('disabled');
            }
        }
    }
});


    // ✅ وظائف السلة العائمة
    const floatingCart = document.getElementById("floating-cart");
    if (floatingCart) {
        let isDragging = false;
        let offsetX, offsetY;

        floatingCart.style.top = floatingCart.getBoundingClientRect().top + "px";
        floatingCart.style.left = floatingCart.getBoundingClientRect().left + "px";
        floatingCart.style.bottom = "auto";
        floatingCart.style.right = "auto";

        floatingCart.addEventListener("mousedown", function (e) {
            isDragging = true;
            offsetX = e.clientX - floatingCart.getBoundingClientRect().left;
            offsetY = e.clientY - floatingCart.getBoundingClientRect().top;
            document.body.style.userSelect = "none";
        });

        floatingCart.addEventListener("touchstart", function (e) {
            isDragging = true;
            offsetX = e.touches[0].clientX - floatingCart.getBoundingClientRect().left;
            offsetY = e.touches[0].clientY - floatingCart.getBoundingClientRect().top;
            document.body.style.userSelect = "none";
        });

        document.addEventListener("mousemove", function (e) {
            if (isDragging) {
                floatingCart.style.left = `${e.clientX - offsetX}px`;
                floatingCart.style.top = `${e.clientY - offsetY}px`;
            }
        });

        document.addEventListener("touchmove", function (e) {
            if (isDragging) {
                e.preventDefault();
                floatingCart.style.left = `${e.touches[0].clientX - offsetX}px`;
                floatingCart.style.top = `${e.touches[0].clientY - offsetY}px`;
            }
        }, { passive: false });

        document.addEventListener("mouseup", function () {
            isDragging = false;
            document.body.style.userSelect = "auto";
        });

        document.addEventListener("touchend", function () {
            isDragging = false;
            document.body.style.userSelect = "auto";
        });

        // ✅ النقر على السلة
        let wasJustDragging = false;
        floatingCart.addEventListener("click", function () {
            if (!wasJustDragging) {
                const savedToken = localStorage.getItem('qr_token') || '{{ $token }}';
                
                if (!savedToken) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Session Error',
                        text: 'Your session information is missing. Please scan the QR code again.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                
                window.location.href = `/qr/cart?token=${savedToken}`;
            }
            wasJustDragging = false;
        });
    }

    // ✅ إضافة للسلة (الأزرار العادية)
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const itemId = this.getAttribute('data-id');

            fetch("{{ route('qr.cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    let cartCounter = document.getElementById('floating-cart-count');
                    if (cartCounter) {
                        let currentCount = parseInt(cartCounter.textContent) || 0;
                        cartCounter.textContent = currentCount + 1;
                    }
                }
            });
        });
    });

    // ✅ التمرير للفئات - مُصحح ومحسن
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // إزالة التفعيل من كل التابات
            document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const categoryId = this.getAttribute('data-category');
            console.log('Clicking category:', categoryId);
            
            if (categoryId === 'all') {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else {
                const targetElement = document.getElementById(`cat-${categoryId}`);
                console.log('Target element found:', targetElement);
                
                if (targetElement) {
                    const headerHeight = document.querySelector('.restaurant-header')?.offsetHeight || 0;
                    const tabsHeight = document.querySelector('.category-tabs-container')?.offsetHeight || 0;
                    const offset = targetElement.offsetTop - headerHeight - tabsHeight - 20;
                    
                    console.log('Scrolling to offset:', offset);
                    
                    window.scrollTo({
                        top: Math.max(0, offset),
                        behavior: 'smooth'
                    });
                } else {
                    console.warn(`Category element not found: cat-${categoryId}`);
                    
                    // بديل: البحث في كل عناصر الفئات
                    const allCategoryHeaders = document.querySelectorAll('.category-header');
                    allCategoryHeaders.forEach(header => {
                        console.log('Found header:', header.id);
                    });
                }
            }
        });
    });

    // ✅ حفظ التوكن
    const token = document.querySelector('meta[name="qr-token"]')?.getAttribute('content') || '{{ $token ?? "" }}';
    if (token) {
        localStorage.setItem('qr_token', token);
    }
});

// ✅ وظيفة مساعدة للتشخيص
function debugCategories() {
    console.log('=== Debug Categories ===');
    console.log('Category tabs:', document.querySelectorAll('.category-tab'));
    console.log('Category headers:', document.querySelectorAll('.category-header'));
    console.log('Elements with cat- ids:', document.querySelectorAll('[id^="cat-"]'));
    
    document.querySelectorAll('.category-tab').forEach((tab, i) => {
        console.log(`Tab ${i}:`, {
            text: tab.textContent.trim(),
            categoryData: tab.getAttribute('data-category'),
            targetData: tab.getAttribute('data-target')
        });
    });
}
</script>

@endsection