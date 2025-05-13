@extends('admin.layouts.app')

@section('title', 'Add New Image')

@section('content')
    <div class="header">
        <h1>Add New Image</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" required>
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="restaurant">Restaurant</option>
                    <option value="food">Food</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.galleries.index') }}" class="secondary-btn">Cancel</a>
                <button type="submit" class="action-btn">Upload</button>
            </div>
        </form>
    </div>
@endsection
