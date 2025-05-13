@extends('admin.layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="header">
        <h1>Gallery</h1>
    </div>

    <div class="content-section">
        <a href="{{ route('admin.galleries.create') }}" class="action-btn" style="margin-bottom:20px;">Add New Image</a>

        <div class="image-upload" style="flex-wrap: wrap;">
            @forelse($galleries as $gallery)
                <div style="position: relative;">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image" class="image-preview">
                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" style="position: absolute; top: 5px; right: 5px;">
                        @csrf
                        @method('DELETE')
                        <button style="background: transparent; border: none; cursor: pointer;">
                            <i class="fas fa-trash" style="color: red;"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p>No images found.</p>
            @endforelse
        </div>
    </div>
@endsection

