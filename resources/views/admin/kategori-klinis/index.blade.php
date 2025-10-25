<x-teemplate title="Manajemen Kategori Klinis - RSHP UNAIR">
    <div class="page-container">
        <h1>Manajemen Data Kategori Klinis</h1>
        {{-- Placeholder untuk tombol 'Tambah Baru' --}}
        <p><a href="#" class="btn btn-primary">Tambah Kategori Klinis Baru</a></p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Kategori Klinis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($KategoriKlinis as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_kategori_klinis }}</td>
                    <td>
                        {{-- Placeholder untuk tombol aksi Edit/Delete --}}
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align: center;">Tidak ada data kategori klinis.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>
