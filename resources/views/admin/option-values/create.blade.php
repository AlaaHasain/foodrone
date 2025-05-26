@extends('admin.layouts.app')

@section('title', 'Add Value to Option')

@section('content')
<div class="header">
    <h1>Add New Option Value</h1>
</div>

<div class="content-section">
    <form action="{{ route('admin.option-values.store', $option->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Option Name</label>
            <input type="text" value="{{ $option->name }}" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="value">Value Name</label>
            <input type="text" name="value" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="additional_price">Additional Price (Optional)</label>
            <input type="number" step="0.01" name="additional_price" class="form-control" value="0">
        </div>

        {{-- ✅ New Description Field --}}
        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.option-values.index', $option->id) }}" class="secondary-btn">Back</a>
            <button type="submit" class="action-btn">Save Value</button>
        </div>
    </form>
</div>
@endsection
