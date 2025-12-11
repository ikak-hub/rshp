<x-teemplate title="RSHP - Resepsionis Dashboard">
    <style>
    body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .header-logo img {
            height: 50px;
        }
        .header-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            border-radius: 20px;
            padding: 3rem 2rem;
            margin: 2rem auto;
            max-width: 1200px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .hero-section h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-section p {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
        }
        .cards-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: none;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .menu-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .menu-card-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .menu-card-body p {
            color: #666;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-logout {
            background: #fbbf24;
            color: #333;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-logout:hover {
            background: #f59e0b;
            color: #333;
        }
        .table {
            margin-top: 1rem;
        }
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge-active {
            background: #10b981;
            color: white;
        }
        .badge-cancelled {
            background: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Registrasi</h1>
        <p>Silahkan masukkan data untuk registrasi temu janji.</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Cards Container -->
    <div class="cards-container">
        <div class="row g-4">
            <!-- Card 1: Registrasi (Pemilik & Pet) -->
            <div class="col-lg-6">
                <div class="menu-card">
                    <div class="menu-card-header">
                        <h3><i class="fas fa-users me-2"></i>Registrasi</h3>
                    </div>
                    <div class="menu-card-body">
                        <p>Kelola data pemilik dan hewan peliharaan</p>
                        
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pemilik-tab">
                                    <i class="fas fa-user me-2"></i>Pemilik
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pet-tab">
                                    <i class="fas fa-paw me-2"></i>Pet
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Tab Pemilik -->
                            <div class="tab-pane fade show active" id="pemilik-tab">
                                <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addPemilikModal">
                                    <i class="fas fa-plus me-2"></i>Tambah Pemilik
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>No. WA</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pemiliks as $index => $pemilik)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pemilik->nama }}</td>
                                                <td>{{ $pemilik->no_wa }}</td>
                                                <td>{{ $pemilik->alamat }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" onclick="editPemilik({{ json_encode($pemilik) }})">
                                                        <i class="fas fa-edit">EDIT</i>
                                                    </button>
                                                    <form action="{{ route('resepsionis.pemilik.destroy', $pemilik->idpemilik) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                                            <i class="fas fa-trash">DELETE</i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada data pemilik</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Pet -->
                            <div class="tab-pane fade" id="pet-tab">
                                <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addPetModal">
                                    <i class="fas fa-plus me-2"></i>Tambah Pet
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Pemilik</th>
                                                <th>Ras</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pets as $index => $pet)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pet->nama }}</td>
                                                <td>{{ $pet->nama_pemilik }}</td>
                                                <td>{{ $pet->nama_ras }}</td>
                                                <td>{{ $pet->jenis_kelamin == 'L' ? 'Jantan' : 'Betina' }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" onclick="editPet({{ json_encode($pet) }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('resepsionis.pet.destroy', $pet->idpet) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada data pet</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Temu Dokter -->
            <div class="col-lg-6">
                <div class="menu-card">
                    <div class="menu-card-header">
                        <h3><i class="fas fa-calendar-check me-2"></i>Temu Dokter</h3>
                    </div>
                    <div class="menu-card-body">
                        <p>Kelola jadwal konsultasi dengan dokter</p>
                        
                        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                            <i class="fas fa-plus me-2"></i>Buat Janji Temu
                        </button>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No Urut</th>
                                        <th>Pet</th>
                                        <th>Pemilik</th>
                                        <th>Dokter</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->no_urut }}</td>
                                        <td>{{ $appointment->nama_pet }}</td>
                                        <td>{{ $appointment->nama_pemilik }}</td>
                                        <td>{{ $appointment->nama_dokter ?? '-' }}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($appointment->waktu_daftar)) }}</td>
                                        <td>
                                            @if($appointment->status == 'A')
                                            <span class="badge-status badge-active">Aktif</span>
                                            @else
                                            <span class="badge-status badge-cancelled">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($appointment->status == 'A')
                                            <form action="{{ route('resepsionis.appointment.cancel', $appointment->idreservasi_dokter) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin batalkan janji temu ini?')">
                                                    <i class="fas fa-times me-1"></i>Batal
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada janji temu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pemilik -->
    <div class="modal fade" id="addPemilikModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Pemilik</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('resepsionis.pemilik.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pemilik" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" placeholder="08123456789" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pemilik -->
    <div class="modal fade" id="editPemilikModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Pemilik</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPemilikForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama" id="edit_pemilik_nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_pemilik_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="no_wa" id="edit_pemilik_no_wa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="edit_pemilik_alamat" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pet -->
    <div class="modal fade" id="addPetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-paw me-2"></i>Tambah Pet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('resepsionis.pet.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pet</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pemilik</label>
                            <select name="idpemilik" class="form-select" required>
                                <option value="">Pilih Pemilik</option>
                                @foreach($pemiliks as $pemilik)
                                <option value="{{ $pemilik->idpemilik }}">{{ $pemilik->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ras</label>
                            <select name="idras_hewan" class="form-select" required>
                                <option value="">Pilih Ras</option>
                                @foreach($breeds as $breed)
                                <option value="{{ $breed->idras_hewan }}">{{ $breed->nama_ras }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Jantan</option>
                                <option value="P">Betina</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna/Tanda</label>
                            <input type="text" name="warna_tanda" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pet -->
    <div class="modal fade" id="editPetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-paw me-2"></i>Edit Pet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPetForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pet</label>
                            <input type="text" name="nama" id="edit_pet_nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pemilik</label>
                            <select name="idpemilik" id="edit_pet_idpemilik" class="form-select" required>
                                @foreach($pemiliks as $pemilik)
                                <option value="{{ $pemilik->idpemilik }}">{{ $pemilik->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ras</label>
                            <select name="idras_hewan" id="edit_pet_idras" class="form-select" required>
                                @foreach($breeds as $breed)
                                <option value="{{ $breed->idras_hewan }}">{{ $breed->nama_ras }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_pet_tanggal_lahir" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_pet_jenis_kelamin" class="form-select" required>
                                <option value="L">Jantan</option>
                                <option value="P">Betina</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna/Tanda</label>
                            <input type="text" name="warna_tanda" id="edit_pet_warna_tanda" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Appointment -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-plus me-2"></i>Buat Janji Temu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('resepsionis.appointment.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pet</label>
                            <select name="idpet" class="form-select" required>
                                <option value="">Pilih Pet</option>
                                @foreach($petsForAppointment as $pet)
                                <option value="{{ $pet->idpet }}">{{ $pet->nama }} - {{ $pet->nama_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dokter</label>
                            <select name="idrole_user" class="form-select" required>
                                <option value="">Pilih Dokter</option>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->idrole_user }}">{{ $doctor->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu Pendaftaran</label>
                            <input type="datetime-local" name="waktu_daftar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">Buat Janji</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editPemilik(pemilik) {
            document.getElementById('editPemilikForm').action = `/resepsionis/pemilik/${pemilik.idpemilik}`;
            document.getElementById('edit_pemilik_nama').value = pemilik.nama;
            document.getElementById('edit_pemilik_email').value = pemilik.email;
            document.getElementById('edit_pemilik_no_wa').value = pemilik.no_wa;
            document.getElementById('edit_pemilik_alamat').value = pemilik.alamat;
            new bootstrap.Modal(document.getElementById('editPemilikModal')).show();
        }

        function editPet(pet) {
            document.getElementById('editPetForm').action = `/resepsionis/pet/${pet.idpet}`;
            document.getElementById('edit_pet_nama').value = pet.nama;
            document.getElementById('edit_pet_idpemilik').value = pet.idpemilik;
            document.getElementById('edit_pet_idras').value = pet.idras_hewan;
            document.getElementById('edit_pet_tanggal_lahir').value = pet.tanggal_lahir;
            document.getElementById('edit_pet_jenis_kelamin').value = pet.jenis_kelamin;
            document.getElementById('edit_pet_warna_tanda').value = pet.warna_tanda || '';
            new bootstrap.Modal(document.getElementById('editPetModal')).show();
        }
    </script>
</body>
</x-teemplate>