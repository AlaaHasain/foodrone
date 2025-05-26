@extends('admin.layouts.app')

@section('title', 'All Options')

@section('content')
<div class="options-section">
    <div class="options-header">
        <h1 class="section-title">All Options</h1>
        <a href="{{ route('admin.options.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Option
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="30%">OPTION NAME</th>
                        <th width="15%">VALUES COUNT</th>
                        <th width="25%">VALUES</th>
                        <th width="25%">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($options as $index => $option)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $option->name }}</td>
                            <td>{{ $option->values_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.option-values.index', $option->id) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.option-values.create', $option->id) }}" class="btn-add">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                            </td>
                            <td class="actions">
                                <a href="{{ route('admin.options.edit', $option->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.options.destroy', $option->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this option?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">No options found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrapper mt-4">
    {{ $options->links() }}
</div>

        </div>
    </div>
</div>

<style>
    /* Modern dashboard styling */
    .options-section {
        padding: 1.5rem;
    }
    
    .options-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #1a202c;
        margin: 0;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #6b21a8;
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #5a189a;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(107, 33, 168, 0.1);
    }
    
    .card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th {
        background-color: #f7fafc;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #4a5568;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: #2d3748;
        font-size: 0.9375rem;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .btn-view, .btn-add, .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    
    .btn-view {
        color: #6b21a8;
        background-color: rgba(107, 33, 168, 0.1);
    }
    
    .btn-view:hover {
        background-color: rgba(107, 33, 168, 0.15);
    }
    
    .btn-add {
        color: #059669;
        background-color: rgba(5, 150, 105, 0.1);
        margin-left: 0.5rem;
    }
    
    .btn-add:hover {
        background-color: rgba(5, 150, 105, 0.15);
    }
    
    .actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-edit {
        color: #4a5568;
        background-color: #edf2f7;
        border: 1px solid #e2e8f0;
    }
    
    .btn-edit:hover {
        background-color: #e2e8f0;
    }
    
    .btn-delete {
        color: #e53e3e;
        background-color: rgba(229, 62, 62, 0.1);
        border: none;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background-color: rgba(229, 62, 62, 0.15);
    }
    
    .delete-form {
        display: inline;
    }
    
    .empty-state {
        text-align: center;
        padding: 2.5rem;
        color: #718096;
        font-style: italic;
    }

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination {
    display: flex;
    list-style: none;
    gap: 8px;
}

.pagination li {
    display: inline-block;
}

.pagination li a,
.pagination li span {
    padding: 8px 12px;
    border-radius: 8px;
    background-color: #f3f4f6;
    color: #1f2937;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s;
}

.pagination li.active span {
    background-color: #6b21a8;
    color: #fff;
}

.pagination li a:hover {
    background-color: #ddd;
}
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.pagination {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    padding: 0;
    list-style: none;
}

.pagination li {
    display: inline-block;
}

.pagination li a,
.pagination li span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 8px;
    background-color: #f3f4f6;
    color: #1f2937;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.pagination li.active span {
    background-color: #6b21a8;
    color: white;
    font-weight: bold;
    border-color: #6b21a8;
}

.pagination li.disabled span {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination li a:hover:not(.active) {
    background-color: #e2e8f0;
    color: #000;
    border-color: #ddd;
}

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .options-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .actions {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .btn-add {
            margin-left: 0;
            margin-top: 0.5rem;
        }
    }
</style>
@endsection