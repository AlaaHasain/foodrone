<!-- Modal for item details -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalItemName">عنوان المنتج</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="modalItemImage" src="" class="img-fluid rounded" alt="صورة المنتج">
                    </div>
                    <div class="col-md-6">
                        <h4 id="modalItemPrice" class="text-warning mb-2">$0.00</h4>
                        <p id="modalItemDescription" class="mb-3">وصف المنتج</p>
                        <div class="mb-3">
                            <label for="modalItemQuantity" class="form-label">الكمية:</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary modal-qty-minus" type="button">-</button>
                                <input type="number" class="form-control text-center" id="modalItemQuantity"
                                    value="1" min="1">
                                <button class="btn btn-outline-secondary modal-qty-plus" type="button">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-warning" id="modalAddToCart">إضافة للسلة</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Script -->
<script>
    let currentItemId = null;

    function openItemModal(itemId) {
        currentItemId = itemId;

        // Get item details using the named route
        fetch("{{ route('menu', '') }}/" + itemId, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update modal with item details
                document.getElementById('modalItemName').textContent = data.item.name;
                document.getElementById('modalItemPrice').textContent = `$${data.item.price.toFixed(2)}`;
                document.getElementById('modalItemDescription').textContent = data.item.description;
                document.getElementById('modalItemImage').src = `/storage/${data.item.image}`;
                document.getElementById('modalItemQuantity').value = 1;

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('itemModal'));
                modal();
            })
            .catch(error => {
                console.error('Error fetching item details:', error);
            });
    }

    function openOfferModal(itemId) {
        // Re-use the same function for offers
        openItemModal(itemId);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Event listeners for quantity control
        const qtyMinusBtn = document.querySelector('.modal-qty-minus');
        const qtyPlusBtn = document.querySelector('.modal-qty-plus');
        const modalAddBtn = document.getElementById('modalAddToCart');

        if (qtyMinusBtn) {
            qtyMinusBtn.addEventListener('click', function() {
                const qtyInput = document.getElementById('modalItemQuantity');
                const currentQty = parseInt(qtyInput.value);
                if (currentQty > 1) {
                    qtyInput.value = currentQty - 1;
                }
            });
        }

        if (qtyPlusBtn) {
            qtyPlusBtn.addEventListener('click', function() {
                const qtyInput = document.getElementById('modalItemQuantity');
                qtyInput.value = parseInt(qtyInput.value) + 1;
            });
        }

        // Add to cart from modal
        if (modalAddBtn) {
            modalAddBtn.addEventListener('click', function() {
                if (!currentItemId) return;

                const quantity = parseInt(document.getElementById('modalItemQuantity').value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch("{{ route('cart.add-ajax') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            menu_item_id: currentItemId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Close modal
                        const modalElement = document.getElementById('itemModal');
                        if (modalElement) {
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        }

                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.count;
                            cartCount.classList.add('show', 'pulse');
                            setTimeout(() => cartCount.classList.remove('pulse'), 400);
                        }

                        // Update cart count
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.count;
                            cartCount.classList.add('show');
                            cartCount.classList.add('pulse');
                            setTimeout(() => cartCount.classList.remove('pulse'), 500);
                        }

                        // Show notification
                        if (typeof showNotification === 'function') {
                            showNotification(`تمت إضافة المنتج للسلة!`);
                        } else {
                            alert('تمت إضافة المنتج للسلة!');
                        }
                    })
                    .catch(error => {
                        console.error('Error adding to cart:', error);
                        if (typeof showNotification === 'function') {
                            showNotification('حدث خطأ أثناء إضافة المنتج للسلة', 'error');
                        } else {
                            alert('حدث خطأ أثناء إضافة المنتج للسلة');
                        }
                    });
            });
        }
    });

    // Fallback notification function in case the main one isn't available
    if (typeof showNotification !== 'function') {
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
            <strong class="me-auto">${type === 'error' ? 'error' : 'success'}</strong>
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
    }
</script>
