@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container py-4">
    <div class="content-section">
        <div class="section-header">
            <h2>
                <i class="fas fa-tags me-2"></i> Categories Management
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="action-btn">
                <i class="fas fa-plus me-1"></i> Add New Category
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="background-color: rgba(39, 174, 96, 0.15); color: #27ae60; border: none; border-radius: 8px; padding: 12px 15px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th style="width: 70%">Category Name</th>
                    <th style="width: 30%; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="align-middle">{{ $category->name }}</td>
                        <td style="text-align: center;">
                            <div class="action-icons">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" style="display: inline-block; margin-right: 10px;">
                                    <i class="fas fa-edit" style="color: var(--primary-color);"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" style="background: none; border: none; cursor: pointer;">
                                        <i class="fas fa-trash" style="color: var(--danger-color);"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; padding: 20px;">
                            <div style="color: var(--dark-color); opacity: 0.7;">
                                <i class="fas fa-info-circle me-1"></i> No categories found.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($categories->count() > 0 && method_exists($categories, 'links'))
            <div class="mt-3" style="margin-top: 15px;">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection