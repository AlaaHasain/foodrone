@extends('admin.layouts.app')

@section('title', 'Edit Option Value')

@section('content')
<div class="header">
    <h1>Edit Option Value</h1>
</div>

<div class="content-section">
    <form action="{{ route('admin.option-values.update', [$option->id, $optionValue->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Option Name</label>
            <input type="text" value="{{ $option->name }}" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="value">Value Name</label>
            <input type="text" name="value" class="form-control" value="{{ $optionValue->value }}" required>
        </div>

        <div class="form-group">
            <label for="additional_price">Additional Price</label>
            <input type="number" step="0.01" name="additional_price" class="form-control" value="{{ $optionValue->additional_price }}">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $optionValue->description }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.option-values.index', $option->id) }}" class="secondary-btn">Cancel</a>
            <button type="submit" class="action-btn">Update Value</button>
        </div>
    </form>
</div>
@endsection
