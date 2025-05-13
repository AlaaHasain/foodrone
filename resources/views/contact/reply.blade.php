{{-- resources/views/contact/reply.blade.php --}}
@extends('layouts.app')

@section('title', 'Reply to Message')

@section('content')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="chat-card">
                <div class="chat-header">
                    <div class="chat-header-user">
                        <div class="chat-avatar">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="chat-user-info">
                            <h4>Support Team</h4>
                            <p class="status"><span class="status-dot"></span> Online</p>
                        </div>
                    </div>
                    <div class="chat-actions">
                        <a href="{{ url('/') }}" class="action-button">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
                </div>

                <div class="chat-body">
                    <!-- Chat messages container -->
                    <div id="chat-container">
                        <div id="messages-list" data-last-reply-id="{{ $message->replies->count() ? $message->replies->last()->id : 0 }}">
                            <!-- Original message from admin -->
                            <div class="message-item admin-message">
                                <div class="message-bubble admin-bubble">
                                    <div class="message-content">{{ $message->message }}</div>
                                    <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                            
                            <!-- Previous replies -->
                            @foreach($message->replies as $reply)
                                <div class="message-item {{ $reply->sender_type == 'admin' ? 'admin-message' : 'user-message' }}">
                                    <div class="message-bubble {{ $reply->sender_type == 'admin' ? 'admin-bubble' : 'user-bubble' }}">
                                        <div class="message-content">{{ $reply->content }}</div>
                                        <div class="message-time">{{ $reply->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Reply form -->
                <div class="chat-footer">
                    <form id="reply-form" action="{{ route('contact.reply.submit', $message->id) }}" method="POST">
                        @csrf
                        <div class="message-input-container">
                            <textarea id="reply_content" name="reply_content" placeholder="Type your message here..." required></textarea>
                            <button type="submit" class="send-button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background-color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Professional Chat styling */
.chat-card {
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 80vh;
    max-height: 700px;
    transition: all 0.3s ease;
}

.chat-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.chat-header {
    background: linear-gradient(135deg, #075E54 0%, #128C7E 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.chat-header-user {
    display: flex;
    align-items: center;
}

.chat-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 18px;
}

.chat-user-info h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.status {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    display: flex;
    align-items: center;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background-color: #4CAF50;
    border-radius: 50%;
    margin-right: 5px;
}

.chat-actions .action-button {
    color: white;
    background: rgba(255, 255, 255, 0.2);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
}

.chat-actions .action-button:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.chat-body {
    padding: 20px;
    flex: 1;
    overflow-y: auto;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23f0f0f0' fill-opacity='0.4'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

#chat-container {
    display: flex;
    flex-direction: column;
    min-height: 100%;
}

.message-item {
    display: flex;
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.user-message {
    justify-content: flex-end;
}

.admin-message {
    justify-content: flex-start;
}

.message-bubble {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.admin-bubble {
    background-color: #ffffff;
    border-top-left-radius: 4px;
    border-left: 3px solid #128C7E;
    color: #333;
}

.user-bubble {
    background-color: #DCF8C6;
    border-top-right-radius: 4px;
    color: #333;
}

.message-content {
    word-break: break-word;
    line-height: 1.5;
    font-size: 14px;
}

.message-time {
    display: block;
    font-size: 11px;
    text-align: right;
    color: #999;
    margin-top: 5px;
}

.chat-footer {
    padding: 15px 20px;
    background-color: white;
    border-top: 1px solid #f0f0f0;
}

.message-input-container {
    display: flex;
    align-items: center;
    background-color: #f5f5f5;
    border-radius: 24px;
    padding: 5px 15px;
    transition: all 0.3s ease;
}

.message-input-container:focus-within {
    box-shadow: 0 0 0 2px rgba(37, 211, 102, 0.2);
}

#reply_content {
    flex: 1;
    border: none;
    background: transparent;
    padding: 10px 5px;
    outline: none;
    resize: none;
    max-height: 120px;
    font-size: 14px;
    line-height: 1.5;
}

.send-button {
    background-color: #25D366;
    color: white;
    border: none;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.send-button:hover {
    background-color: #128C7E;
    transform: scale(1.05);
}

/* Scrollbar styling */
.chat-body::-webkit-scrollbar {
    width: 6px;
}

.chat-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.chat-body::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 10px;
}

.chat-body::-webkit-scrollbar-thumb:hover {
    background: #ccc;
}

/* Message status indicators */
.user-bubble::after {
    content: '';
    position: absolute;
    bottom: 5px;
    right: -12px;
    width: 8px;
    height: 8px;
    border-radius: 0;
    border: 4px solid transparent;
    border-left: 8px solid #DCF8C6;
}

.admin-bubble::before {
    content: '';
    position: absolute;
    bottom: 5px;
    left: -12px;
    width: 8px;
    height: 8px;
    border-radius: 0;
    border: 4px solid transparent;
    border-right: 8px solid #fff;
}

/* Notification styling */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #25D366;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: flex;
    align-items: center;
    animation: slideIn 0.3s ease forwards;
    max-width: 300px;
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.notification i {
    margin-right: 10px;
}

.notification-message {
    font-size: 14px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .chat-card {
        height: 90vh;
        border-radius: 0;
    }
    
    .message-bubble {
        max-width: 85%;
    }
    
    .container {
        padding: 0;
    }
    
    .row {
        margin: 0;
    }
    
    .col-md-10 {
        padding: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to bottom of chat container on page load
    const chatBody = document.querySelector('.chat-body');
    chatBody.scrollTop = chatBody.scrollHeight;
    
    // Handle form submission with AJAX
    $('#reply-form').submit(function(e) {
        e.preventDefault();

        const replyContent = $('#reply_content').val();

        if (replyContent.trim() === '') {
            showNotification('الرجاء كتابة رسالة للإرسال!', 'error');
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // إضافة الرسالة إلى الشات فوراً
                addMessageToChat('You', replyContent, false);

                // تفريغ التكست ايريا
                $('#reply_content').val('');

                showNotification('تم إرسال ردك بنجاح!', 'success');

                // تحديث آخر ID للرد
                if (response.reply && response.reply.id) {
                    $('#messages-list').attr('data-last-reply-id', response.reply.id);
                }
            },
            error: function(xhr) {
                console.error('Error details:', xhr);
                showNotification('فشل إرسال رسالتك. الرجاء المحاولة مرة أخرى.', 'error');
            }
        });
    });
    
    // Function to add a new message to the chat
    function addMessageToChat(sender, content, isAdmin) {
        const currentDate = new Date();
        const timeString = currentDate.toLocaleString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: false
        });
        
        const messageHtml = `
            <div class="message-item ${isAdmin ? 'admin-message' : 'user-message'}">
                <div class="message-bubble ${isAdmin ? 'admin-bubble' : 'user-bubble'}">
                    <div class="message-content">${content}</div>
                    <div class="message-time">${timeString}</div>
                </div>
            </div>
        `;
        
        $('#messages-list').append(messageHtml);
        
        // Scroll to the bottom of the chat container
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    
    // Simple notification function to replace SweetAlert
    function showNotification(message, type = 'success') {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });
        
        // Create new notification
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.style.backgroundColor = type === 'success' ? '#25D366' : '#FF5252';
        
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span class="notification-message">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Poll for new messages every 3 seconds
    setInterval(fetchNewMessages, 3000);
    
    function fetchNewMessages() {
        const messageId = {{ $message->id }};
        const lastReplyId = $('#messages-list').attr('data-last-reply-id') || 0;
        
        $.ajax({
            url: '{{ route("contact.reply.fetch-new", $message->id) }}',
            type: 'GET',
            data: {
                last_reply_id: lastReplyId
            },
            success: function(response) {
                if (response.replies && response.replies.length > 0) {
                    response.replies.forEach(function(reply) {
                        addMessageToChat(
                            reply.sender_type === 'admin' ? 'Admin' : 'You', 
                            reply.content, 
                            reply.sender_type === 'admin'
                        );
                    });
                    
                    // Update last reply ID
                    if (response.replies.length > 0) {
                        const lastReply = response.replies[response.replies.length - 1];
                        $('#messages-list').attr('data-last-reply-id', lastReply.id);
                    }
                    
                    // Play notification sound for new messages (admin only)
                    if (response.replies.some(reply => reply.sender_type === 'admin')) {
                        playNotificationSound();
                    }
                }
            },
            error: function(xhr) {
                console.error('Error fetching new messages:', xhr);
            }
        });
    }
    
    function playNotificationSound() {
        // Create audio element for notification sound
        const audio = new Audio('/sounds/notification.mp3');
        audio.volume = 0.5;
        
        // Try to play the sound (might fail due to browser autoplay policy)
        const playPromise = audio.play();
        
        if (playPromise !== undefined) {
            playPromise.catch(function(error) {
                console.log('Audio playback prevented by browser:', error);
            });
        }
    }
    
    // Auto-expand textarea
    const textarea = document.getElementById('reply_content');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        if (this.scrollHeight > 120) {
            this.style.overflowY = 'auto';
        } else {
            this.style.overflowY = 'hidden';
        }
    });
});
</script>

@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    showNotification('{{ session('success') }}', 'success');
});

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.style.backgroundColor = type === 'success' ? '#25D366' : '#FF5252';
    
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span class="notification-message">${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>
@endif
@endsection