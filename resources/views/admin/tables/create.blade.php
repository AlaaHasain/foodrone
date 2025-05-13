@extends('admin.layouts.app')
@section('title', 'Add Table')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Add New Table</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.tables.store') }}">
        @csrf
        <div class="mb-3">
            <label for="table_number" class="form-label">Table Number</label>
            <input type="number" name="table_number" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-warning">Add Table</button>
    </form>
</div>
@endsection
