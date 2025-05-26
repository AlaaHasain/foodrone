@extends('admin.layouts.app')
@section('title', 'Add Table')

@section('content')
<style>
    .form-container {
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        padding: 2.5rem;
        max-width: 600px;
        margin: auto;
    }

    .form-header {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #facc15;
        box-shadow: 0 0 0 0.25rem rgba(250, 204, 21, 0.25);
    }

    .btn-submit {
        background-color: #facc15;
        color: #1e293b;
        font-weight: 600;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        background-color: #eab308;
        transform: translateY(-1px);
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
        font-weight: 500;
    }
</style>

<div class="container py-5">
    <div class="form-container">
        <div class="form-header">
            <i class="fas fa-chair text-warning"></i> Add New Table
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf
            <div class="mb-3">
                <label for="table_number" class="form-label">Table Number</label>
                <input type="number" name="table_number" class="form-control" required min="1" placeholder="Enter table number">
            </div>
            <button type="submit" class="btn btn-submit">
                <i class="fas fa-plus-circle me-2"></i> Add Table
            </button>
        </form>
    </div>
</div>
@endsection
