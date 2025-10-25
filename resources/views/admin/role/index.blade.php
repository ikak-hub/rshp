<x-teemplate title="Manajemen Data Role - RSHP UNAIR">
    <div class="page-container">
        <h1>Manajemen Data Role</h1>
        {{-- Placeholder untuk tombol 'Tambah Baru' --}}
        <p><a href="#" class="btn btn-primary">Tambah Role Baru</a></p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Role</th>
                    <th>Nama Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $index => $item)
                <tr>
                    <td>{{ $item->idrole }}</td>
                    <td>{{ $item->nama_role }}</td>
                    <td>
                        {{-- Placeholder untuk tombol aksi Edit/Delete --}}
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align: center;">Tidak ada data role.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>
