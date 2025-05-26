@foreach($messages as $index => $message)
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
    <td>{{ $message->created_at?->format('d M Y H:i') }}</td>
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
@endforeach
