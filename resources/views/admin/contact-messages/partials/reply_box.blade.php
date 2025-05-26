<div class="message-box {{ $reply->sender_type }}">
    {{ $reply->content }}
    <small>{{ $reply->created_at->diffForHumans() }} - {{ ucfirst($reply->sender_type) }}</small>
</div>
