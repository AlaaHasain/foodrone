@extends('admin.layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="container py-4">
    <div class="content-section">
        <div class="section-header">
            <h2>
                <i class="fas fa-plus-circle me-2"></i> Add New Category
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

        <div class="card" style="box-shadow: none; border: 1px solid var(--medium-color);">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Category Name (English)</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <div class="form-group mt-3">
                    <label for="name_ar">اسم التصنيف (بالعربية)</label>
                    <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar') }}" class="form-control" required>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="window.location='{{ route('admin.categories.index') }}'" class="secondary-btn">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="action-btn">
                        <i class="fas fa-save me-1"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection