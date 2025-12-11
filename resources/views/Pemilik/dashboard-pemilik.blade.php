<x-teemplate title="RSHP - Dashboard Pemilik" pageTitle="Dashboard Pemilik">
    <style>
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
                padding: 2rem;
                margin: 2rem auto;
                max-width: 1400px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            .welcome-text {
                color: white;
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }
            .welcome-subtitle {
                color: rgba(255,255,255,0.9);
                font-size: 1.1rem;
            }
            .dashboard-container {
                max-width: 1400px;
                margin: 0 auto 2rem;
                padding: 0 1rem;
            }
            .card-custom {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                margin-bottom: 1.5rem;
                border: none;
            }
            .card-header-custom {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                margin-bottom: 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .card-header-custom h4 {
                margin: 0;
                font-weight: 600;
            }
            .btn-custom {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
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
            .profile-card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-radius: 15px;
                padding: 2rem;
                margin-bottom: 1.5rem;
            }
            .profile-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 3rem;
                color: #667eea;
                margin: 0 auto 1rem;
            }
            .pet-card {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1rem;
                margin-bottom: 1rem;
                border-left: 4px solid #667eea;
            }
            .pet-card h5 {
                color: #667eea;
                margin-bottom: 0.5rem;
            }
            .badge-status {
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-weight: 600;
                font-size: 0.875rem;
            }
            .badge-active {
                background: #10b981;
                color: white;
            }
            .badge-cancelled {
                background: #ef4444;
                color: white;
            }
            .badge-completed {
                background: #3b82f6;
                color: white;
            }
            .table {
                margin-top: 0;
            }
            .table thead {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }
            .modal-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }
            .info-row {
                display: flex;
                justify-content: space-between;
                padding: 0.75rem 0;
                border-bottom: 1px solid rgba(255,255,255,0.2);
            }
            .info-row:last-child {
                border-bottom: none;
            }
            .info-label {
                font-weight: 600;
                opacity: 0.9;
            }
            .empty-state {
                text-align: center;
                padding: 3rem 1rem;
                color: #6b7280;
            }
            .empty-state i {
                font-size: 4rem;
                margin-bottom: 1rem;
                opacity: 0.3;
            }
        </style>
    </head>
    <body>
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="welcome-text">
                <i class="fas fa-home me-2"></i>Selamat Datang, {{ $pemilik->nama }}!
            </div>
            <p class="welcome-subtitle mb-0">Kelola jadwal konsultasi dan pantau kesehatan hewan peliharaan Anda</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="dashboard-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="dashboard-container">
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

        <!-- Dashboard Content -->
        <div class="dashboard-container">
            <div class="row">
                <!-- Left Column: Profile & Pets -->
                <div class="col-lg-4">
                    <!-- Profile Card -->
                    <div class="profile-card">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="text-center mb-3">{{ $pemilik->nama }}</h3>
                        
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-envelope me-2"></i>Email</span>
                            <span>{{ $pemilik->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-phone me-2"></i>No. WA</span>
                            <span>{{ $pemilik->no_wa }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-map-marker-alt me-2"></i>Alamat</span>
                            <span>{{ $pemilik->alamat }}</span>
                        </div>

                        <button class="btn btn-light w-100 mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </button>
                    </div>

                    <!-- Pets Card -->
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h4><i class="fas fa-paw me-2"></i>Hewan Peliharaan Saya</h4>
                            <span class="badge bg-light text-dark">{{ count($pets) }}</span>
                        </div>

                        @forelse($pets as $pet)
                        <div class="pet-card">
                            <h5><i class="fas fa-paw me-2"></i>{{ $pet->nama }}</h5>
                            <p class="mb-1"><strong>Ras:</strong> {{ $pet->nama_ras }}</p>
                            <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $pet->jenis_kelamin == 'L' ? 'Jantan' : 'Betina' }}</p>
                            <p class="mb-1"><strong>Tanggal Lahir:</strong> {{ date('d/m/Y', strtotime($pet->tanggal_lahir)) }}</p>
                            @if($pet->warna_tanda)
                            <p class="mb-0"><strong>Warna/Tanda:</strong> {{ $pet->warna_tanda }}</p>
                            @endif
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-paw"></i>
                            <p>Belum ada hewan peliharaan terdaftar</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column: Appointments & Medical Records -->
                <div class="col-lg-8">
                    <!-- Appointments Card -->
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h4><i class="fas fa-calendar-check me-2"></i>Jadwal Temu Dokter</h4>
                        </div>

                        @if(count($appointments) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No Urut</th>
                                        <th>Hewan</th>
                                        <th>Dokter</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                    <tr>
                                        <td><strong>#{{ $appointment->no_urut }}</strong></td>
                                        <td>{{ $appointment->nama_pet }}</td>
                                        <td>{{ $appointment->nama_dokter ?? 'Belum ditentukan' }}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($appointment->waktu_daftar)) }}</td>
                                        <td>
                                            @if($appointment->status == 'A')
                                            <span class="badge-status badge-active">Aktif</span>
                                            @else
                                            <span class="badge-status badge-cancelled">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <p>Belum ada jadwal temu dokter</p>
                            <small class="text-muted">Hubungi resepsionis untuk membuat jadwal</small>
                        </div>
                        @endif
                    </div>

                    <!-- Medical Records Card -->
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <h4><i class="fas fa-file-medical me-2"></i>Rekam Medis</h4>
                        </div>

                        @if(count($rekamMedis) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Hewan</th>
                                        <th>Dokter</th>
                                        <th>Diagnosis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekamMedis as $rekam)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($rekam->tanggal_periksa)) }}</td>
                                        <td>{{ $rekam->nama_pet }}</td>
                                        <td>{{ $rekam->nama_dokter ?? '-' }}</td>
                                        <td>{{ Str::limit($rekam->diagnosa, 50) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-custom" onclick="viewDetail({{ $rekam->idrekam_medis }})">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="empty-state">
                            <i class="fas fa-file-medical"></i>
                            <p>Belum ada rekam medis</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Profile -->
        <div class="modal fade" id="editProfileModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Profil</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('pemilik.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $pemilik->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $pemilik->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. WhatsApp</label>
                                <input type="text" name="no_wa" class="form-control" value="{{ $pemilik->no_wa }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ $pemilik->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail Rekam Medis -->
        <div class="modal fade" id="detailRekamMedisModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-file-medical me-2"></i>Detail Rekam Medis</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="detailContent">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function viewDetail(id) {
                const modal = new bootstrap.Modal(document.getElementById('detailRekamMedisModal'));
                modal.show();

                fetch(`/pemilik/rekam-medis/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const content = `
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Periksa</label>
                                    <p class="form-control-plaintext">${new Date(data.tanggal_periksa).toLocaleDateString('id-ID')}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Hewan</label>
                                    <p class="form-control-plaintext">${data.nama_pet}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Dokter</label>
                                    <p class="form-control-plaintext">${data.nama_dokter || '-'}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Berat Badan</label>
                                    <p class="form-control-plaintext">${data.berat_badan} kg</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Anamnesa</label>
                                    <p class="form-control-plaintext">${data.anamnesa || '-'}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Diagnosis</label>
                                    <p class="form-control-plaintext">${data.diagnosa || '-'}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Prognosis</label>
                                    <p class="form-control-plaintext">${data.prognosa || '-'}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Terapi</label>
                                    <p class="form-control-plaintext">${data.terapi || '-'}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Catatan</label>
                                    <p class="form-control-plaintext">${data.catatan || '-'}</p>
                                </div>
                            </div>
                        `;
                        document.getElementById('detailContent').innerHTML = content;
                    })
                    .catch(error => {
                        document.getElementById('detailContent').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>Gagal memuat data
                            </div>
                        `;
                    });
            }
        </script>
    </body>
</x-teemplate>