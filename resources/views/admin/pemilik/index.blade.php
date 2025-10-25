<x-teemplate title="Manajemen Data Pemilik - RSHP UNAIR">

    <div class="page-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Pemilik</th>
                    <th>No WA</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemilik as $index => $item)
                <tr>
                    <!-- ini penting untuk di front-end -->
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->no_wa }}</td>
                    <td>{{ $item->alamat }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <div>
    <footer>
        <p>&copy; Copyright 2025 Universitas Airlangga. All Rights Reserved</p>
    </footer>
    </div>
</x-teemplate>