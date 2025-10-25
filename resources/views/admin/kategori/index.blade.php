<x-teemplate title="Manajemen Kategori - RSHP UNAIR">
    <div class="page-container">
        <h1>Manajemen Data Kategori</h1>
        {{-- Placeholder for 'Tambah Baru' button. Route 'admin.kategori.create' would be needed for this. --}}
        <p><a href="#" class="btn btn-primary">Tambah Kategori Baru</a></p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th> {{-- Kolom untuk aksi seperti Edit/Delete --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>
                        {{-- Placeholder untuk tombol aksi. Route seperti 'admin.kategori.edit' dan 'admin.kategori.destroy' akan dibutuhkan. --}}
                        {{-- <a href="{{ route('admin.kategori.edit', $item->idkategori) }}" class="btn btn-sm btn-info">Edit</a> --}}
                        {{-- <form action="{{ route('admin.kategori.destroy', $item->idkategori) }}" method="POST" style="display:inline;"> --}}
                        {{--     @csrf --}}
                        {{--     @method('DELETE') --}}
                        {{--     <button type="submit" class="btn btn-sm btn-danger">Delete</button> --}}
                        {{-- </form> --}}
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Tidak ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>
