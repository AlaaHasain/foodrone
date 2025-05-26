
<!-- CSS -->
<style>
    /* قسم التصنيفات */
    .food_section .filters_menu {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 30px;
    }

    .food_section .filters_menu li {
        display: inline-block;
        margin: 5px 10px;
        cursor: pointer;
        padding: 5px 15px;
        border-radius: 20px;
        background: #f1faee;
        transition: 0.3s;
    }

    .food_section .filters_menu li.active,
    .food_section .filters_menu li:hover {
        background: #ffbe33;
        color: white;
    }

    /* الكارد الأساسي */
    .food-card {
        background: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.4s ease;
        display: flex;
        flex-direction: column;
        height: 250px;
        border: none;
        margin: 0 5px 15px;
    }

    .food-card:hover {
        transform: translateY(-5px);
    }

    /* صورة الكارد */
    .food-img {
        width: 100%;
        height: 110px;
        overflow: hidden;
    }

    .food-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .food-card:hover .food-img img {
        transform: scale(1.05);
    }

    /* محتوى الكارد */
    .card-body {
        padding: 12px 8px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
        color: #222831;
        margin-bottom: 5px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-price {
        font-size: 16px;
        font-weight: bold;
        color: #ffbe33;
        margin-bottom: 10px;
    }

    .card-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    /* الأزرار */
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

    /* تخصيص المودال (البوب أب) */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: pulse-animation 0.5s ease-in-out 1;
    }

/* Pagination Container */
.pagination-container {
    display: flex;
    justify-content: center;
    margin: 30px 0;
}

/* Pagination List */
.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    border-radius: 8px;
    overflow: hidden;
}

/* Pagination Items */
.pagination li {
    margin: 0;
}

/* Pagination Links */
.pagination li a {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    margin: 0 2px;
    color: #fff;
    background-color: #1a1a1a;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 4px;
}

/* Pagination Arrows */
.pagination li a.prev,
.pagination li a.next {
    font-weight: bold;
}

/* Active Page - تم تغيير اللون من الأزرق إلى الأصفر */
.pagination li a.active,
.pagination li a[aria-current="page"],
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
    background-color: #ffcc00 !important; /* تم تغيير اللون إلى أصفر مع استخدام !important */
    color: #000 !important;
    border-color: #ffcc00 !important;
}

/* Hover Effect */
.pagination li a:hover:not(.active) {
    background-color: #333;
    color: #ffcc00; /* Similar to the yellow price color */
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

    /* لإخفاء العناصر غير المرئية بالفلتر بشكل صحيح */
    .menu-item.filtered-out {
        display: none !important;
    }

    /* عندما لا توجد عناصر */
    .no-items-message {
        text-align: center;
        padding: 30px;
        font-size: 18px;
        color: #666;
        width: 100%;
        display: none;
    }

    /* عرض التصنيفات للشاشات الصغيرة */
    @media (max-width: 768px) {
        .food_section .filters_menu {
            overflow-x: auto;
            padding-bottom: 10px;
            justify-content: flex-start;
        }

        .food_section .filters_menu li {
            margin: 5px;
            white-space: nowrap;
        }
    }

    /* تنسيق شبكة عرض العناصر */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }

    @media (max-width: 1200px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 992px) {
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .menu-grid {
            grid-template-columns: 1fr;
        }
    }
    /* ✅ تصغير الكارد على الشاشات الصغيرة */
@media (max-width: 576px) {
  .menu-grid {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    gap: 16px;
    padding: 10px 0;
  }

  .menu-item {
    flex: 0 0 40%; /* ⬅️ اجعل العرض ثابت بنسبة مئوية واحدة */
    max-width: 80%;
    scroll-snap-align: start;
  }

.card-title {
    font-size: 14px;
    line-height: 1.2;
    height: 38px; /* ثبّته لتوحيد العناوين */
    overflow: hidden;
}


.food-card {
    width: 100%; /* ✅ اضمن أن الكارد يمشي على كل عرض العنصر */
  }

  .food-img {
    height: 400px; /* ✅ بدل 140px أو 110px، اختر الحجم المناسب */
  }

  .food-img img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 8px; /* اختياري: لجمالية الحواف */
  }

.menu-item,
.food-card {
    flex-shrink: 0 !important; /* يمنع التصغير أو التمدد */
}

.menu-grid {
    scroll-padding-left: 16px;
}

}

/* ✅ تحسين عنوان القائمة */
.heading_container.heading_center h2 {
  margin-top: 20px;
  margin-bottom: 25px;
  font-size: 24px;
}

@media (max-width: 576px) {
  .pagination-container {
    display: none !important;
  }
}
.featured-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background-color: #ffbe33;
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.popular-badge {
    position: absolute;
    top: 8px; /* أسفل شارة is_featured */
    right: 8px;
    background-color: #ff4136; /* أحمر */
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    z-index: 5;
}

#search-suggestions {
    z-index: 1050 !important;
}

#searchInput {
    border: 2px solid #ffbe33 !important; /* أصفر */
    box-shadow: none !important;
}

#searchInput:focus {
    border-color: #ffbe33 !important;
    box-shadow: 0 0 4px rgba(255, 190, 51, 0.6) !important;
    outline: none !important;
}

#searchInput {
    background-color: #fffbe6; /* خلفية مائلة للأصفر */
}

</style>

<section class="food_section layout_padding-bottom">
    <div class="container">
                @if($featuredItems->count())
<div class="featured-section mb-5">
    <div class="heading_container heading_center mb-4">
        <h2>{{ __('messages.featured_items') }}</h2>
    </div>

    <div class="menu-grid">
        @foreach ($featuredItems as $item)
            <div class="menu-item {{ strtolower(str_replace(' ', '-', optional($item->category)->name)) }}" id="menu-item-{{ $item->id }}">
                <div class="card food-card position-relative">
                    @if($item->is_featured)
                        <div class="featured-badge">⭐</div>
                    @endif

                    <div class="food-img">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                    </div>
                    <div class="card-body">
                        <div>
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-price">${{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="card-buttons">
                            <button class="btn btn-detail open-menu-slide"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-description="{{ $item->description }}"
                                data-image="{{ asset('storage/' . $item->image) }}"
                                data-price="{{ $item->price }}"
                                data-options='{{ json_encode(
                                    $item->options->map(function ($option) {
                                        return [
                                            'name' => $option->name,
                                            'type' => $option->type,
                                            'values' => $option->values->map(function ($value) {
                                                    return [
                                                        'id' => $value->id,
                                                        'value' => $value->value,
                                                        'additional_price' => $value->additional_price,
                                                        'description' => $value->description, // ✅ أضف هذا السطر
                                                    ];
                                            })->values()->toArray()
                                        ];
                                    })->values()->toArray(),
                                    JSON_HEX_APOS | JSON_HEX_QUOT
                                ) }}'>
                                {{ __('messages.details') }}
                            </button>

                            <button class="btn btn-cart open-menu-slide"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-description="{{ $item->description }}"
                                data-image="{{ asset('storage/' . $item->image) }}"
                                data-price="{{ $item->price }}"
                                data-options='{{ json_encode(
                                    $item->options->map(function ($option) {
                                        return [
                                            'name' => $option->name,
                                            'type' => $option->type,
                                            'values' => $option->values->map(function ($value) {
                                                    return [
                                                        'id' => $value->id,
                                                        'value' => $value->value,
                                                        'additional_price' => $value->additional_price,
                                                        'description' => $value->description, // ✅ أضف هذا السطر
                                                    ];
                                            })->values()->toArray()
                                        ];
                                    })->values()->toArray(),
                                    JSON_HEX_APOS | JSON_HEX_QUOT
                                ) }}'>
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

        <div class="heading_container heading_center mb-5 mt-4">
            <h2>{{ __('messages.our_menu') }}</h2>
        </div>
        <!-- ✅ Search bar for menu -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <form id="searchForm" class="d-flex position-relative" onsubmit="return false;">
                    <input id="searchInput" class="form-control form-control-sm me-2" type="search" name="q"
                        placeholder="{{ __('messages.search') }}..." aria-label="Search">
                    <div id="search-suggestions" class="list-group position-absolute w-100 z-3 mt-1 d-none"
                        style="max-height: 250px; overflow-y:auto;"></div>
                    <button class="btn btn-sm btn-outline-warning" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ التصنيفات من جدول categories -->
        <ul class="filters_menu">
            <li class="active" data-filter="all">{{ __('messages.all') }}</li>
            @isset($categories)
            @foreach ($categories as $category)
                <li data-filter="{{ strtolower(str_replace(' ', '-', $category->name)) }}">
                    {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name }}
                </li>
            @endforeach
            @endisset
        
        </ul>

        <!-- ✅ عرض المنتجات مع التصنيف في الكلاس -->
        <div class="filters-content">
            <div class="menu-grid" id="menuItemsContainer">
                @foreach ($menuItems as $item)
                    <div class="menu-item {{ strtolower(str_replace(' ', '-', optional($item->category)->name)) }}" id="menu-item-{{ $item->id }}">
                        <div class="card food-card">
                                                @if($item->is_popular)
                                                    <div class="popular-badge">🔥</div>
                                                @endif        
                            <div class="food-img">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <div>
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-price">${{ number_format($item->price, 2) }}</p>
                                </div>
                                <div class="card-buttons">
<button class="btn btn-detail open-menu-slide"
    data-id="{{ $item->id }}"
    data-name="{{ $item->name }}"
    data-description="{{ $item->description }}"
    data-image="{{ asset('storage/' . $item->image) }}"
    data-price="{{ $item->price }}"
    data-options='{{ json_encode(
        $item->options->map(function ($option) {
            return [
                'name' => $option->name,
                'type' => $option->type,
                'values' => $option->values->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'value' => $value->value,
                            'additional_price' => $value->additional_price,
                            'description' => $value->description, // ✅ أضف هذا السطر
                        ];
                })->values()->toArray()
            ];
        })->values()->toArray(),
        JSON_HEX_APOS | JSON_HEX_QUOT
    ) }}'>
    {{ __('messages.details') }}
</button>

                                   <button class="btn btn-cart open-menu-slide"
    data-id="{{ $item->id }}"
    data-name="{{ $item->name }}"
    data-description="{{ $item->description }}"
    data-image="{{ asset('storage/' . $item->image) }}"
    data-price="{{ $item->price }}"
    data-options='{{ json_encode(
        $item->options->map(function ($option) {
            return [
                'name' => $option->name,
                'type' => $option->type,
                'values' => $option->values->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'value' => $value->value,
                            'additional_price' => $value->additional_price,
                            'description' => $value->description, // ✅ أضف هذا السطر
                        ];
                })->values()->toArray()
            ];
        })->values()->toArray(),
        JSON_HEX_APOS | JSON_HEX_QUOT
    ) }}'>
    <i class="fa fa-shopping-cart"></i>
</button>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="no-items-message">
                {{ __('messages.no_items') }}
            </div>


            <div class="pagination-container">
                <ul class="pagination" id="paginationContainer"></ul>
            </div>
        </div>
    </div>
    <!-- ✅ Slide Panel للـ Menu Item -->
<div id="menu-slide-panel" class="slide-panel">
    <div class="slide-header">
        <h5 id="menu-slide-title">Title</h5>
        <button id="menu-slide-close">&times;</button>
    </div>
    <div class="slide-content">
        <img id="menu-slide-image" src="" alt="Menu Item Image">
        <p id="menu-slide-description"></p>

        <!-- ✅ مكان الخيارات -->
        <div id="menu-slide-options" class="mt-3"></div>

        <!-- ✅ السعر الإجمالي -->
        <p class="slide-price mt-3 d-flex justify-content-between align-items-center">
            <strong>{{ __('messages.total') }}:</strong>
                <span dir="ltr" style="display:inline-block; min-width: 90px; text-align: start;">
                    <span id="menu-slide-price"></span> {{ __('messages.currency') }}
                </span>
            </p>

        <button id="menu-slide-add-to-cart" class="btn btn-cart mt-3" data-id="">
            {{ __('messages.add_to_cart') }}
        </button>
    </div>
</div>

</section>
<style>
    /* Improved slide panel styling */
#menu-slide-panel {
    position: fixed;
    top: 0;
    right: -400px;
    width: 400px;
    height: 100vh;
    background: #fff;
    box-shadow: -5px 0 20px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    transition: right 0.4s ease;
    display: flex;
    flex-direction: column;
}


#menu-slide-panel.open {
    right: 0;
}

/* ✅ محتوى السلايد */
#menu-slide-panel .slide-content {
    flex-grow: 1;
    overflow-y: auto;       /* فقط عمودي داخلي */
    overflow-x: hidden;     /* يمنع السكروول الجانبي */
    max-height: calc(100vh - 70px); /* يمنع تجاوز الشاشة */
    padding: 25px;
    box-sizing: border-box;
}

/* ✅ للصورة داخل السلايد */
#menu-slide-panel .slide-content img {
    width: 100%;
    height: auto;
    max-width: 100%;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 20px;
}

body.slide-open {
    overflow: hidden !important;
}

    @media (max-width: 576px) {
        #menu-slide-panel {
            width: 85%;
            right: -85%;
        }
    }

    #menu-slide-panel.open {
        right: 0;
    }

    #menu-slide-panel .slide-header {
        padding: 18px 20px;
        background: #ffbe33;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    #menu-slide-panel .slide-header h5 {
        font-weight: 600;
        margin: 0;
        font-size: 18px;
    }

    #menu-slide-panel .slide-content {
        padding: 25px;
        overflow-y: auto;
        flex-grow: 1;
        overflow-y: auto;
        overflow-x: hidden; 
            /* السكروول شغال لكن مخفي */
    overflow-y: scroll;
    scrollbar-width: none;         /* Firefox */
    -ms-overflow-style: none; 
    padding-bottom: 90px !important;  
    }

    #menu-slide-panel .slide-content img {
        width: 100%;
        border-radius: 12px;
        margin-bottom: 20px;
        height: 200px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    #menu-slide-panel #menu-slide-description {
        color: #555;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 15px;
    }

    #menu-slide-panel .slide-price {
        font-weight: bold;
        color: #222831;
        font-size: 20px;
        padding: 10px 0;
        border-top: 1px solid #eee;
        margin-top: 15px;
    }

    #menu-slide-close {
        background: transparent;
        border: none;
        font-size: 28px;
        color: white;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    #menu-slide-close:hover {
        transform: rotate(90deg);
    }

    /* Improved options styling */
    .menu-option-group {
        margin-bottom: 20px;
        background: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
    }

    .menu-option-group label {
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
        color: #333;
        font-size: 16px;
    }

    .menu-option-checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px 0;
    }

    .menu-option-checkbox input {
        margin-right: 12px;
        transform: scale(1.2);
    }
    
    .menu-option-checkbox input[type="checkbox"],
    .menu-option-checkbox input[type="radio"] {
        accent-color: #ffbe33 ;
        appearance: auto;
    }

    /* Add to cart button in slide panel */
    #menu-slide-add-to-cart {
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

    #menu-slide-add-to-cart:hover {
        background-color: #f0aa18;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 190, 51, 0.4);
    }

    #menu-slide-add-to-cart::before {
        content: '\f07a';
        font-family: 'FontAwesome';
        font-size: 18px;
    }
    .swal2-container.mt-header-padding {
    top: 80px !important; /* أو حسب ارتفاع الهيدر عندك */
    left: 10px !important; /* شوي يمين لحتى ما يلتصق */
}
/* ✅ تحسين تصنيفات الفئات في الموبايل */
@media (max-width: 768px) {
    .filters_menu {
        flex-wrap: nowrap !important;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 10px;
        margin: 0 auto 25px;
        justify-content: flex-start !important;
    }

    .filters_menu li {
        flex: 0 0 auto;
        white-space: nowrap;
        padding: 6px 16px;
        margin: 0 6px;
        font-size: 14px;
        border-radius: 20px;
        background: #f1faee;
        transition: 0.3s;
    }

    .filters_menu li.active {
        background: #ffbe33;
        color: white;
    }
    .filters_menu {
    box-shadow: inset -10px 0 10px -10px rgba(0,0,0,0.1);
}
@media (max-width: 576px) {
    .food_section .search-box input {
        width: 80% !important; /* أو أي نسبة أصغر تناسب الشكل */
        font-size: 14px;
        padding: 6px 10px;
    }

    .food_section .search-box {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }

    .food_section .search-box button {
        padding: 6px 10px;
    }
}

}

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery + Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('input[name="q"]');
    const suggestionBox = document.getElementById('search-suggestions');
    let timer;

    input.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(timer);

        if (query.length < 2) {
            suggestionBox.classList.add('d-none');
            return;
        }

        timer = setTimeout(() => {
            fetch(`/search/ajax?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';

                    if (data.menuItems.length === 0) {
                        suggestionBox.classList.add('d-none');
                        return;
                    }

                    data.menuItems.forEach(item => {
                        const link = document.createElement('a');
                        link.className = 'list-group-item list-group-item-action';
                        link.textContent = item.name;
                        
                        link.addEventListener('click', function (e) {
                            e.preventDefault();
                            navigateToMenuItem(item);
                        });
                        
                        suggestionBox.appendChild(link);
                    });

                    suggestionBox.classList.remove('d-none');
                })
                .catch(err => {
                    console.error('Search error:', err);
                    suggestionBox.classList.add('d-none');
                });
        }, 300);
    });

    // وظیفة للتنقل إلى العنصر المطلوب
    function navigateToMenuItem(item) {
        const targetId = `menu-item-${item.id}`;
        
        // أخفي نتائج البحث أولاً
        suggestionBox.innerHTML = '';
        suggestionBox.classList.add('d-none');
        input.value = ''; // امسح النص من مربع البحث

        // ابحث عن العنصر في جميع العناصر
        const targetElement = document.getElementById(targetId);
        
        if (!targetElement) {
            console.warn(`Element with ID ${targetId} not found`);
            return;
        }

        // احصل على فئة العنصر من الكلاسات
        const classList = Array.from(targetElement.classList);
        const categoryClass = classList.find(c => c !== 'menu-item' && c !== 'highlight-search-result');

        if (categoryClass) {
            // فعّل الفئة المطلوبة
            activateCategory(categoryClass);
            
            // انتظر قليلاً حتى يتم تطبيق الفلترة ثم انتقل للعنصر
            setTimeout(() => {
                scrollToElement(targetElement);
            }, 500);
        } else {
            // إذا لم نجد فئة محددة، انتقل للعنصر مباشرة
            scrollToElement(targetElement);
        }
    }

    // وظيفة لتفعيل الفئة
    function activateCategory(categoryClass) {
        const filterButtons = document.querySelectorAll('.filters_menu li');
        
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
            const filter = btn.getAttribute('data-filter');
            
            if (filter === categoryClass || filter === `.${categoryClass}`) {
                btn.classList.add('active');
                // اضغط على الزر لتفعيل الفلترة
                btn.click();
            }
        });
    }

    // وظيفة للانتقال للعنصر مع التمييز
    function scrollToElement(element) {
        // تحقق من وجود العنصر وأنه مرئي
        const checkVisibility = () => {
            if (element && element.offsetParent !== null) {
                // انتقل للعنصر
                element.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center',
                    inline: 'nearest'
                });
                
                // أضف تمييز بصري
                element.classList.add('highlight-search-result');
                
                // أزل التمييز بعد فترة
                setTimeout(() => {
                    element.classList.remove('highlight-search-result');
                }, 2000);
                
                return true;
            }
            return false;
        };

        // جرب الانتقال فوراً
        if (!checkVisibility()) {
            // إذا لم يكن مرئياً، تحقق كل 100ms لمدة 5 ثوان
            let attempts = 0;
            const maxAttempts = 50; // 5 ثوان
            
            const interval = setInterval(() => {
                attempts++;
                
                if (checkVisibility() || attempts >= maxAttempts) {
                    clearInterval(interval);
                    
                    if (attempts >= maxAttempts) {
                        console.warn('Could not scroll to element after maximum attempts');
                    }
                }
            }, 100);
        }
    }

    // إغلاق القائمة عند الضغط خارجها
    document.addEventListener('click', function (e) {
        if (!suggestionBox.contains(e.target) && e.target !== input) {
            suggestionBox.classList.add('d-none');
        }
    });

    // إغلاق القائمة عند الضغط على Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            suggestionBox.classList.add('d-none');
            input.blur(); // إزالة التركيز من مربع البحث
        }
    });
});
</script>

<script>
    if (!localStorage.getItem('cart')) {
    sessionStorage.removeItem('cart');
}

    function updateCartCount(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        if (count > 0) {
            cartCountElement.classList.add('show');
        } else {
            cartCountElement.classList.remove('show');
        }
    }
}

    document.addEventListener('DOMContentLoaded', function() {
        const cartBody = document.getElementById('cart-body');

        if (cartBody) {
        cartBody.addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            if (!row) return;

            const itemId = row.dataset.id;
            const qtySpan = row.querySelector('.qty-number');
            const subtotalTd = row.querySelector('.item-subtotal');
            let quantity = parseInt(qtySpan.textContent);

            if (e.target.classList.contains('qty-plus')) {
                quantity++;
                animateButton(e.target);
                updateCartItem(itemId, quantity);
            } else if (e.target.classList.contains('qty-minus')) {
                if (quantity > 1) {
                    quantity--;
                    animateButton(e.target);
                    updateCartItem(itemId, quantity);
                }
            } else if (e.target.classList.contains('btn-remove')) {
                animateButton(e.target);
                row.classList.add('cart-row-remove');
                setTimeout(() => {
                    updateCartItem(itemId, 0);
                }, 200);
                return;
            }

            // تحديث واجهة المستخدم مباشرة
            qtySpan.textContent = quantity;
            const price = parseFloat(row.children[1].textContent.replace('$', ''));
            subtotalTd.textContent = `$${(price * quantity).toFixed(2)}`;
        });
        }
        function updateCartItem(id, quantity) {
    const url = quantity === 0 ? "{{ route('cart.remove') }}" : "{{ route('cart.add') }}";

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            menu_item_id: id,
            quantity
        })
    })
    .then(res => res.json())
    .then(data => {
        const totalEl = document.getElementById('cart-total');
        totalEl.textContent = data.total.toFixed(2);
        totalEl.classList.add('animate');
        setTimeout(() => totalEl.classList.remove('animate'), 400);

        // ✅ تحديث عداد السلة في الـ header
        updateCartCount(data.count);


        // حذف العنصر إذا الكمية 0
        if (quantity === 0) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.remove();
            }

            if (document.querySelectorAll('#cart-body tr[data-id]').length === 0) {
                showEmptyCartMessage();
            }
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        showNotification('Error updating cart. Please try again.', 'error');
    });
}


        function showEmptyCartMessage() {
            // Hide totals section
            const totalsSection = document.getElementById('cart-totals-section');
            if (totalsSection) {
                totalsSection.style.display = 'none';
            }

            // Check if empty message already exists
            if (!document.getElementById('empty-cart-row')) {
                const emptyRow = document.createElement('tr');
                emptyRow.id = 'empty-cart-row';
                emptyRow.innerHTML = `
        <td colspan="5" class="py-4">
          <div class="text-center">
            <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
            <h5>Your cart is empty</h5>
            <p class="text-muted">Add some delicious items from our menu!</p>
            <a href="{{ route('menu') }}" class="btn btn-warning mt-3">Browse Menu</a>
          </div>
        </td>
      `;
                cartBody.appendChild(emptyRow);
            }
        }

        function animateButton(button) {
            button.classList.add('scale');
            setTimeout(() => button.classList.remove('scale'), 200);
        }

        function showNotification(message, type = 'success') {
            // Check if toast container exists
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            // Create toast
            const toast = document.createElement('div');
            toast.className = `toast ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
      <div class="toast-header ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white">
        <strong class="me-auto">${type === 'error' ? 'Error' : 'Success'}</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        ${message}
      </div>
    `;

            toastContainer.appendChild(toast);

            // Initialize and show with Bootstrap
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            // Remove after hidden
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }
    });
    $(document).ready(function () {
    // ✅ استخدم التفويض بشكل دائم
    $(document).on('click', '.add-to-cart-btn', function (e) {
        e.preventDefault();

        let itemId = $(this).data('id');

        $.ajax({
            url: "{{ route('cart.add-ajax') }}",
            method: "POST",
            data: {
                menu_item_id: itemId,
                quantity: 1,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                $('#cart-count').text(response.count);
                updateCartCount(response.count);
                $('.cart-count').each(function () {
                    $(this).text(response.count);

                    if (response.count > 0) {
                        $(this).addClass('show');
                    } else {
                        $(this).removeClass('show');
                    }

                    $(this).addClass('pulse');
                    setTimeout(() => $(this).removeClass('pulse'), 500);
                });

                Swal.fire({
                    toast: true,
                    position: 'top-start',
                    target: 'body', // مهم عشان التوست ينزل عن بداية الصفحة
                        customClass: {
                            container: 'mt-header-padding' // نحدد كلاس خاص
                        },
                    icon: 'success',
                    title: "{{ __('messages.item_added') }}",
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            error: function () {
                Swal.fire(
                    "{{ __('messages.error_title') }}",
                    "{{ __('messages.something_wrong') }}",
                    'error'
                );
            }
        });
    });
});


</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ITEMS_PER_PAGE = window.innerWidth <= 768 ? 999 : 20; // عدد العناصر في كل صفحة
        let currentPage = 1;
        let currentFilter = 'all';
        let filteredItems = [];

        // احصل على جميع عناصر القائمة
        const menuItems = document.querySelectorAll('.menu-item');

        // الكود الإضافي لإزالة اللون الأزرق عند النقر
        document.addEventListener('click', function(e) {
            // إذا كان العنصر المنقور يحتوي على فئة page-link
            if (e.target.classList.contains('page-link') || e.target.parentElement.classList.contains(
                    'page-link')) {
                // إلغاء التركيز بعد النقر مباشرة
                setTimeout(function() {
                    if (document.activeElement) {
                        document.activeElement.blur();
                    }
                }, 10);
            }
        });

        // تابع لتصفية العناصر وتحديثها
        function applyFilter(filter) {
            currentFilter = filter;
            currentPage = 1; // إعادة تعيين الصفحة الحالية عند تغيير الفلتر
            filteredItems = [];

            // قم بتصفية العناصر بناءً على الفلتر المحدد
            menuItems.forEach(item => {
                // إزالة كلاس الفلترة السابق
                item.classList.remove('filtered-out');

                if (filter === 'all' || item.classList.contains(filter)) {
                    // إضافة العنصر إلى القائمة المصفاة
                    filteredItems.push(item);
                } else {
                    // إضافة كلاس للعناصر غير المطابقة
                    item.classList.add('filtered-out');
                }
            });

            // إظهار رسالة إذا لم توجد عناصر
            const noItemsMessage = document.querySelector('.no-items-message');
            if (filteredItems.length === 0) {
                if (noItemsMessage) noItemsMessage.style.display = 'block';
                // إخفاء الصفحات إذا لم تكن هناك عناصر
                document.querySelector('.pagination-container').style.display = 'none';
            } else {
                if (noItemsMessage) noItemsMessage.style.display = 'none';
                document.querySelector('.pagination-container').style.display = 'flex';
            }

            // تحديث العناصر المعروضة وأزرار الصفحات
            updatePagination();
            showItemsForCurrentPage();

            // Re-bind Add to Cart event after filter/pagination updates
$('.add-to-cart-btn').off('click').on('click', function (e) {
    e.preventDefault();
    let itemId = $(this).data('id');

    $.ajax({
        url: "{{ route('cart.add-ajax') }}",
        method: "POST",
        data: {
            menu_item_id: itemId,
            quantity: 1,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            $('.cart-count').each(function () {
                $(this).text(response.count);

                if (response.count > 0) {
                    $(this).addClass('show');
                } else {
                    $(this).removeClass('show');
                }

                $(this).addClass('pulse');
                setTimeout(() => $(this).removeClass('pulse'), 500);
            });

            Swal.fire({
                toast: true,
                position: 'top-start',
                target: 'body', // مهم عشان التوست ينزل عن بداية الصفحة
                    customClass: {
                        container: 'mt-header-padding' // نحدد كلاس خاص
                    },
                icon: 'success',
                title: "{{ __('messages.item_added') }}",
                showConfirmButton: false,
                timer: 1000
            });
        },
        error: function () {
            Swal.fire(
                "{{ __('messages.error_title') }}",
                "{{ __('messages.something_wrong') }}",
                'error'
            );
        }
    });
});

        }

        // تابع لعرض العناصر للصفحة الحالية
        function showItemsForCurrentPage() {
            // إخفاء جميع العناصر أولاً
            filteredItems.forEach(item => {
                item.style.display = 'none';
            });

            // احسب بداية ونهاية العناصر للصفحة الحالية
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, filteredItems.length);

            // أظهر العناصر للصفحة الحالية فقط
            for (let i = startIndex; i < endIndex; i++) {
                filteredItems[i].style.display = '';
            }
        }

        // تابع لتحديث أزرار التنقل بين الصفحات
        function updatePagination() {
            const paginationContainer = document.getElementById('paginationContainer');
            paginationContainer.innerHTML = '';

            // احسب إجمالي عدد الصفحات
            const totalPages = Math.ceil(filteredItems.length / ITEMS_PER_PAGE);

            if (totalPages <= 1) {
                // إذا كانت هناك صفحة واحدة فقط، لا داعي لعرض أزرار التنقل
                return;
            }

            // أضف زر "السابق"
            const prevLi = document.createElement('li');
            prevLi.className = currentPage === 1 ? 'page-item disabled' : 'page-item';
            const prevLink = document.createElement('a');
            prevLink.className = 'page-link';
            prevLink.href = '#';
            prevLink.innerHTML = '<span class="page-link-icon">&laquo;</span>';
            prevLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            });
            prevLi.appendChild(prevLink);
            paginationContainer.appendChild(prevLi);

            // أضف أزرار الصفحات
            const maxVisiblePages = 5; // عدد الصفحات المرئية في شريط التنقل
            const halfVisible = Math.floor(maxVisiblePages / 2);

            let startPage = Math.max(1, currentPage - halfVisible);
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            // ضبط startPage إذا كان endPage قد وصل إلى الحد الأقصى
            if (endPage === totalPages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // إضافة زر الصفحة الأولى إذا لم تكن مرئية
            if (startPage > 1) {
                const firstLi = document.createElement('li');
                firstLi.className = 'page-item';
                const firstLink = document.createElement('a');
                firstLink.className = 'page-link';
                firstLink.href = '#';
                firstLink.innerHTML = '<span class="page-link-text">1</span>';
                firstLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToPage(1);
                });
                firstLi.appendChild(firstLink);
                paginationContainer.appendChild(firstLi);

                // إضافة فاصل إذا كانت هناك مسافة
                if (startPage > 2) {
                    const ellipsisLi = document.createElement('li');
                    ellipsisLi.className = 'page-item disabled';
                    const ellipsisSpan = document.createElement('span');
                    ellipsisSpan.className = 'page-link';
                    ellipsisSpan.innerHTML = '<span class="page-link-text">...</span>';
                    ellipsisLi.appendChild(ellipsisSpan);
                    paginationContainer.appendChild(ellipsisLi);
                }
            }

            // إضافة أزرار الصفحات الوسطى
            for (let i = startPage; i <= endPage; i++) {
                const pageLi = document.createElement('li');
                pageLi.className = i === currentPage ? 'page-item active' : 'page-item';
                const pageLink = document.createElement('a');
                pageLink.className = 'page-link';
                pageLink.href = '#';
                pageLink.innerHTML = '<span class="page-link-text">' + i + '</span>';
                pageLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToPage(i);
                });
                pageLi.appendChild(pageLink);
                paginationContainer.appendChild(pageLi);
            }

            // إضافة زر الصفحة الأخيرة إذا لم تكن مرئية
            if (endPage < totalPages) {
                // إضافة فاصل إذا كانت هناك مسافة
                if (endPage < totalPages - 1) {
                    const ellipsisLi = document.createElement('li');
                    ellipsisLi.className = 'page-item disabled';
                    const ellipsisSpan = document.createElement('span');
                    ellipsisSpan.className = 'page-link';
                    ellipsisSpan.innerHTML = '<span class="page-link-text">...</span>';
                    ellipsisLi.appendChild(ellipsisSpan);
                    paginationContainer.appendChild(ellipsisLi);
                }

                const lastLi = document.createElement('li');
                lastLi.className = 'page-item';
                const lastLink = document.createElement('a');
                lastLink.className = 'page-link';
                lastLink.href = '#';
                lastLink.innerHTML = '<span class="page-link-text">' + totalPages + '</span>';
                lastLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    goToPage(totalPages);
                });
                lastLi.appendChild(lastLink);
                paginationContainer.appendChild(lastLi);
            }

            // أضف زر "التالي"
            const nextLi = document.createElement('li');
            nextLi.className = currentPage === totalPages ? 'page-item disabled' : 'page-item';
            const nextLink = document.createElement('a');
            nextLink.className = 'page-link';
            nextLink.href = '#';
            nextLink.innerHTML = '<span class="page-link-icon">&raquo;</span>';
            nextLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    goToPage(currentPage + 1);
                }
            });
            nextLi.appendChild(nextLink);
            paginationContainer.appendChild(nextLi);
        }

        // تابع للانتقال إلى صفحة محددة
        function goToPage(page) {
            currentPage = page;
            showItemsForCurrentPage();
            updatePagination();

            // التمرير إلى أعلى قسم القائمة
            const menuSection = document.querySelector('.food_section');
            if (menuSection) {
                menuSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // إضافة مستمعي الأحداث لأزرار التصفية
        const filterButtons = document.querySelectorAll('.filters_menu li');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // إزالة الكلاس active من جميع الأزرار
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // إضافة الكلاس active للزر المختار
                this.classList.add('active');

                // الحصول على الفلتر المطلوب وتطبيقه
                const filter = this.getAttribute('data-filter');
                applyFilter(filter);
            });
        });

        // تطبيق الفلتر الافتراضي عند تحميل الصفحة (عرض الكل)
        applyFilter('all');
    });

</script>
<script>
    function calculateTotal(itemId, basePrice) {
        let total = parseFloat(basePrice);

        document.querySelectorAll(`#optionsForm${itemId} .option-checkbox:checked`).forEach(cb => {
            total += parseFloat(cb.dataset.price || 0);
        });

        document.getElementById(`modalTotal${itemId}`).textContent = `${total.toFixed(2)} JOD`;
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('option-checkbox')) {
            const itemId = e.target.dataset.itemId;
            const basePrice = parseFloat(document.querySelector(`#itemModal${itemId} .card-price`)?.dataset?.price || 0) || parseFloat(document.querySelector(`#modalTotal${itemId}`).textContent) || 0;
            calculateTotal(itemId, basePrice);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const panel = document.getElementById('menu-slide-panel');
        const closeBtn = document.getElementById('menu-slide-close');
        const addToCartBtn = document.getElementById('menu-slide-add-to-cart');
        const optionsContainer = document.getElementById('menu-slide-options');
        const totalPriceEl = document.getElementById('menu-slide-price');

        let basePrice = 0;

        // ✅ فتح السلايد
            document.querySelectorAll('.open-menu-slide').forEach(button => {
                button.addEventListener('click', () => {
                    let options = [];
                    try {
                        options = JSON.parse(button.dataset.options);
                        if (!Array.isArray(options)) {
                            options = [];
                        }
                    } catch (e) {
                        options = [];
                    }

                    basePrice = parseFloat(button.dataset.price);

                    // تعبئة البيانات
                    document.getElementById('menu-slide-title').textContent = button.dataset.name;
                    document.getElementById('menu-slide-description').textContent = button.dataset.description || '';
                    document.getElementById('menu-slide-image').src = button.dataset.image;
                    totalPriceEl.textContent = basePrice.toFixed(2);
                    // تحقق إذا السعر 0 فعطّل الزر
                    if (basePrice <= 0) {
                        addToCartBtn.disabled = true;
                        addToCartBtn.style.opacity = 0.6;
                        addToCartBtn.style.cursor = 'not-allowed';
                    } else {
                        addToCartBtn.disabled = false;
                        addToCartBtn.style.opacity = 1;
                        addToCartBtn.style.cursor = 'pointer';
                    }
                    addToCartBtn.setAttribute('data-id', button.dataset.id);

                    // عرض الخيارات
                    // عرض الخيارات داخل السلايد
                    optionsContainer.innerHTML = '';
                    options.forEach(option => {
                        if (!Array.isArray(option.values)) return;

                        const group = document.createElement('div');
                        group.className = 'menu-option-group';
                        group.innerHTML = `<label>${option.name}</label>`;

                        option.values.forEach(value => {
                            const inputType = option.type === 'radio' ? 'radio' : 'checkbox'; // ✅ استنادًا إلى نوع الخيار
                            const inputName = `option_${option.name.replace(/\s+/g, '_')}`;    // ✅ ضروري لتجميع الراديو معًا

                            const row = document.createElement('div');
                            row.className = 'menu-option-checkbox';
                            row.innerHTML = `
                                <input type="${inputType}" name="${inputName}" class="option-checkbox" 
                                    data-id="${value.id}" 
                                    data-price="${value.additional_price || 0}">
                                    <span>
                                    <strong>${value.value}</strong>
                                    ${value.description ? `<br><small style="color:#666">${value.description}</small>` : ''}
                                    ${value.additional_price > 0 ? `<br><small style="color:#999">+${value.additional_price} JOD</small>` : ''}
                                    </span>                            `;
                            group.appendChild(row);
                        });

                        optionsContainer.appendChild(group);
                    });

                    // فتح السلايد
                    panel.classList.add('open');
                    document.body.classList.add('slide-open');
                });
            });

        // ✅ إغلاق السلايد
        closeBtn.addEventListener('click', () => {
            panel.classList.remove('open');
            document.body.classList.remove('slide-open');
        });

        // ✅ تحديث السعر عند اختيار الإضافات
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('option-checkbox')) {
        let total = basePrice;
        document.querySelectorAll('.option-checkbox:checked').forEach(cb => {
            total += parseFloat(cb.dataset.price || 0);
        });

        totalPriceEl.textContent = total.toFixed(2);

        // ✅ تعطيل أو تفعيل الزر بناءً على السعر
        if (total > 0) {
            addToCartBtn.disabled = false;
            addToCartBtn.style.opacity = 1;
            addToCartBtn.style.cursor = 'pointer';
        } else {
            addToCartBtn.disabled = true;
            addToCartBtn.style.opacity = 0.6;
            addToCartBtn.style.cursor = 'not-allowed';
        }
    }
});


        // ✅ عند الضغط على Add to Cart
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
        document.body.classList.remove('slide-open');

        Swal.fire({
            toast: true,
            position: 'top-start',
            target: 'body', // مهم عشان التوست ينزل عن بداية الصفحة
                customClass: {
                    container: 'mt-header-padding' // نحدد كلاس خاص
                },
            icon: 'success',
            title: "{{ __('messages.item_added') }}",
            showConfirmButton: false,
            timer: 1000
        });
    })
    .catch(() => {
        Swal.fire(
            "{{ __('messages.error_title') }}",
            "{{ __('messages.something_wrong') }}",
            'error'
        );
    });
});

    });
</script>
<script>
    // ✅ تأكد ما نرجع cart من localStorage إذا مش موجود
    if (!localStorage.getItem('cart')) {
        sessionStorage.removeItem('cart');
    }
</script>

