<x-teemplate title="Manajemen Kode Tindakan Terapi - RSHP UNAIR">
    <div class="page-container">
        <h1>Manajemen Data Kode Tindakan Terapi</h1>
        {{-- Placeholder untuk tombol 'Tambah Baru' --}}
        <p><a href="#" class="btn btn-primary">Tambah Kode Tindakan Baru</a></p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Kode Tindakan</th>
                    <th>Deskripsi Tindakan</th>
                    <th>Biaya Tindakan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kodeTindakanTerapi as $index => $item)
                <tr>
                    <!-- pastikan nama yang dipanggil harus sama dengan yang ada di database, jadi jika di database namanya kodeTindakanTerapi maka di panggil juga kodeTindakanTerapi -->
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->deskripsi_tindakan_terapi }}</td>
                    <td>Rp {{ number_format($item->biaya_tindakan, 2, ',', '.') }}</td>
                    <td>
                        {{-- Placeholder untuk tombol aksi Edit/Delete --}}
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center;">Tidak ada data kode tindakan terapi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>
