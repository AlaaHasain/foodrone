@extends('admin.layouts.app')

@section('title', 'Add New Menu Item')

@section('content')
    <div class="header">
        <h1>Add New Menu Item</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Image (optional)</label>
                <input type="file" name="image">
            </div>

            <div class="form-group">
                <label>Is Featured?</label>
                <select name="is_featured">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_popular" {{ old('is_popular') ? 'checked' : '' }}>
                    Mark as Popular Dish
                </label>
            </div>

            <div class="form-group">
                <label>Is Offer?</label>
                <select name="is_offer" class="form-control">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label>Old Price</label>
                <input type="text" name="old_price" class="form-control" placeholder="Enter old price">
            </div>

            <div class="form-group">
                <label>Offer Price</label>
                <input type="text" name="offer_price" class="form-control" placeholder="Enter offer price">
            </div>

            {{-- ✅ خيارات المنتج (Options) --}}
            <div class="form-group">
                <label for="options">Choose Options (if applicable)</label>
                <select name="options[]" multiple class="form-control">
                    @foreach(\App\Models\Option::all() as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple options.</small>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.menu-items.index') }}" class="secondary-btn">Cancel</a>
                <button type="submit" class="action-btn">Save Item</button>
            </div>
        </form>
    </div>
@endsection
