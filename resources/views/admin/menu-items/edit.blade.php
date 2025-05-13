@extends('admin.layouts.app')

@section('title', 'Edit Menu Item')

@section('content')
    <div class="header">
        <h1>Edit Menu Item</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $menuItem->name }}" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4">{{ $menuItem->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" step="0.01" value="{{ $menuItem->price }}" required>
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            

            <div class="form-group">
                <label>Change Image (optional)</label>
                <input type="file" name="image">
                @if($menuItem->image)
                    <br><img src="{{ asset('storage/' . $menuItem->image) }}" alt="" width="100">
                @endif
            </div>

            <div class="form-group">
                <label>Is Featured?</label>
                <select name="is_featured">
                    <option value="0" {{ $menuItem->is_featured ? '' : 'selected' }}>No</option>
                    <option value="1" {{ $menuItem->is_featured ? 'selected' : '' }}>Yes</option>
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

            <div class="form-actions">
                <a href="{{ route('admin.menu-items.index') }}" class="secondary-btn">Cancel</a>
                <button type="submit" class="action-btn">Update Item</button>
            </div>
        </form>
    </div>
@endsection
