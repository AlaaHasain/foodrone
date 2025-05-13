@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container py-4">
    <div class="content-section">
        <div class="section-header">
            <h2>
                <i class="fas fa-edit me-2"></i> Edit Category
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="action-btn" style="background-color: var(--info-color);">
                <i class="fas fa-list me-1"></i> Back to Categories
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-3" style="background-color: rgba(231, 76, 60, 0.15); color: #e74c3c; border: none; border-radius: 8px; padding: 12px 15px;">
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-3" style="background-color: rgba(39, 174, 96, 0.15); color: #27ae60; border: none; border-radius: 8px; padding: 12px 15px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card" style="box-shadow: none; border: 1px solid var(--medium-color);">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" value="{{ $category->name }}" class="form-control" required>
                    <small class="text-muted" style="color: var(--dark-color); opacity: 0.7;">Update the name for this category</small>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="window.location='{{ route('admin.categories.index') }}'" class="secondary-btn">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="action-btn" style="background-color: var(--success-color);">
                        <i class="fas fa-check me-1"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection