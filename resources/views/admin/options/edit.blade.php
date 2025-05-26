@extends('admin.layouts.app')

@section('title', 'Edit Option')

@section('content')
<div class="header">
    <h1>Edit Option</h1>
</div>

<div class="content-section">
    <form action="{{ route('admin.options.update', $option->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Option Name</label>
            <input type="text" name="name" class="form-control" value="{{ $option->name }}" required>
        </div>

        <div class="form-group mt-3">
            <label>Option Type</label>
            <select name="type" class="form-control" required>
                <option value="checkbox" {{ $option->type === 'checkbox' ? 'selected' : '' }}>Checkbox (multiple)</option>
                <option value="radio" {{ $option->type === 'radio' ? 'selected' : '' }}>Radio (single)</option>
            </select>
        </div>

        <div class="form-actions mt-4">
            <a href="{{ route('admin.options.index') }}" class="secondary-btn">Cancel</a>
            <button type="submit" class="action-btn">Update Option</button>
        </div>
    </form>
</div>
@endsection
