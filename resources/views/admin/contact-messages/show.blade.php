```css
<style>
/* ستايل احترافي لصفحة عرض تفاصيل الرسائل */
body {
    background-color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

/* رأس الصفحة والعنوان */
h3.mb-4 {
    color: #075E54;
    font-size: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

h3.mb-4 i {
    margin-left: 10px;
    color: #128C7E;
}

/* تفاصيل الرسالة */
.message-info-card {
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.message-info-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.info-header {
    background: linear-gradient(135deg, #075E54 0%, #128C7E 100%);
    color: white;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
}

.info-header i {
    margin-left: 10px;
    font-size: 1.2rem;
}

.info-header h5 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.message-details {
    padding: 20px;
}

.message-details p {
    margin-bottom: 10px;
    color: #555;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
}

.message-details p:last-child {
    margin-bottom: 0;
}

.message-details p strong {
    color: #333;
    margin-left: 8px;
    min-width: 80px;
    display: inline-block;
}

.message-details p i {
    margin-left: 10px;
    width: 20px;
    color: #128C7E;
}

/* منطقة المحادثة */
.chat-container {
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    padding: 20px;
    direction: rtl;
    max-height: 500px;
    overflow-y: auto;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23f0f0f0' fill-opacity='0.4'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* تصميم فقاعات الرسائل بدون أيقونات للمرسل والمستقبل */
.chat-message {
    display: flex;
    margin-bottom: 20px;
    position: relative;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.customer-message {
    justify-content: flex-start;
}

.admin-message {
    justify-content: flex-end;
}

.message-bubble {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    font-size: 0.95rem;
    line-height: 1.5;
}

.customer-bubble {
    background-color: #DCF8C6;
    border-top-right-radius: 4px;
    color: #333;
}

.admin-bubble {
    background-color: #ffffff;
    border-top-left-radius: 4px;
    border-left: 3px solid #128C7E;
    color: #333;
}

/* عرض الوقت داخل فقاعة الرسالة */
.message-time {
    display: block;
    font-size: 11px;
    text-align: left;
    color: #999;
    margin-top: 5px;
    padding-top: 4px;
    border-top: 1px solid rgba(0,0,0,0.05);
}

/* زوايا الفقاعات */
.customer-bubble::after {
    content: '';
    position: absolute;
    bottom: 8px;
    right: -8px;
    width: 0;
    height: 0;
    border: 8px solid transparent;
    border-left: 8px solid #DCF8C6;
    border-right: 0;
    border-bottom: 0;
    margin-bottom: -4px;
}

.admin-bubble::before {
    content: '';
    position: absolute;
    bottom: 8px;
    left: -8px;
    width: 0;
    height: 0;
    border: 8px solid transparent;
    border-right: 8px solid #ffffff;
    border-left: 0;
    border-bottom: 0;
    margin-bottom: -4px;
}

/* نموذج الرد */
.reply-form {
    margin-top: 30px;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.reply-input {
    border: 1px solid #ddd;
    border-radius: 24px;
    padding: 12px 15px;
    resize: none;
    width: 100%;
    margin-bottom: 15px;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.reply-input:focus {
    border-color: #128C7E;
    box-shadow: 0 0 0 2px rgba(18, 140, 126, 0.2);
}

.reply-button {
    background-color: #128C7E;
    color: #fff;
    padding: 10px 24px;
    border-radius: 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.reply-button:hover {
    background-color: #075E54;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(18, 140, 126, 0.3);
}

.reply-button i {
    font-size: 16px;
}

/* تنسيق سكرول بار */
.chat-container::-webkit-scrollbar {
    width: 6px;
}

.chat-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.chat-container::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 10px;
}

.chat-container::-webkit-scrollbar-thumb:hover {
    background: #128C7E;
}

/* تصميم متجاوب */
@media (max-width: 768px) {
    .message-bubble {
        max-width: 85%;
    }
    
    .reply-form {
        padding: 15px;
    }
}
```
</style>

@extends('admin.layouts.app')
@section('title', 'Message Details')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* CSS سيتم استبداله بالستايل أعلاه */
</style>

@section('content')
<div class="container py-5">
    <h3 class="mb-4 fw-bold"><i class="fas fa-envelope-open-text"></i> تفاصيل الرسالة</h3>

    <div class="message-info-card">
        <div class="info-header">
            <i class="fas fa-user-circle"></i>
            <h5>معلومات المرسل</h5>
        </div>
        <div class="message-details">
            <p><i class="fas fa-user"></i> <strong>الاسم:</strong> {{ $message->name }}</p>
            <p><i class="fas fa-envelope"></i> <strong>البريد:</strong> {{ $message->email }}</p>
            <p><i class="fas fa-phone"></i> <strong>الهاتف:</strong> {{ $message->phone ?? '-' }}</p>
            <p><i class="fas fa-calendar-alt"></i> <strong>تاريخ الإرسال:</strong> {{ $message->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <div class="chat-container" id="admin-chat-container" data-last-reply-id="{{ $replies->count() ? $replies->last()->id : 0 }}">
        @php
            $allMessages = collect([$message]);
            if(isset($replies) && count($replies) > 0) {
                $allMessages = $allMessages->merge($replies);
            }
            $allMessages = $allMessages->sortBy('created_at');
        @endphp

        @foreach($allMessages as $msg)
            @php
                $isAdmin = isset($msg->sender_type) && $msg->sender_type === 'admin';
            @endphp

            <div class="chat-message {{ $isAdmin ? 'admin-message' : 'customer-message' }}">
                <div class="message-bubble {{ $isAdmin ? 'admin-bubble' : 'customer-bubble' }}">
                    {{ $msg->content ?? $msg->message }}
                    <div class="message-time">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="reply-form mt-4">
        <form id="admin-reply-form" action="{{ route('admin.contact-messages.reply', $message->id) }}" method="POST">
            @csrf
            <div class="d-flex align-items-center">
                <textarea id="admin-reply-content" name="reply_content" rows="2" class="reply-input" placeholder="اكتب رسالتك هنا..." required></textarea>
                <button type="submit" id="send-reply-btn" class="reply-button ms-2">
                    <i class="fas fa-paper-plane"></i> إرسال
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // التمرير لأسفل محتوى المحادثة عند تحميل الصفحة
    const chatContainer = document.getElementById('admin-chat-container');
    chatContainer.scrollTop = chatContainer.scrollHeight;
    
    // منطقة للسكريبت للتعامل مع نموذج الإرسال والتحديث التلقائي
    // يمكن إضافة وظائف مشابهة للموجودة في صفحة reply.blade.php
});
</script>
@endsection
```