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
        height: 150px;
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

    /* تنسيق Pagination */
    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .pagination li {
        margin: 0;
    }

    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 15px;
        border: none;
        background-color: white;
        color: #555;
        font-weight: 500;
        transition: all 0.3s ease;
        /* إزالة اللون الأزرق تحت الروابط */
        text-decoration: none !important;
        outline: none !important;
    }

    .pagination li.active a,
    .pagination li.active span {
        background-color: #ffbe33;
        color: white;
    }

    .pagination li a:hover:not(.active) {
        background-color: #f1faee;
        color: #333;
    }

    .pagination .disabled span,
    .pagination .disabled a {
        color: #ccc;
        cursor: not-allowed;
    }

    .pagination .page-link-text {
        font-size: 14px;
    }

    .pagination .page-link-icon {
        font-size: 18px;
        line-height: 1;
    }

    /* إزالة التأثير الأزرق من أزرار التنقل */
    .pagination .page-link,
    .pagination li a,
    .pagination li a:focus,
    .pagination li a:active,
    .pagination li span {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* إزالة التأثير الأزرق عند النقر والحركة */
    .pagination li a:focus,
    .pagination li a:active {
        background-color: inherit;
    }

    /* تعديل لون الزر النشط لتفادي اللون الأزرق */
    .pagination li.active a:focus,
    .pagination li.active a:active {
        background-color: #ffbe33;
    }

    /* تخصيص خاص بموزيلا فايرفوكس */
    .pagination li a::-moz-focus-inner {
        border: 0;
    }
</style>

<section class="food_section layout_padding-bottom">
    <div class="container">
        <div class="heading_container heading_center mb-5">
            <h2>Our Menu</h2>
        </div>

        <!-- ✅ التصنيفات من جدول categories -->
        <ul class="filters_menu">
            <li class="active" data-filter="all">All</li>
            @isset($categories)
            @foreach ($categories as $category)
                <li data-filter="{{ strtolower(str_replace(' ', '-', $category->name)) }}">
                    {{ $category->name }}
                </li>
            @endforeach
            @endisset
        
        </ul>

        <!-- ✅ عرض المنتجات مع التصنيف في الكلاس -->
        <div class="filters-content">
            <div class="menu-grid" id="menuItemsContainer">
                @foreach ($menuItems as $item)
                    <div class="menu-item {{ strtolower(str_replace(' ', '-', optional($item->category)->name)) }}">
                        <div class="card food-card">
                            <div class="food-img">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <div>
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-price">${{ number_format($item->price, 2) }}</p>
                                </div>
                                <div class="card-buttons">
                                    <button type="button" class="btn btn-detail" onclick="openItemModal({{ $item->id }})">
                                        Details
                                    </button>
                                    <button class="btn btn-cart add-to-cart-btn" data-id="{{ $item->id }}">
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="no-items-message">
                No items found in this category.
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="paginationContainer"></ul>
            </div>
        </div>
    </div>
</section>

<!-- ✅ مودالات العناصر -->
@foreach ($menuItems as $item)
    <div class="modal fade" id="itemModal{{ $item->id }}" tabindex="-1" aria-labelledby="itemModalLabel{{ $item->id }}" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $item->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    {{ $item->description }}
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
<script>
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
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item added to cart!',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        });
    });
});


</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ITEMS_PER_PAGE = window.innerWidth <= 768 ? 10 : 20; // عدد العناصر في كل صفحة
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
                position: 'top-end',
                icon: 'success',
                title: 'Item added to cart!',
                showConfirmButton: false,
                timer: 1000
            });
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong', 'error');
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

    function openItemModal(id) {
        // إعادة تعيين أي تأثيرات سابقة
        const modalContent = $('#itemModal' + id).find('.modal-content');
        modalContent.css('animation', 'none');

        // إعادة تشغيل التأثير بإعادة تطبيق الـ animation
        setTimeout(function() {
            modalContent.css('animation', 'pulse-animation 0.5s ease-in-out 1');
            $('#itemModal' + id).modal('show');
        }, 10);
    }
</script>
