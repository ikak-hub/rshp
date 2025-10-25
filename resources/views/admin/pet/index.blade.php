<x-teemplate title="Manajemen Data Hewan - RSHP UNAIR">
    <div class="page-container">
        <h1>Manajemen Data Hewan Peliharaan</h1>
        {{-- Placeholder untuk tombol 'Tambah Baru' --}}
        <p><a href="#" class="btn btn-primary">Tambah Hewan Baru</a></p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Hewan</th>
                    <th>Tanggal Lahir</th>
                    <th>Warna Tanda</th>
                    <th>Jenis Kelamin</th>
                    <th>Ras Hewan</th>
                    <th>Nama Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pets as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $item->warna_tanda }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->ras->nama_ras ?? 'N/A' }}</td> {{-- Menggunakan null coalescing operator untuk menghindari error jika relasi ras tidak ada --}}
                    <td>{{ $item->pemilik->user->nama ?? 'N/A' }}</td> {{-- Menggunakan null coalescing operator untuk menghindari error jika relasi pemilik atau user tidak ada --}}
                    <td>
                        {{-- Placeholder untuk tombol aksi Edit/Delete --}}
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align: center;">Tidak ada data hewan peliharaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>
