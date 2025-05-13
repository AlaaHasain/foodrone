@extends('admin.layouts.app')

@section('title', 'Testimonials Management')
<style>
    .btn-sm {
        padding: 6px 14px;
        font-size: 14px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

@section('content')
    <div class="content-section">
        <div class="section-header">
            <h2>Customer Testimonials</h2>
        </div>

        @if (session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->customer_name }}</td>
                        <td>{{ Str::limit($testimonial->message, 50) }}</td>
                        <td>
                            @if ($testimonial->is_approved)
                                <span class="status completed">Approved</span>
                            @else
                                <span class="status pending">Pending</span>
                            @endif
                        </td>
                        <td class="action-icons">
                            @if (!$testimonial->is_approved)
                                <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Accept</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No testimonials yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $testimonials->links() }}
        </div>
    </div>
@endsection
