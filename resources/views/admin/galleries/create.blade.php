@extends('admin.layouts.app')

@section('title', 'Add New Image')
<style>
.custom-file-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8f9fa;
    padding: 10px 15px;
    border: 2px dashed #ced4da;
    border-radius: 10px;
    transition: 0.3s ease;
    cursor: pointer;
    max-width: 100%;
    flex-wrap: wrap;
}

.custom-file-input-wrapper:hover {
    background-color: #f1f1f1;
}

.custom-file-input-wrapper input[type="file"] {
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    cursor: pointer;
}

.custom-file-label {
    background-color: #17a2b8;
    color: white;
    padding: 8px 18px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    white-space: nowrap;
}

.custom-file-input-wrapper #file-name {
    font-weight: 500;
    color: #333;
}
</style>
@section('content')
    <div class="header">
        <h1>Add New Image</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Image</label>
                <div class="custom-file-input-wrapper">
                    <label for="image" class="custom-file-label">Choose File</label>
                    <input type="file" name="image" id="image" required>
                    <span id="file-name">No file selected</span>
                </div>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const fileNameSpan = document.getElementById('file-name');

    input.addEventListener('change', function () {
        const fileName = input.files.length > 0 ? input.files[0].name : 'No file selected';
        fileNameSpan.textContent = fileName;
    });
});
</script>
