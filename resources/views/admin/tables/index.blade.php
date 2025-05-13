@extends('admin.layouts.app')

@section('title', 'Tables List')
<style>
    /* Card and table container styles */
.card {
    border: none;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Table general styles */
.table {
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

/* Table header styles */
.table thead tr {
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.table thead th {
    color: #374151;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 1rem;
    border-top: none;
    text-align: left;
}

/* Table body styles */
.table tbody tr {
    border-bottom: 1px solid #e5e7eb;
    transition: background-color 0.2s;
}

.table tbody tr:last-child {
    border-bottom: none;
}

.table tbody tr:hover {
    background-color: #f9fafb;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    color: #4b5563;
}

/* Action buttons */
.btn-icon {
    background: none;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
    padding: 0.5rem;
    border-radius: 0.25rem;
}

.edit-btn {
    color: #0d9488; /* Teal color for edit button */
}

.delete-btn {
    color: #ef4444; /* Red color for delete button */
}

.btn-icon:hover {
    transform: scale(1.1);
    background-color: rgba(0, 0, 0, 0.05);
}

/* Professional Dashboard Table Styles */

/* Main container */
.content-wrapper {
    background-color: #f8fafc;
    padding: 1.5rem;
}

/* Card container */
.content-card {
    background-color: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.content-card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Page header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 0 0.5rem;
}

.page-title {
    color: #1e293b;
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
}

.page-title i, .page-title svg {
    margin-right: 0.75rem;
    color: #334155;
}

/* Action button */
.btn-primary {
    background-color: #0284c7;
    color: white;
    font-weight: 600;
    padding: 0.625rem 1.25rem;
    border-radius: 0.5rem;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn-primary:hover {
    background-color: #0369a1;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.12);
    color: white;
}

.btn-primary:active {
    transform: translateY(0);
}

/* Table styling */
.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.data-table thead th {
    background-color: #f1f5f9;
    color: #475569;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
    border-bottom: 2px solid #e2e8f0;
    text-align: left;
}

.data-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
    transition: background-color 0.15s ease;
}

.data-table tbody tr:last-child {
    border-bottom: none;
}

.data-table tbody tr:hover {
    background-color: #f8fafc;
}

.data-table td {
    padding: 1rem 1.5rem;
    color: #334155;
    font-size: 0.9375rem;
    vertical-align: middle;
}

/* Actions column */
.actions-cell {
    text-align: right;
    white-space: nowrap;
}

/* Action buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 0.375rem;
    border: none;
    background: transparent;
    transition: all 0.2s ease;
    cursor: pointer;
    margin-left: 0.25rem;
}

.edit-btn {
    color: #0284c7;
}

.edit-btn:hover {
    background-color: rgba(2, 132, 199, 0.1);
}

.delete-btn {
    color: #ef4444;
}

.delete-btn:hover {
    background-color: rgba(239, 68, 68, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .data-table thead {
        display: none;
    }
    
    .data-table tbody tr {
        display: block;
        padding: 0.75rem 0;
    }
    
    .data-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        text-align: right;
    }
    
    .data-table td:before {
        content: attr(data-label);
        font-weight: 600;
        margin-right: 1rem;
        text-align: left;
    }
    
    .actions-cell {
        justify-content: flex-end;
    }
}
</style>
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold"><i class="fas fa-tags me-2"></i> Tables Management</h2>
    
        <a href="{{ route('admin.categories.create') }}"
            class="btn"
            style="
                background-color: #0d9488;
                color: white;
                padding: 10px 20px;
                font-weight: 600;
                border-radius: 10px;
                text-decoration: none;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                display: inline-flex;
                align-items: center;
                gap: 8px;
            "
            onmouseover="this.style.backgroundColor='#0f766e'"
            onmouseout="this.style.backgroundColor='#0d9488'"
        >
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>
    
            
    </div>

    <div class="card shadow-sm rounded">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-warning">
                    <tr>
                        <th>ID</th>
                        <th>Table Number</th>
                        <th>QR Token</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tables as $table)
                        <tr>
                            <td>{{ $table->id }}</td>
                            <td>{{ $table->table_number }}</td>
                            <td>{!! QrCode::size(60)->generate('http://192.168.100.184:8000/qr/' . $table->qr_token) !!}</td>
                            <td>{{ $table->created_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this table?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none; cursor: pointer; color: #dc3545; font-size: 18px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No tables found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
