@extends('admin.layouts.app')

@section('title', 'Menu Items')
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
    <div class="header">
        <h1>Menu Items</h1>
    </div>

    <div class="content-section">
        <div class="section-header">
            <h2>All Menu Items</h2>
            <a href="{{ route('admin.menu-items.create') }}" class="action-btn">Add New Item</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menuItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name ?? '-' }}</td>
                        <td>${{ $item->price }}</td>
                        <td>{{ $item->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="text-center">
                            {{-- Edit Icon --}}
                            <a href="{{ route('admin.menu-items.edit', $item->id) }}" style="color: #2bbbad; font-size: 18px; margin-right: 8px;">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                        
                            {{-- Delete Icon --}}
                            <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; padding: 0; color: #ee5253; font-size: 18px; cursor: pointer;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Menu Items Found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $menuItems->links() }}
        </div>        
    </div>
@endsection
