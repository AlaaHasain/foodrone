@extends('admin.layouts.app')

@section('title', 'Tables Management')

@section('content')
<style>
    .add-btn {
        background-color: #0d9488;
        color: white;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .add-btn:hover {
        background-color: #0f766e;
        transform: translateY(-2px);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h2 {
        font-weight: 700;
        color: #1e293b;
    }

    .table thead {
        background-color: #fef3c7;
    }

    .table th {
        color: #92400e;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.95rem;
        color: #374151;
    }

    .qr-code svg {
        max-width: 60px;
        height: auto;
    }

    .delete-btn {
        border: none;
        background: none;
        color: #dc3545;
        font-size: 18px;
        transition: transform 0.2s ease;
    }

    .delete-btn:hover {
        transform: scale(1.2);
        color: #a30000;
    }

    .no-tables {
        text-align: center;
        font-weight: 500;
        color: #6b7280;
        padding: 20px;
    }
</style>

<div class="container py-5">
    <div class="page-header">
        <h2><i class="fas fa-table me-2 text-warning"></i>Tables Management</h2>
        <a href="{{ route('admin.tables.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Add New Table
        </a>
    </div>

    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Table Number</th>
                        <th>QR Code</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tables as $table)
                        <tr>
                            <td>{{ $table->id }}</td>
                            <td>{{ $table->table_number }}</td>
                            <td class="qr-code">{!! QrCode::size(60)->generate('http:172.20.10.2:8000/qr/' . $table->qr_token) !!}</td>
                            <td>{{ $table->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this table?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-tables">No tables found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
