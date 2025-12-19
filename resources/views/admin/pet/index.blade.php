<x-teemplate title="Manajemen Data Hewan - RSHP UNAIR">
    <style>
        .page-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            text-align: center;
        }

        .page-header h1 {
            color: #333;
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        }

        .table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody td {
            padding: 1rem;
            color: #374151;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-male {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-female {
            background: #fce7f3;
            color: #9f1239;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        footer {
            margin-top: 3rem;
            padding: 1.5rem;
            text-align: center;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 1rem;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 1000px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>

    <div class="page-container">
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="page-header">
            <h1><i class="fas fa-paw"></i> Manajemen Data Hewan</h1>
        </div>

        <div class="mb-3">
            <a href="{{ route('admin.pet.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Hewan Baru
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">NO</th>
                        <th>Nama Hewan</th>
                        <th>Tanggal Lahir</th>
                        <th>Warna/Tanda</th>
                        <th>Jenis Kelamin</th>
                        <th>Ras Hewan</th>
                        <th>Nama Pemilik</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pets as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                        <td>{{ $item->warna_tanda ?? '-' }}</td>
                        <td>
                            @if($item->jenis_kelamin == 'L')
                                <span class="badge badge-male">
                                    <i class="fas fa-mars"></i> Jantan
                                </span>
                            @else
                                <span class="badge badge-female">
                                    <i class="fas fa-venus"></i> Betina
                                </span>
                            @endif
                        </td>
                        <td>{{ $item->ras->nama_ras ?? 'N/A' }}</td>
                        <td>{{ $item->pemilik->user->nama ?? 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.pet.edit', $item->idpet) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.pet.delete', $item->idpet) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus hewan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data hewan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-teemplate>