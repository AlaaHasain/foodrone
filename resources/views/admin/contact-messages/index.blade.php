@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
    <div class="header">
        <h1>Contact Messages</h1>
    </div>

    <div class="content-section">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Sent At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="contact-messages-body">
                <tr><td colspan="6" class="text-center">Loading...</td></tr>
            </tbody>
        </table>

        <nav>
            <ul class="pagination" id="pagination"></ul>
        </nav>
    </div>
@endsection

<style>
    .unread-message {
        background-color: rgba(255, 0, 0, 0.05);
        font-weight: bold;
    }
    .unread-indicator {
        margin-left: 5px;
        color: #ff0000;
    }
    .pulse-animation {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .pagination {
        display: flex;
        list-style: none;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination li {
        margin: 0 4px;
    }
    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 14px;
        font-size: 14px;
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-decoration: none;
    }
    .pagination li.active span {
        background-color: #ffbe33;
        color: white;
        border-color: #ffbe33;
    }
    .pagination li a:hover {
        background-color: #ffbe33;
        color: white;
    }
</style>

<script>
let currentPage = 1;

function fetchContactMessages(page = 1) {
    fetch(`{{ route('admin.contact-messages.fetch') }}?page=${page}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('contact-messages-body').innerHTML = data.html;
            renderPagination(data.pagination);
        });
}

function renderPagination(pagination) {
    const container = document.getElementById('pagination');
    container.innerHTML = '';

    for (let i = 1; i <= pagination.last_page; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === pagination.current_page) li.classList.add('active');

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.href = '#';
        a.textContent = i;
        a.addEventListener('click', e => {
            e.preventDefault();
            currentPage = i;
            fetchContactMessages(i);
        });

        li.appendChild(a);
        container.appendChild(li);
    }
}

// أول تحميل
document.addEventListener('DOMContentLoaded', () => fetchContactMessages(currentPage));
</script>
<script>
function checkUnreadMessages() {
    fetch(`{{ route('admin.contact-messages.unread-count') }}`)
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('unread-count');
            if (!badge) return; // ✅ تجنب الخطأ لو العنصر مش موجود

            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(err => {
            console.error('Error checking unread messages:', err);
        });
}

document.addEventListener('DOMContentLoaded', checkUnreadMessages);
setInterval(checkUnreadMessages, 10000);

</script>


