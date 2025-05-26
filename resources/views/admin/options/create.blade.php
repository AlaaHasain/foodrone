@extends('admin.layouts.app')

@section('title', 'Add New Option')

@section('content')
<div class="header">
    <h1>Add New Option</h1>
</div>

<div class="content-section">
    <form action="{{ route('admin.options.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Option Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- ✅ نوع الخيار (checkbox أو radio) -->
        <div class="form-group mt-3">
            <label for="type">Option Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="checkbox">Checkbox (multiple allowed)</option>
                <option value="radio">Radio (choose one only)</option>
            </select>
        </div>

        <div class="form-actions mt-3">
            <a href="{{ route('admin.options.index') }}" class="secondary-btn">Cancel</a>
            <button type="submit" class="action-btn">Save Option</button>
        </div>
    </form>
</div>
@endsection
