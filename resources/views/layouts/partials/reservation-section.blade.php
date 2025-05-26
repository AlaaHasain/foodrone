<style>

    .reservation-form .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .reservation-form .form-control {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #ccc;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Number input styling */
    .reservation-form input[type="number"] {
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        width: 100%;
    }

    /* Remove spinner buttons from number input */
    .reservation-form input[type="number"]::-webkit-inner-spin-button,
    .reservation-form input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .reservation-form input[type="number"] {
        -moz-appearance: textfield;
    }

    .reservation-form select.form-control:focus {
        outline: none;
        border-color: #ffbe33;
    }

    .btn1 {
        background: #ffbe33;
        border: none;
        color: white;
        padding: 10px 25px;
        font-size: 18px;
        border-radius: 30px;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn1:hover {
        background: #e69c00;
    }

    /* Date and time input styling */
    .reservation-form input[type="date"],
    .reservation-form input[type="time"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #fff;
    }

    .reservation-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    /* Error message styling */
    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: none;
    }

    .reservation-form .form-control.error {
        border-color: #dc3545;
    }

    /* Time slots container */
    .time-slots {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .time-slot {
        padding: 8px 15px;
        background: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }

    .time-slot:hover {
        background: #f0f0f0;
    }

    .time-slot.selected {
        background: #ffbe33;
        color: white;
        border-color: #ffbe33;
    }

    .time-slot.disabled {
        background: #e9e9e9;
        color: #aaa;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Toast notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .toast {
        background: #333;
        color: white;
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s;
    }

    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast-error {
        background: #dc3545;
    }

    .toast-success {
        background: #28a745;
    }

    .toast-icon {
        margin-right: 10px;
        font-size: 18px;
    }
    @keyframes slideIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-20px); }
}

@keyframes progressBar {
    from { width: 100%; }
    to { width: 0%; }
}


</style>

<!-- Restaurant Table Reservation Form -->
<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center mb-4">
            <h2>{{ __('messages.book_a_table') }}</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('reservation.store') }}" method="POST" class="reservation-form"
                    id="reservationForm">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="customer_name" class="form-control"
                            placeholder="{{ __('messages.your_name') }}"
                            value="{{ old('customer_name', session('customer_name')) }}"
                            @if(session()->has('customer_name')) readonly @else required @endif
                            pattern="^[A-Za-z]{2,}\s[A-Za-z]{2,}.*$"
                            title="Please enter at least first and last name">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="contact_number" class="form-control"
                            placeholder="{{ __('messages.phone_number') }}"
                            value="{{ old('contact_number', session('customer_phone')) }}"
                            @if(session()->has('customer_phone')) readonly @else required @endif
                            pattern="^[0-9+\s\-]{7,}$"
                            title="Please enter a valid phone number">
                    </div>                   
                    <div class="form-group">
                        <label for="people-count">{{ __('messages.how_many_persons') }}</label>
                        <input type="number" id="people-count" name="people" class="form-control" min="1"
                            max="20" ...>
                    </div>
                    <div class="form-group">
                        <label for="reservation-date">{{ __('messages.date') }}</label>
                        <input type="date" id="reservation-date" name="date" class="form-control" required>
                        <div class="error-message" id="date-error"></div>
                    </div>
                    <div class="form-group">
                        
                        <label for="reservation-time">{{ __('messages.time_range') }}</label>
                        <input type="time" id="reservation-time" name="time" class="form-control" min="12:00"
                            max="23:00" required>
                        <div class="error-message" id="time-error"></div>

                        <!-- Optional: Predefined time slots -->
                        <div class="time-slots" id="time-slots">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="btn_box text-center mt-4">
                      <button type="submit" class="btn btn-warning" id="bookButton">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="loadingSpinner"></span>
                        <span id="bookBtnText">{{ __('messages.book_now') }}</span>
                      </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="customSuccessMessage" style="
    position: fixed;
    top: 20px;
    right: 20px;
    background: #ffbe33;
    color: #fff;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-size: 16px;
    z-index: 9999;
    display: none;
    align-items: center;
">
    <span style="margin-right: 10px;">✅</span>
    <span id="successMessageText">{{ __('messages.reservation_success') }}</span>
    <div id="customProgressBar" style="
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.7);
        width: 100%;
    "></div>
</div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function showSuccessNotification() {
        // عرض الإشعار
        const successMessage = document.getElementById('customSuccessMessage');
        if (successMessage) {
            successMessage.style.display = 'flex';
            successMessage.style.animation = 'slideIn 0.5s ease-out';
            
            // تشغيل الصوت
            const notificationSound = document.getElementById('customNotificationSound');
            if (notificationSound) {
                notificationSound.volume = 0.5;
                // محاولة تشغيل الصوت فورًا بعد تفاعل المستخدم
                const playPromise = notificationSound.play();
                
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.log("خطأ في تشغيل الصوت:", error);
                    });
                }
            }
            
            // تحريك شريط التقدم
            const progressBar = document.getElementById('customProgressBar');
            if (progressBar) {
                let width = 100;
                const interval = setInterval(() => {
                    width -= 1;
                    progressBar.style.width = width + "%";
                    if (width <= 0) {
                        clearInterval(interval);
                        // إخفاء الإشعار
                        successMessage.style.animation = 'slideOut 0.5s ease-in forwards';
                        setTimeout(() => {
                            successMessage.style.display = 'none';
                        }, 500);
                    }
                }, 50);
            }
        }
    }

    document.body.addEventListener('click', function() {
        document.getElementById('customNotificationSound').play().catch(() => {});
    }, { once: true });
    
    // تحقق من قيمة Session
    @if(session('success'))
        // استدعاء الدالة بعد تحميل الصفحة
        setTimeout(showSuccessNotification, 500);
    @endif

    // كود نموذج الحجز
    const form = document.getElementById('reservationForm');
    const dateInput = document.getElementById('reservation-date');
    const timeInput = document.getElementById('reservation-time');
    const dateError = document.getElementById('date-error');
    const timeError = document.getElementById('time-error');
    const timeSlots = document.getElementById('time-slots');
    const bookButton = document.getElementById('bookButton');

    // Set minimum date to today
    const today = new Date();
    const formattedToday = today.toISOString().split('T')[0];
    dateInput.setAttribute('min', formattedToday);

    // Generate time slots (optional feature)
    generateTimeSlots();

    // Handle date change
    dateInput.addEventListener('change', function() {
        validateDateTime();
        updateAvailableTimeSlots();
    });

    // Handle time change
    timeInput.addEventListener('change', function() {
        validateDateTime();
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (!validateDateTime()) {
            e.preventDefault();
            return false;
        }
    });

    // Initialize with default values and validation
    dateInput.value = formattedToday;
    updateAvailableTimeSlots();

    // Function to validate date and time
    function validateDateTime() {
        // Reset error messages
        dateError.style.display = 'none';
        timeError.style.display = 'none';
        dateInput.classList.remove('error');
        timeInput.classList.remove('error');

        const selectedDate = new Date(dateInput.value);
        const currentDate = new Date();
        const selectedTime = timeInput.value;

        // Validate that date is not in the past
        if (selectedDate < new Date(currentDate.setHours(0, 0, 0, 0))) {
            dateError.textContent = 'Please select today or a future date';
            dateError.style.display = 'block';
            dateInput.classList.add('error');
            return false;
        }

        // Check if time is between 12:00 PM and 11:00 PM
        const hour = parseInt(selectedTime.split(':')[0]);
        if (hour < 12 || hour >= 23) {
            timeError.textContent = 'Reservations are only available between 12:00 PM and 11:00 PM';
            timeError.style.display = 'block';
            timeInput.classList.add('error');
            return false;
        }

        // If today is selected, make sure the time is in the future
        if (isSameDay(selectedDate, new Date())) {
            const currentTime = new Date();
            const selectedDateTime = new Date(selectedDate);
            selectedDateTime.setHours(hour, parseInt(selectedTime.split(':')[1]));

            if (selectedDateTime <= currentTime) {
                timeError.textContent = 'Please select a future time';
                timeError.style.display = 'block';
                timeInput.classList.add('error');
                return false;
            }
        }

        return true;
    }

    // Function to check if two dates are the same day
    function isSameDay(date1, date2) {
        return date1.getDate() === date2.getDate() &&
            date1.getMonth() === date2.getMonth() &&
            date1.getFullYear() === date2.getFullYear();
    }

    // Function to generate time slots
    function generateTimeSlots() {
        // Create time slots from 12 PM to 11 PM
        const slots = [];
        for (let hour = 12; hour < 23; hour++) {
            slots.push(`${hour}:00`);
            slots.push(`${hour}:30`);
        }

        // Create elements for each time slot
        timeSlots.innerHTML = '';
        slots.forEach(slot => {
            const div = document.createElement('div');
            div.className = 'time-slot';
            div.textContent = formatTime(slot);
            div.dataset.time = slot;

            div.addEventListener('click', function() {
                if (!this.classList.contains('disabled')) {
                    // Remove selected class from all slots
                    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove(
                        'selected'));

                    // Add selected class to current slot
                    this.classList.add('selected');

                    // Update the time input
                    const [hour, minute] = slot.split(':');
                    timeInput.value = `${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`;

                    // Validate the time
                    validateDateTime();
                }
            });

            timeSlots.appendChild(div);
        });
    }

    // Function to update available time slots based on selected date
    function updateAvailableTimeSlots() {
        const selectedDate = new Date(dateInput.value);
        const currentDate = new Date();
        const isToday = isSameDay(selectedDate, currentDate);

        // Get all time slots
        const slots = document.querySelectorAll('.time-slot');

        slots.forEach(slot => {
            const [hour, minute] = slot.dataset.time.split(':');
            const slotTime = new Date(selectedDate);
            slotTime.setHours(parseInt(hour), parseInt(minute), 0, 0);

            // If today, disable past times
            if (isToday && slotTime <= currentDate) {
                slot.classList.add('disabled');
            } else {
                slot.classList.remove('disabled');
            }
        });
    }

    // Function to format time (24h to 12h format)
    function formatTime(time) {
        const [hour, minute] = time.split(':');
        const h = parseInt(hour);
        const suffix = h >= 12 ? 'PM' : 'AM';
        const displayHour = h > 12 ? h - 12 : h;
        return `${displayHour}:${minute} ${suffix}`;
    }

    // كود الإشعارات والصوت
    const successMessage = document.getElementById('successMessage');
    const notificationSound = document.getElementById('notificationSound');
    
    if (successMessage && notificationSound) {
        // تأخير قصير قبل تشغيل الصوت للتأكد من تحميل الصفحة بالكامل
        setTimeout(() => {
            // محاولة تشغيل الصوت مع معالجة الأخطاء المحتملة
            notificationSound.volume = 0.5;
            notificationSound.play().catch(error => {
                console.log("لم يتم تشغيل الصوت: ", error);
            });
        }, 300);
        
        // إغلاق الإشعار بعد 5 ثوانٍ
        setTimeout(() => {
            successMessage.style.animation = 'slideOut 0.5s ease-in forwards';
            setTimeout(() => {
                if (successMessage.parentNode) {
                    successMessage.parentNode.removeChild(successMessage);
                }
            }, 500);
        }, 5000);
    }
});
</script>