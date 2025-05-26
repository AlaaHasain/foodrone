@extends('admin.layouts.app')

@section('title', 'Message Details')

@section('content')
<style>
    .chat-container {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 800px;
        margin: auto;
    }

    .message-box {
        border: 1px solid #eee;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        position: relative;
    }

    .message-box.customer {
        background: #f1f1f1;
        text-align: left;
    }

    .message-box.admin {
        background: #e0f7e9;
        text-align: right;
    }

    .message-box small {
        display: block;
        font-size: 12px;
        color: #888;
        margin-top: 8px;
    }

    #reply-form textarea {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        resize: none;
    }

    #reply-form button {
        margin-top: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
    }

    #reply-form button:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffbe33;
        color: #000;
        font-weight: bold;
    }

    .btn-warning:hover {
        background-color: #e0a900;
        color: #fff;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="chat-container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Message from {{ $message->name }}</h2>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-warning" style="text-decoration: none; padding: 8px 16px; border-radius: 8px;">
            ← Back to Messages
        </a>
    </div>

    <p><strong>Email:</strong> {{ $message->email }}</p>
    <p><strong>Phone:</strong> {{ $message->phone ?? '-' }}</p>
    <p><strong>Sent at:</strong> {{ $message->created_at->format('d M Y H:i') }}</p>
    <hr>

    <div class="message-box customer">
        {{ $message->message }}
        <small>{{ $message->created_at->diffForHumans() }} - Customer</small>
    </div>

    <div id="replies"></div>

    <form id="reply-form" action="{{ route('admin.contact-messages.reply', $message->id) }}" method="POST" onsubmit="return false;">
        @csrf
        <textarea name="reply_content" id="reply_content" rows="4" placeholder="Write your reply here..." required></textarea>
        <button type="submit">Send Reply</button>
    </form>
</div>

<script>
    const replyForm = document.getElementById('reply-form');
    const repliesDiv = document.getElementById('replies');
    const replyContent = document.getElementById('reply_content');
    const messageId = {{ $message->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let lastReplyId = 0;

function appendReply(reply) {
    // ✅ تحقق إذا الرد موجود مسبقًا
    if (document.getElementById('reply-' + reply.id)) return;

    const div = document.createElement('div');
    div.className = `message-box ${reply.sender_type}`;
    div.id = 'reply-' + reply.id; // ✅ ID فريد لكل رد
    div.innerHTML = `
        ${reply.content}
        <small>${new Date(reply.created_at).toLocaleString()} - ${capitalize(reply.sender_type)}</small>
    `;
    repliesDiv.appendChild(div);
    div.scrollIntoView({ behavior: 'smooth', block: 'end' });
}



    function capitalize(word) {
        return word.charAt(0).toUpperCase() + word.slice(1);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const replies = @json($replies);
        repliesDiv.innerHTML = '';
        replies.forEach(reply => {
            appendReply(reply);
            lastReplyId = reply.id;
        });
    });

    replyForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const content = replyContent.value.trim();
        if (!content) return;

        fetch(replyForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ reply_content: content })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                appendReply(data.reply);
                replyContent.value = '';
                lastReplyId = data.reply.id;
            } else {
                console.error('Send failed:', data);
            }
        })
        .catch(err => {
            console.error('Error submitting reply:', err);
        });
    });

    function fetchNewReplies() {
    fetch(`/admin/contact-messages/${messageId}/check-replies?last_id=${lastReplyId}`)
        .then(res => res.json())
        .then(data => {
            if (data.replies.length > 0) {
                data.replies.forEach(reply => {
                    appendReply(reply);
                    lastReplyId = reply.id; // حدّث آخر ID
                });
            }
        })
        .catch(err => {
            console.error('Error fetching new replies:', err);
        });
}

// ✅ شغّل الـ polling كل 5 ثواني
setInterval(fetchNewReplies, 5000);

</script>
@endsection
