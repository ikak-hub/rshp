
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <p>Selamat datang, <strong>{{ session('user_name') }}</strong>! Anda login sebagai <strong>{{ session('user_role_name') }}</strong>.</p>
                    <hr>
                    <h5>Akses Cepat Data Master:</h5>
                    <div class="list-group">
                        <a href="{{ route('admin.jenis-hewan.index') }}" class="list-group-item list-group-item-action">Data Jenis Hewan</a>
                        <a href="{{ route('admin.ras-hewan.index') }}" class="list-group-item list-group-item-action">Data Ras Hewan</a>
                        <a href="{{ route('admin.pemilik.index') }}" class="list-group-item list-group-item-action">Data Pemilik</a>
                        <a href="{{ route('admin.pet.index') }}" class="list-group-item list-group-item-action">Data Hewan Peliharaan (Pet)</a>
                        <a href="{{ route('admin.kategori.index') }}" class="list-group-item list-group-item-action">Data Kategori</a>
                        <a href="{{ route('admin.kategoriklinis.index') }}" class="list-group-item list-group-item-action">Data Kategori Klinis</a>
                        <a href="{{ route('admin.kodetindakanterapi.index') }}" class="list-group-item list-group-item-action">Data Kode Tindakan Terapi</a>
                        <a href="{{ route('admin.role.index') }}" class="list-group-item list-group-item-action">Data Role</a>
                        <a href="{{ route('admin.roleuser.index') }}" class="list-group-item list-group-item-action">Data Role User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<head>
    <!-- panggil css -->
     <!-- @vite('resources/css/app.css') -->
     <style>
        /* ====== CSS BERSIH UNTUK HEADER (GANTI SEMUA CSS LAMA ANDA) ====== */

        /* Style utama untuk bar header */
       .navbar {
            width: 100%;
            padding: 10px 40px; /* Jarak di dalam header */
            background-color: transparent; /* Ganti ke 'transparent' jika tidak ingin ada background */
            display: flex;
            justify-content: space-between; /* PENTING: Mendorong logo ke kiri dan menu ke kanan */
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        /* Style untuk logo */
        .navbar .left-logo {
            height: 50px; /* Atur tinggi logo */
            width: auto;
        }

        /* Menghilangkan bullet point dari list menu */
        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex; /* Membuat item menu sejajar horizontal */
            gap: 15px; /* Jarak antar tombol */
        }
        .btn-dashboard {
            background-color: #f1c40f;
            color: black;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn-dashboard:hover {
            background-color: #e2b607;
        }
        /* ====== AKHIR DARI BLOK CSS HEADER YGY ====== */

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        /* CSS untuk konten halaman (tidak diubah) */
        .page-container { max-width: 1000px; margin: 30px auto; padding: 20px; }
        .page-header { background: linear-gradient(135deg, #6588e8, #4a6fc4); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; text-align: center; margin-top: 30px; }
        .page-header h1 { margin: 0; font-size: 28px; }
        .page-header p { margin-top: 10px; }
        .nav-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .nav-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none; color: #333; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column; justify-content: center; }
        .nav-card:hover { transform: translateY(-5px); box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15); }
        .nav-card h3 { color: #6588e8; margin-top: 0; margin-bottom: 15px; font-size: 22px; }
        .nav-card p { color: #666; line-height: 1.6; }
        footer { text-align: center; padding: 20px; margin-top: 40px; color: #777; }
    </style>
</head>

<x-template-logout title="RSHP - Dashboard">
 <div class="page-container">
        <div class="page-header">
            <h1>Data Master</h1>
            <p>Pilih salah satu menu di bawah untuk mengelola data sistem.</p>
        </div>

        <div class="nav-grid">
            <a href="{{ route('admin.roleuser.index') }}" class="nav-card">
                <h3>Data User</h3>
                <p>Kelola data, peran, dan kata sandi pengguna sistem.</p>
            </a>

            <a href="{{ route('admin.role.index') }}" class="nav-card">
                <h3>Manajemen Role</h3>
                <p>Kelola peran atau hak akses yang tersedia dalam sistem.</p>
            </a>

            <a href="{{ route('admin.ras-hewan.index') }}" class="nav-card">
                <h3>Manajemen Ras Hewan</h3>
                <p>Kelola data master untuk ras hewan berdasarkan jenisnya.</p>
            </a>

            <a href="{{ route('admin.jenis-hewan.index') }}" class="nav-card">
                <h3>Manajemen Jenis Hewan</h3>
                <p>Kelola data master untuk jenis-jenis hewan.</p>
            </a>

            <a href="{{ route('admin.pemilik.index') }}" class="nav-card">
                <h3>Data Pemilik</h3>
                <p>Kelola data pemilik.</p>
            </a>

            <a href="{{ route('admin.pet.index') }}" class="nav-card">
                <h3>Data Hewan Peliharaan (Pet)</h3>
                <p>Kelola data hewan peliharaan.</p>
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="nav-card">
                <h3>Data Kategori</h3>
                <p>Kelola data kategori.</p>
            </a>

            <a href="{{ route('admin.kategoriklinis.index') }}" class="nav-card">
                <h3>Data Kategori Klinis</h3>
                <p>Kelola data kategori klinis.</p>
            </a>

            <a href="{{ route('admin.kodetindakanterapi.index') }}" class="nav-card">
                <h3>Data Kode Tindakan Terapi</h3>
                <p>Kelola kode tindakan terapi.</p>
            </a>
        </div>

            </div>

    <footer>
        <p>&copy; Copyright <?php echo date("Y"); ?> Universitas Airlangga. All Rights Reserved</p>
    </footer>
</x-teemplate>

