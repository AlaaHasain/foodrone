@extends('admin.layouts.app')

@section('title', 'Option Values')
<style>
    .action-buttons .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 5px;
        font-weight: 500;
        text-decoration: none;
    }

    .btn-warning {
        background-color: #f59e0b;
        color: white;
        border: none;
    }

    .btn-danger {
        background-color: #dc2626;
        color: white;
        border: none;
    }

    .btn-warning:hover {
        background-color: #d97706;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
    }
</style>

@section('content')
    <div class="header">
        <h1>Option Values for "{{ $option->name }}"</h1>
    </div>

    <div class="content-section">
        <a href="{{ route('admin.option-values.create', $option->id) }}" class="action-btn mb-3">Add New Value</a>
        
        <table>
            <thead>
                <tr>
                    <th>Value</th>
                    <th>Additional Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($option->values as $value)
                    <tr>
                        <td>{{ $value->value }}</td>
                        <td>{{ $value->additional_price }} JOD</td>
                        <td>{{ $value->description ?? '-' }}</td> 
                        <td>
                            <div class="action-buttons d-flex gap-2">
                                <a href="{{ route('admin.option-values.edit', [$option->id, $value->id]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.option-values.destroy', [$option->id, $value->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No values found for this option.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-bottom: 20px;">
    <a href="{{ route('admin.options.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Options
    </a>
</div>

@endsection
