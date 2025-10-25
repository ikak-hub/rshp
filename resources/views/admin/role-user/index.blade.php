<x-teemplate title="Manajemen Data Role User - RSHP UNAIR">
    <div class="page-container">
        <h1>Manajemen Data Role Pengguna</h1>
        {{-- Placeholder untuk tombol 'Tambah Baru' --}}
        <p><a href="#" class="btn btn-primary">Tambah Role Pengguna Baru</a></p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roleUsers as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->nama ?? 'N/A' }}</td> {{-- Menggunakan null coalescing operator untuk menghindari error jika relasi user tidak ada --}}
                    <td>{{ $item->role->nama_role ?? 'N/A' }}</td> {{-- Menggunakan null coalescing operator untuk menghindari error jika relasi role tidak ada --}}
                    <td>
                        {{-- Placeholder untuk tombol aksi Edit/Delete --}}
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center;">Tidak ada data role pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>
