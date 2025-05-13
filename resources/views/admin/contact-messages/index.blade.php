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
            <tbody>
                @forelse($messages as $index => $message)
                <tr class="{{ $message->is_read ? '' : 'unread-message' }}">
                    <td>
                        #{{ ($messages->currentPage() - 1) * $messages->perPage() + $index + 1 }} 
                        @if($message->replies()->where('sender_type', 'customer')->where('is_read_by_admin', false)->exists())
                            <span class="unread-indicator" title="New reply from customer">
                                <i class="fas fa-comment-dots pulse-animation" style="color: #ff0000;"></i>
                            </span>
                        @endif
                            @if(!$message->is_read)
                                <span class="unread-indicator">
                                    <i class="fas fa-circle-exclamation pulse-animation"></i>
                                </span>
                            @endif
                        </td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->phone ?? '-' }}</td>
                        <td>{{ $message->created_at ? $message->created_at->format('d M Y H:i') : '' }}</td>
                        <td class="action-icons">
                            <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>                                                       
                            <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button style="background:none; border:none; cursor:pointer;">
                                    <i class="fas fa-trash" style="color:red;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $messages->links() }}
        </div>        
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
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
    }
</style>
<style>
    .pagination {
        display: flex;
        list-style: none;
        justify-content: center;
        padding-left: 0;
        margin: 20px 0;
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
        transition: 0.3s;
    }

    .pagination li.active span {
        background-color: #ffbe33;
        border-color: #ffbe33;
        color: white;
    }

    .pagination li a:hover {
        background-color: #ffbe33;
        color: white;
    }

    .pagination li.disabled span {
        color: #aaa;
        cursor: not-allowed;
        background-color: #f1f1f1;
    }
</style>
