<x-teemplate title="Manajemen Kategori - RSHP UNAIR">
{{-- <div class="mb-3">
    <h1>Manajemen Data Kategori</h1>
    <!--tombol tambah kategori baru-->
    <form action="{{ route('admin.kategori.create') }}" method="GET" style="display: inline;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori Baru
        </button>
    </form>
</div> --}}


<div class="page-container">
    <div class="page-header">
        <h1>Manajemen Data Jenis Hewan</h1>
    </div>

    @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="mb-3">
        <!-- Tombol untuk tambah anu -->
        <form action="{{ route('admin.kategori.create') }}" method="GET" style="display: inline;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori Baru
        </button>
    </form>

    </div>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700 uppercase text-sm tracking-wider">
                    <th class="py-3 px-4 border-b">NO</th>
                    <th class="py-3 px-4 border-b" >Nama Kategori</th>
                    <th class="py-3 px-4 border-b">Aksi</th> {{-- Kolom untuk aksi seperti Edit/Delete --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $item)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->nama_kategori }}</td>
                    <td class="py-2 px-4 border-b">
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.location='#'">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Apakah Anda yakin ingin menghapus kategori ini?')) { document.getElementById('delete-form-{{ $item->idkategori }}').submit(); }">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                        <form id="delete-form-{{ $item->idkategori }}" action="#" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

<style>
    .page-container { max-width: 800px; margin: 30px auto; padding: 20px; }
    .page-header { text-align: center; margin-bottom: 20px; }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .data-table th, .data-table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
    .data-table th { background-color: #6588e8; color: white; }
    .action-link { color: #e74c3c; text-decoration: none; font-weight: bold; }
    .form-container { background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 20px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; }
    .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
    .btn-submit { background-color: #2ecc71; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
    .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
    .alert-success { background-color: #d4edda; color: #155724; }
    .alert-error { background-color: #f8d7da; color: #721c24; }
</style>
</x-teemplate>
