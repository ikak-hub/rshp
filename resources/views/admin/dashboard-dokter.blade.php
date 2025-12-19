<x-teemplate title="RSHP - Dashboard Dkter">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s;
            cursor: pointer;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .nav-link i {
            margin-right: 0.5rem;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            margin-bottom: 1.5rem;
        }
        .stat-card {
            border-left: 4px solid;
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .stat-card.primary {
            border-left-color: #667eea;
        }
        .stat-card.success {
            border-left-color: #10b981;
        }
        .stat-card.info {
            border-left-color: #3b82f6;
        }
        .stat-card.warning {
            border-left-color: #f59e0b;
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .detail-card {
            transition: all 0.3s;
            border-left: 4px solid #667eea;
        }
        .detail-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .appointment-card {
            border-left: 4px solid #10b981;
        }
        .appointment-card.completed {
            border-left-color: #6b7280;
            opacity: 0.7;
        }
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4">
            <div class="text-center mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($dokter->nama) }}&size=100&background=fff&color=667eea" 
                     class="rounded-circle mb-3" alt="Avatar">
                <h5 class="mb-0">{{ $dokter->nama }}</h5>
                <small class="text-white-50">Dokter Hewan</small>
            </div>
            <hr class="bg-white opacity-25">
            <nav class="nav flex-column">
                <a class="nav-link active" data-section="dashboard">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="nav-link" data-section="appointments">
                    <i class="bi bi-calendar-check"></i> Jadwal Temu
                    @if($appointmentsToday->count() > 0)
                    <span class="badge bg-danger ms-2">{{ $appointmentsToday->count() }}</span>
                    @endif
                </a>
                <a class="nav-link" data-section="patients">
                    <i class="bi bi-heart-pulse"></i> Data Pasien
                </a>
                <a href="{{ route('admin.rekam-medis.create', $apt->idreservasi_dokter) }}" 
                class="btn btn-sm btn-custom">
                    <i class="bi bi-clipboard-plus"></i> Mulai Pemeriksaan
                </a>
                <a class="nav-link" data-section="profile">
                    <i class="bi bi-person-circle"></i> Profil Saya
                </a>
                <hr class="bg-white opacity-25">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-start w-100 border-0 bg-transparent">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Dashboard Section -->
        <div id="dashboard-section" class="content-section active">
            <h2 class="mb-4">Dashboard</h2>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Jadwal Hari Ini</p>
                                    <h3 class="mb-0">{{ $appointmentsToday->count() }}</h3>
                                </div>
                                <i class="bi bi-calendar-check fs-1 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Pasien</p>
                                    <h3 class="mb-0">{{ $pets->count() }}</h3>
                                </div>
                                <i class="bi bi-heart-pulse fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Rekam Medis</p>
                                    <h3 class="mb-0">{{ $rekamMedis->count() }}</h3>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Selesai Hari Ini</p>
                                    <h3 class="mb-0">{{ $appointmentsToday->where('status', 'S')->count() }}</h3>
                                </div>
                                <i class="bi bi-check-circle fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, Dr. {{ $dokter->nama }}!</h5>
                    <p class="card-text">Gunakan menu di sebelah kiri untuk mengakses fitur-fitur yang tersedia.</p>
                </div>
            </div>

            <!-- Quick Access: Jadwal Hari Ini -->
            @if($appointmentsToday->count() > 0)
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Jadwal Pemeriksaan Hari Ini</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($appointmentsToday->take(4) as $apt)
                        <div class="col-md-6 mb-3">
                            <div class="card appointment-card {{ $apt->idrekam_medis ? 'completed' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                <span class="badge bg-primary">No. {{ $apt->no_urut }}</span>
                                                {{ $apt->nama_pet }}
                                            </h6>
                                            <p class="text-muted mb-1 small">Pemilik: {{ $apt->nama_pemilik }}</p>
                                            <p class="text-muted mb-0 small">
                                                <i class="bi bi-clock"></i> {{ date('H:i', strtotime($apt->waktu_daftar)) }}
                                            </p>
                                        </div>
                                        <div>
                                            @if($apt->idrekam_medis)
                                                <button class="btn btn-sm btn-success" onclick="viewRecord({{ $apt->idrekam_medis }})">
                                                    <i class="bi bi-check-circle"></i> Selesai
                                                </button>
                                            @else
                                                <a href="{{ route('dokter.rekam-medis.create', $apt->idreservasi_dokter) }}" 
                                                   class="btn btn-sm btn-custom">
                                                    <i class="bi bi-clipboard-plus"></i> Periksa
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($appointmentsToday->count() > 4)
                    <div class="text-center mt-2">
                        <a href="#" class="btn btn-sm btn-outline-primary" onclick="switchSection('appointments'); return false;">
                            Lihat Semua Jadwal <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Appointments Section -->
        <div id="appointments-section" class="content-section">
            <h2 class="mb-4">Jadwal Temu Hari Ini</h2>
            <div class="card">
                <div class="card-body">
                    @if($appointmentsToday->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No Urut</th>
                                    <th>Waktu</th>
                                    <th>Pasien</th>
                                    <th>Pemilik</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointmentsToday as $apt)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $apt->no_urut }}</span></td>
                                    <td>{{ date('H:i', strtotime($apt->waktu_daftar)) }}</td>
                                    <td><strong>{{ $apt->nama_pet }}</strong></td>
                                    <td>{{ $apt->nama_pemilik }}</td>
                                    <td>
                                        @if($apt->idrekam_medis)
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($apt->status == 'A')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $apt->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($apt->idrekam_medis)
                                            <button class="btn btn-sm btn-info text-white" onclick="viewRecord({{ $apt->idrekam_medis }})">
                                                <i class="bi bi-eye"></i> Lihat
                                            </button>
                                        @else
                                            <a href="{{ route('dokter.rekam-medis.create', $apt->idreservasi_dokter) }}" 
                                               class="btn btn-sm btn-custom">
                                                <i class="bi bi-clipboard-plus"></i> Mulai Pemeriksaan
                                            </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewPatient({{ $apt->idpet }})">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Tidak ada jadwal temu hari ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pasien Section -->
        <div id="patients-section" class="content-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Data Pasien</h2>
                <input type="text" class="form-control w-auto" id="searchPatient" placeholder="Cari pasien...">
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Hewan</th>
                                    <th>Pemilik</th>
                                    <th>Ras</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="patientTableBody">
                                @forelse($pets as $index => $pet)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $pet->nama }}</strong></td>
                                    <td>{{ $pet->nama_pemilik }}</td>
                                    <td>{{ $pet->nama_ras }}</td>
                                    <td>{{ date('d/m/Y', strtotime($pet->tanggal_lahir)) }}</td>
                                    <td>{{ $pet->jenis_kelamin == 'L' ? 'Jantan' : 'Betina' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-custom" onclick="viewPatient({{ $pet->idpet }})">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data pasien</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Records Section -->
        <div id="medical-records-section" class="content-section">
            <h2 class="mb-4">Rekam Medis</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pasien</th>
                                    <th>Diagnosis</th>
                                    <th>Dokter</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $index => $rm)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($rm->created_at)) }}</td>
                                    <td><strong>{{ $rm->nama_pet }}</strong></td>
                                    <td>{{ Str::limit($rm->diagnosa ?? '-', 50) }}</td>
                                    <td>{{ $rm->nama_dokter ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white" onclick="viewRecord({{ $rm->idrekam_medis }})">
                                            <i class="bi bi-eye"></i> Lihat
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada rekam medis</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="profile-section" class="content-section">
            <h2 class="mb-4">Profil Saya</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($dokter->nama) }}&size=150&background=667eea&color=fff" 
                                 class="rounded-circle mb-3" alt="Avatar">
                            <h5>{{ $dokter->nama }}</h5>
                            <p class="text-muted">Dokter Hewan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Profil</h5>
                            <form action="{{ route('dokter.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           name="nama" value="{{ old('nama', $dokter->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', $dokter->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-custom">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Patient -->
    <div class="modal fade" id="patientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pasien</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="patientContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Record with Details -->
    <div class="modal fade" id="recordModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Rekam Medis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="recordContent">
                        <div class="text-center">
                            <div class="spinner-border text-primary"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Detail Tindakan & Terapi</h6>
                        <button class="btn btn-sm btn-custom" onclick="addDetailFromModal()">
                            <i class="bi bi-plus-circle"></i> Tambah Detail
                        </button>
                    </div>
                    <div id="detailsContent"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Detail -->
    <div class="modal fade" id="addDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Detail Tindakan/Terapi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('dokter.detail-rekam-medis.store') }}" method="POST" id="addDetailForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="idrekam_medis" id="idrekam_medis">
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Tindakan/Terapi <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="idkode_tindakan_terapi" id="kodeTindakan" required>
                                <option value="">Pilih Tindakan/Terapi</option>
                            </select>
                            <small class="text-muted">Ketik untuk mencari kode tindakan</small>
                        </div>

                        <div id="tindakanInfo" class="alert alert-info d-none mb-3">
                            <strong>Deskripsi:</strong> <span id="tindakanDeskripsi"></span><br>
                            <strong>Kategori:</strong> <span id="tindakanKategori"></span><br>
                            <strong>Jenis:</strong> <span id="tindakanJenis"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail/Catatan Tambahan</label>
                            <textarea class="form-control" name="detail" rows="3" 
                                      placeholder="Masukkan detail tambahan (opsional)..."></textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Detail -->
    <div class="modal fade" id="editDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Detail Tindakan/Terapi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editDetailForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editDetailContent">
                        <div class="text-center">
                            <div class="spinner-border text-primary"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">
                            <i class="bi bi-check-circle"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let currentRekamMedisId = null;
        let kodeTindakanData = [];

        // Navigation
        document.querySelectorAll('.nav-link[data-section]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                switchSection(this.dataset.section);
            });
        });

        function switchSection(section) {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.querySelector(`.nav-link[data-section="${section}"]`)?.classList.add('active');
            
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            document.getElementById(section + '-section')?.classList.add('active');
        }

        // Search patient
        document.getElementById('searchPatient')?.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('#patientTableBody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
    // Load kode tindakan untuk select2
    function loadKodeTindakan() {
        fetch('/dokter/kode-tindakan')
            .then(response => response.json())
            .then(data => {
                kodeTindakanData = data;
                const select = $('#kodeTindakan');
                select.empty();
                select.append('<option value="">Pilih Tindakan/Terapi</option>');
                
                data.forEach(item => {
                    select.append(
                        `<option value="${item.idkode_tindakan_terapi}" 
                                 data-deskripsi="${item.deskripsi_tindakan_terapi}"
                                 data-kategori="${item.nama_kategori}"
                                 data-jenis="${item.nama_kategori_klinis}">
                            ${item.kode} - ${item.deskripsi_tindakan_terapi}
                        </option>`
                    );
                });

                // Initialize Select2
                select.select2({
                    dropdownParent: $('#addDetailModal'),
                    width: '100%',
                    placeholder: 'Cari kode tindakan...'
                });
            });
    }

    // Show tindakan info when selected
    $('#kodeTindakan').on('change', function() {
        const selected = $(this).find('option:selected');
        if (selected.val()) {
            $('#tindakanDeskripsi').text(selected.data('deskripsi'));
            $('#tindakanKategori').text(selected.data('kategori'));
            $('#tindakanJenis').text(selected.data('jenis'));
            $('#tindakanInfo').removeClass('d-none');
        } else {
            $('#tindakanInfo').addClass('d-none');
        }
    });

    // View patient
    function viewPatient(id) {
        const modal = new bootstrap.Modal(document.getElementById('patientModal'));
        modal.show();
        
        fetch(`/dokter/patient/${id}`)
            .then(response => response.json())
            .then(data => {
                const pet = data.pet;
                document.getElementById('patientContent').innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Nama Hewan:</strong><br>${pet.nama}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Ras:</strong><br>${pet.nama_ras}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Tanggal Lahir:</strong><br>${new Date(pet.tanggal_lahir).toLocaleDateString('id-ID')}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Jenis Kelamin:</strong><br>${pet.jenis_kelamin == 'L' ? 'Jantan' : 'Betina'}
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Pemilik:</strong><br>${pet.nama_pemilik}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong><br>${pet.email || '-'}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>No. WA:</strong><br>${pet.no_wa || '-'}
                        </div>
                        <div class="col-12">
                            <strong>Alamat:</strong><br>${pet.alamat || '-'}
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('patientContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>${error.message}
                    </div>
                `;
            });
    }

    // View record with details
    function viewRecord(id) {
        currentRekamMedisId = id;
        const modal = new bootstrap.Modal(document.getElementById('recordModal'));
        modal.show();
        
        fetch(`/dokter/rekam-medis/${id}`)
            .then(response => response.json())
            .then(data => {
                const rm = data.rekam_medis;
                document.getElementById('recordContent').innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Tanggal Periksa:</strong><br>${new Date(rm.created_at).toLocaleString('id-ID')}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Pasien:</strong><br>${rm.nama_pet}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Dokter:</strong><br>${rm.nama_dokter || '-'}
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Anamnesa:</strong><br>${rm.anamnesa || '-'}
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Temuan Klinis:</strong><br>${rm.temuan_klinis || '-'}
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Diagnosis:</strong><br>${rm.diagnosa || '-'}
                        </div>
                    </div>
                `;

                displayDetails(data.details);
            })
            .catch(error => {
                document.getElementById('recordContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>${error.message}
                    </div>
                `;
            });
    }

    // Display details
    function displayDetails(details) {
        if (details && details.length > 0) {
            let html = '<div class="row">';
            details.forEach(detail => {
                html += `
                    <div class="col-md-6 mb-3">
                        <div class="card detail-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary">${escapeHtml(detail.kode)}</span>
                                        <span class="badge bg-info">${escapeHtml(detail.nama_kategori_klinis)}</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-warning" onclick="editDetail(${detail.iddetail_rekam_medis})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete(${detail.iddetail_rekam_medis})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <h6 class="mb-2">${escapeHtml(detail.deskripsi_tindakan_terapi)}</h6>
                                <p class="text-muted small mb-1">
                                    <strong>Kategori:</strong> ${escapeHtml(detail.nama_kategori)}
                                </p>
                                ${detail.detail ? `<p class="mb-2">${escapeHtml(detail.detail)}</p>` : ''}
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> ${new Date(detail.tanggal_input).toLocaleString('id-ID')}
                                </small>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            document.getElementById('detailsContent').innerHTML = html;
        } else {
            document.getElementById('detailsContent').innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada detail tindakan/terapi</p>
                </div>
            `;
        }
    }

    // Add detail from modal
    function addDetailFromModal() {
        if (!currentRekamMedisId) {
            alert('ID Rekam Medis tidak ditemukan');
            return;
        }
        
        bootstrap.Modal.getInstance(document.getElementById('recordModal')).hide();
        
        document.getElementById('idrekam_medis').value = currentRekamMedisId;
        document.getElementById('addDetailForm').reset();
        document.getElementById('idrekam_medis').value = currentRekamMedisId;
        $('#kodeTindakan').val('').trigger('change');
        $('#tindakanInfo').addClass('d-none');
        
        loadKodeTindakan();
        new bootstrap.Modal(document.getElementById('addDetailModal')).show();
    }

    // Edit detail
    function editDetail(id) {
        const editModal = new bootstrap.Modal(document.getElementById('editDetailModal'));
        editModal.show();
        
        fetch(`/dokter/detail-rekam-medis/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editDetailForm').action = `/dokter/detail-rekam-medis/${id}`;
                
                // Load kode tindakan untuk edit
                fetch('/dokter/kode-tindakan')
                    .then(response => response.json())
                    .then(tindakanList => {
                        let options = '<option value="">Pilih Tindakan/Terapi</option>';
                        tindakanList.forEach(item => {
                            const selected = item.idkode_tindakan_terapi == data.idkode_tindakan_terapi ? 'selected' : '';
                            options += `<option value="${item.idkode_tindakan_terapi}" ${selected}>
                                ${item.kode} - ${item.deskripsi_tindakan_terapi}
                            </option>`;
                        });
                        
                        document.getElementById('editDetailContent').innerHTML = `
                            <div class="mb-3">
                                <label class="form-label">Kode Tindakan/Terapi <span class="text-danger">*</span></label>
                                <select class="form-select" name="idkode_tindakan_terapi" required>
                                    ${options}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail/Catatan Tambahan</label>
                                <textarea class="form-control" name="detail" rows="3">${escapeHtml(data.detail || '')}</textarea>
                            </div>
                        `;
                    });
            })
            .catch(error => {
                document.getElementById('editDetailContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>${error.message}
                    </div>
                `;
            });
    }

    // Confirm delete
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus detail tindakan/terapi ini?')) {
            deleteDetail(id);
        }
    }

    // Delete detail
    function deleteDetail(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dokter/detail-rekam-medis/${id}`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }

    // Escape HTML
    function escapeHtml(text) {
        if (!text) return '-';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Auto hide alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            new bootstrap.Alert(alert).close();
        });
    }, 5000);

    // Auto open rekam medis modal after create
    @if(session('open_rekam_medis'))
        setTimeout(() => {
            viewRecord({{ session('open_rekam_medis') }});
        }, 500);
    @endif

    // Save last viewed rekam medis
    document.getElementById('addDetailForm')?.addEventListener('submit', function() {
        if (currentRekamMedisId) {
            localStorage.setItem('lastViewedRekamMedis', currentRekamMedisId);
        }
    });

    window.addEventListener('load', function() {
        const lastViewed = localStorage.getItem('lastViewedRekamMedis');
        if (lastViewed && {{ session()->has('success') ? 'true' : 'false' }}) {
            setTimeout(() => {
                viewRecord(lastViewed);
                localStorage.removeItem('lastViewedRekamMedis');
            }, 500);
        }
    });
</script>
</body>
</html>
</x-teemplate>