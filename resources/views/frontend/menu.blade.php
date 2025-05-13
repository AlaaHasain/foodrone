@extends('layouts.app')

@section('title', 'QR Menu')

@section('content')
<style>
    /* Overall menu styling */
    .qr-menu-container {
        max-width: 100%;
        padding: 10px;
        background-color: #f8fdf7;
        min-height: calc(100vh - 60px);
    }
    
    /* Restaurant branding area */
    .restaurant-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    
    .restaurant-logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 10px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    .restaurant-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .restaurant-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #2a5f2d;
    }
    
    .table-info {
        font-size: 16px;
        font-weight: 600;
        color: #3e8e41;
        margin-bottom: 8px;
    }
    
    /* Category scrolling tabs */
    .category-tabs-container {
        position: sticky;
        top: 0;
        z-index: 100;
        background-color: rgba(248, 253, 247, 0.95);
        padding: 10px 0;
        margin-bottom: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    
    .category-tabs {
        display: flex;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 5px;
    }
    
    .category-tabs::-webkit-scrollbar {
        display: none;
    }
    
    .category-tab {
        flex: 0 0 auto;
        padding: 8px 16px;
        border-radius: 20px;
        background-color: white;
        border: 1px solid rgba(62, 142, 65, 0.2);
        font-weight: 600;
        color: #2a5f2d;
        cursor: pointer;
        transition: 0.3s ease;
        margin-right: 8px;
        white-space: nowrap;
        font-size: 14px;
    }
    
    .category-tab.active,
    .category-tab:hover {
        background-color: #3e8e41;
        color: white;
        box-shadow: 0 4px 8px rgba(62, 142, 65, 0.3);
        transform: translateY(-2px);
    }
    
    /* Category headers */
    .category-header {
        margin: 25px 0 10px;
        padding-bottom: 8px;
        border-bottom: 2px solid rgba(62, 142, 65, 0.2);
        font-size: 18px;
        font-weight: 700;
        color: #2a5f2d;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .see-all {
        font-size: 12px;
        color: #3e8e41;
        text-decoration: none;
    }
    
    /* Horizontal scrolling menu items */
    .menu-items-scroll {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
        gap: 12px;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }
    
    .menu-items-scroll::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Edge */
    }
    
    /* Smaller menu card styling for horizontal scrolling */
    .menu-card {
        flex: 0 0 160px; /* Fixed width for cards */
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        transition: 0.3s;
        height: 220px; /* Fixed height */
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(62, 142, 65, 0.08);
        margin-bottom: 5px;
    }
    
    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(62, 142, 65, 0.15);
    }
    
    .menu-card-img {
        position: relative;
        width: 100%;
        height: 100px; /* Fixed height for image */
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
        transform: scale(1.05);
    }
    
    .menu-card-body {
        padding: 10px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .menu-card-body h5 {
        margin: 0 0 5px;
        font-size: 15px;
        font-weight: 700;
        color: #2a5f2d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .menu-card-body p.description {
        font-size: 12px;
        margin-bottom: 8px;
        color: #555;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 32px; /* Limit height */
    }
    
    .menu-card-footer {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .price {
        font-weight: bold;
        font-size: 14px;
        color: #3e8e41;
    }
    
    .card-buttons {
        display: flex;
        gap: 5px;
    }
    
    .cart-btn {
        padding: 5px 8px;
        background-color: #3e8e41;
        color: white;
        border: none;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
        flex: 1;
    }
    
    .cart-btn:hover {
        background-color: #2a5f2d;
        transform: translateY(-2px);
    }
    
    /* Category badges */
    .category-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 255, 255, 0.92);
        color: #2a5f2d;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Special tags */
    .special-tag {
        display: inline-block;
        margin-right: 3px;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 8px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .special-tag.new {
        background-color: #3e8e41;
        color: white;
    }
    
    .special-tag.popular {
        background-color: #e67e22;
        color: white;
    }
    
    .special-tag.spicy {
        background-color: #e74c3c;
        color: white;
    }
    
    /* Empty state */
    .empty-category {
        text-align: center;
        padding: 20px;
        color: #888;
    }
    
    .small-btn {
        padding: 5px 8px;
        font-size: 11px;
        border-radius: 10px;
    }
    
    .floating-cart {
        position: fixed;
        bottom: 70px;
        right: 15px;
        width: 50px;
        height: 50px;
        background-color: #3e8e41;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: grab;
        z-index: 1000;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        font-size: 18px;
    }
    
    .floating-cart:active {
        cursor: grabbing;
    }
    
    .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 2px 5px;
        border-radius: 50%;
    }
    
    /* Modal adjustments */
    .modal.fade .modal-dialog {
        transition: transform 0.1s ease-out !important;
    }
    
    .modal-backdrop.show {
        opacity: 8 !important;
        transition: none !important;
    }
    
    /* Grid view for filtered categories */
    .menu-items-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    @media (min-width: 540px) {
        .menu-items-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .menu-card {
            flex: 0 0 180px;
        }
    }
</style>

<div class="qr-menu-container">
    <!-- Restaurant Header -->
    <div class="restaurant-header">
        <div class="restaurant-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Restaurant Logo">
        </div>
        <h1 class="restaurant-title">{{ config('app.name') }}</h1>
        <div class="table-info">Table #{{ $table->table_number }}</div>
    </div>
    
    <!-- Category Tabs -->
    <div class="category-tabs-container">
        <div class="category-tabs">
            <button class="category-tab active" data-category="all">All Menu</button>
            @foreach($categories as $category)
                @if($category->menuItems->count())
                    <button class="category-tab" data-category="cat-{{ $category->id }}">{{ $category->name }}</button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- All Menu Items View -->
    <div id="allMenuView">
        @foreach($categories as $category)
            @if($category->menuItems->count())
                <div class="category-header">
                    <span>{{ $category->name }}</span>
                    <a href="#" class="see-all" data-category="cat-{{ $category->id }}">See All</a>
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
                                        <button class="cart-btn small-btn open-item-modal" data-id="{{ $item->id }}">
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

<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="itemModalTitle">Item Name</h5>
          <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="itemModalBody">
          <div class="text-center">
            <img id="itemModalImage" class="img-fluid rounded mb-3" style="max-height: 200px;">
          </div>
          <p id="itemModalDescription"></p>
          <p><strong>Price: </strong><span id="itemModalPrice"></span> JOD</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="addToCartBtn">Add to Cart</button>
        </div>
      </div>
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
    // Handle cart dragging functionality
    const floatingCart = document.getElementById("floating-cart");
    let isDragging = false;
    let offsetX, offsetY;

    // Set initial position to make it draggable
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

    // For touch devices
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

    // Handle cart click (not during drag)
    let wasJustDragging = false;
    floatingCart.addEventListener("click", function () {
        if (!wasJustDragging) {
            window.location.href = "/qr/cart?token={{ $token }}";
        }
        wasJustDragging = false;
    });

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
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

                    // Update cart counter
                    let cartCounter = document.getElementById('floating-cart-count');
                    let currentCount = parseInt(cartCounter.textContent) || 0;
                    cartCounter.textContent = currentCount + 1;
                }
            });
        });
    });

    // Handle item modal opening
    document.querySelectorAll('.open-item-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const itemId = this.getAttribute('data-id');

            fetch(`/qr/item/${itemId}`)
                .then(res => res.json())
                .then(item => {
                    document.getElementById('itemModalTitle').textContent = item.name;
                    document.getElementById('itemModalDescription').textContent = item.description || 'No description';
                    document.getElementById('itemModalPrice').textContent = parseFloat(item.price).toFixed(2);
                    document.getElementById('itemModalImage').src = `/storage/${item.image}`;
                    document.getElementById('addToCartBtn').setAttribute('data-id', item.id);

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('itemDetailModal'));
                    modal.show();
                });
        });
    });

    // Add to cart from modal
    document.getElementById('addToCartBtn').addEventListener('click', function () {
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

                // Update cart counter
                let cartCounter = document.getElementById('floating-cart-count');
                let currentCount = parseInt(cartCounter.textContent) || 0;
                cartCounter.textContent = currentCount + 1;
            }
        });
    });

    // Category filtering
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            
            if (category === 'all') {
                // Show all menu view
                document.getElementById('allMenuView').style.display = 'block';
                document.getElementById('categoryFilteredView').style.display = 'none';
            } else {
                // Filter items for the selected category
                document.getElementById('allMenuView').style.display = 'none';
                
                const filteredView = document.getElementById('categoryFilteredView');
                filteredView.style.display = 'block';
                
                // Clear previous items
                const itemsGrid = filteredView.querySelector('.menu-items-grid');
                itemsGrid.innerHTML = '';
                
                // Clone items of the selected category and append to grid
                document.querySelectorAll(`.menu-item.${category}`).forEach(item => {
                    const clone = item.cloneNode(true);
                    itemsGrid.appendChild(clone);
                });
                
                // Re-attach event listeners to cloned elements
                filteredView.querySelectorAll('.add-to-cart-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        // Reuse existing cart adding code
                        addToCart(itemId);
                    });
                });
                
                filteredView.querySelectorAll('.open-item-modal').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-id');
                        openItemModal(itemId);
                    });
                });
            }
        });
    });

    // See All category links
    document.querySelectorAll('.see-all').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.getAttribute('data-category');
            document.querySelector(`.category-tab[data-category="${category}"]`).click();
        });
    });

    // Helper functions for reuse
    function addToCart(itemId) {
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
                let currentCount = parseInt(cartCounter.textContent) || 0;
                cartCounter.textContent = currentCount + 1;
            }
        });
    }

    function openItemModal(itemId) {
        fetch(`/qr/item/${itemId}`)
            .then(res => res.json())
            .then(item => {
                document.getElementById('itemModalTitle').textContent = item.name;
                document.getElementById('itemModalDescription').textContent = item.description || 'No description';
                document.getElementById('itemModalPrice').textContent = parseFloat(item.price).toFixed(2);
                document.getElementById('itemModalImage').src = `/storage/${item.image}`;
                document.getElementById('addToCartBtn').setAttribute('data-id', item.id);

                const modal = new bootstrap.Modal(document.getElementById('itemDetailModal'));
                modal.show();
            });
    }
});
</script>
@endsection