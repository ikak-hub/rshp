<x-teemplate title="RSHP DASHBOARD PERAWAT">
<style>
body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            top: 82px;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
        }
        .main-content {
            margin-left: 250px;
            margin-top: 82px;
            padding: 2rem;
            min-height: 100vh;
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
        }
        .stat-card.primary { border-left-color: #3b82f6; }
        .stat-card.success { border-left-color: #10b981; }
        .stat-card.info { border-left-color: #06b6d4; }
        .btn-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
            color: white;
        }
        .modal-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .table thead {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .content-section { display: none; }
        .content-section.active { display: block; }
    @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
                top: 0;
            }
            .main-content {
                margin-left: 0;
                margin-top: 82px;
            }
            .header-top {
                position: relative;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="p-4">
            <div class="text-center mb-4">
                @php
                    $userName = $perawat->user->nama ?? auth()->user()->nama ?? 'Perawat';
                @endphp
                <img src="https://ui-avatars.com/api/?name={{ urlencode($userName) }}&size=100&background=fff&color=10b981" 
                     class="rounded-circle mb-3" alt="Avatar">
                <h5 class="mb-0">{{ $userName }}</h5>
                <small class="text-white-50">Perawat</small>
            </div>
            <hr class="bg-white opacity-25">
            <nav class="nav flex-column">
                <a class="nav-link active" data-section="dashboard">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="nav-link" data-section="patients">
                    <i class="bi bi-heart-pulse"></i> Data Pasien
                </a>
                <a class="nav-link" data-section="medical-records">
                    <i class="bi bi-file-medical"></i> Rekam Medis
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

    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Dashboard Section -->
        <div id="dashboard-section" class="content-section active">
            <h2 class="mb-4">Dashboard</h2>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="card stat-card success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Rekam Medis</p>
                                    <h3 class="mb-0">{{ $rekamMedis->count() }}</h3>
                                </div>
                                <i class="bi bi-file-medical fs-1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Pasien Hari Ini</p>
                                    <h3 class="mb-0">{{ $pasienHariIni }}</h3>
                                </div>
                                <i class="bi bi-calendar-check fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, {{ $userName }}!</h5>
                    <p class="card-text">Gunakan menu di sebelah kiri untuk mengakses fitur-fitur yang tersedia.</p>
                </div>
            </div>
        </div>

        <!-- Patients Section -->
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
                                    <td>{{ $pet->pemilik->user->nama ?? 'N/A' }}</td>
                                    <td>{{ $pet->ras->nama_ras ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}</td>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Rekam Medis</h2>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addRecordModal">
                    <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
                </button>
            </div>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $index => $rm)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rm->tanggal_periksa ? \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d/m/Y') : \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</td>
                                    <td><strong>{{ $rm->pet->nama ?? 'N/A' }}</strong></td>
                                    <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-info text-white" onclick="viewRecord({{ $rm->idrekam_medis }})">
                                                <i class="bi bi-eye">Detail Rekam medis</i>
                                            </button>
                                            <button class="btn btn-warning" onclick="editRecord({{ $rm->idrekam_medis }})">
                                                <i class="bi bi-pencil">Update</i>
                                            </button>
                                            <form action="{{ route('perawat.rekam-medis.destroy', $rm->idrekam_medis) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash">Delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada rekam medis</td>
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
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($userName) }}&size=150&background=10b981&color=fff" 
                                 class="rounded-circle mb-3" alt="Avatar">
                            <h5>{{ $userName }}</h5>
                            <p class="text-muted">Perawat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Profil</h5>
                            <form action="{{ route('perawat.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" 
                                           value="{{ $perawat->user->nama ?? auth()->user()->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ $perawat->user->email ?? auth()->user()->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. HP</label>
                                    <input type="text" class="form-control" name="no_hp" 
                                           value="{{ $perawat->no_hp ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3">{{ $perawat->alamat ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin">
                                            <option value="">Pilih</option>
                                            <option value="L" {{ ($perawat->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ ($perawat->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pendidikan</label>
                                        <input type="text" class="form-control" name="pendidikan" 
                                               value="{{ $perawat->pendidikan ?? '' }}" placeholder="Contoh: D3 Keperawatan">
                                    </div>
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

    <!-- Modal Add Record -->
    <div class="modal fade" id="addRecordModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rekam Medis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('perawat.rekam-medis.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Pasien <span class="text-danger">*</span></label>
                            <select class="form-select" name="idpet" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pets as $pet)
                                <option value="{{ $pet->idpet }}">{{ $pet->nama }} - {{ $pet->pemilik->user->nama ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" class="form-control" name="berat_badan">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Anamnesa <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="anamnesa" rows="2" placeholder="Keluhan dan riwayat penyakit" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Temuan Klinis</label>
                            <textarea class="form-control" name="temuan_klinis" rows="2" placeholder="Hasil pemeriksaan fisik"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diagnosis <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="diagnosa" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prognosa</label>
                            <textarea class="form-control" name="prognosa" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Terapi</label>
                            <textarea class="form-control" name="terapi" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="2"></textarea>
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

    <!-- Modal View Patient -->
    <div class="modal fade" id="patientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pasien</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="patientContent"></div>
            </div>
        </div>
    </div>

    <!-- Modal View Record -->
    <div class="modal fade" id="recordModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Rekam Medis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="recordContent"></div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Record -->
    <div class="modal fade" id="editRecordModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Rekam Medis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editRecordForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editRecordContent"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.nav-link[data-section]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
                document.getElementById(this.dataset.section + '-section').classList.add('active');
            });
        });

        document.getElementById('searchPatient')?.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#patientTableBody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        function viewPatient(id) {
            fetch(`/perawat/patient/${id}`)
                .then(response => response.json())
                .then(data => {
                    const pet = data.pet;
                    document.getElementById('patientContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-6 mb-3"><strong>Nama Hewan:</strong><br>${pet.nama}</div>
                            <div class="col-md-6 mb-3"><strong>Ras:</strong><br>${pet.nama_ras}</div>
                            <div class="col-md-6 mb-3"><strong>Tanggal Lahir:</strong><br>${new Date(pet.tanggal_lahir).toLocaleDateString('id-ID')}</div>
                            <div class="col-md-6 mb-3"><strong>Jenis Kelamin:</strong><br>${pet.jenis_kelamin == 'L' ? 'Jantan' : 'Betina'}</div>
                            <div class="col-12 mb-3"><strong>Pemilik:</strong><br>${pet.nama_pemilik}</div>
                            <div class="col-md-6 mb-3"><strong>Email:</strong><br>${pet.email}</div>
                            <div class="col-md-6 mb-3"><strong>No. WA:</strong><br>${pet.no_wa}</div>
                            <div class="col-12"><strong>Alamat:</strong><br>${pet.alamat}</div>
                        </div>
                    `;
                    new bootstrap.Modal(document.getElementById('patientModal')).show();
                });
        }

        function viewRecord(id) {
            fetch(`/perawat/rekam-medis/${id}`)
                .then(response => response.json())
                .then(data => {
                    let detailsHtml = '';
                    if (data.detail_tindakan && data.detail_tindakan.length > 0) {
                        detailsHtml = '<div class="col-12 mb-3"><strong>Detail Tindakan:</strong><br><ul>';
                        data.detail_tindakan.forEach(d => {
                            detailsHtml += `<li>${d.tindakan} (${d.kategori}) - ${d.detail || '-'}</li>`;
                        });
                        detailsHtml += '</ul></div>';
                    }
                    
                    document.getElementById('recordContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-6 mb-3"><strong>Tanggal:</strong><br>${data.tanggal_periksa}</div>
                            <div class="col-md-6 mb-3"><strong>Pasien:</strong><br>${data.nama_pet}</div>
                            <div class="col-md-6 mb-3"><strong>Berat Badan:</strong><br>${data.berat_badan} kg</div>
                            <div class="col-md-6 mb-3"><strong>Dokter:</strong><br>${data.dokter}</div>
                            <div class="col-12 mb-3"><strong>Anamnesa:</strong><br>${data.anamnesa}</div>
                            <div class="col-12 mb-3"><strong>Temuan Klinis:</strong><br>${data.temuan_klinis}</div>
                            <div class="col-12 mb-3"><strong>Diagnosis:</strong><br>${data.diagnosa}</div>
                            <div class="col-12 mb-3"><strong>Prognosis:</strong><br>${data.prognosa}</div>
                            <div class="col-12 mb-3"><strong>Terapi:</strong><br>${data.terapi}</div>
                            ${detailsHtml}
                            <div class="col-12"><strong>Catatan:</strong><br>${data.catatan}</div>
                        </div>
                    `;
                    new bootstrap.Modal(document.getElementById('recordModal')).show();
                });
        }

        function editRecord(id) {
            fetch(`/perawat/rekam-medis/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editRecordForm').action = `/perawat/rekam-medis/${id}`;
                    document.getElementById('editRecordContent').innerHTML = `
                        <div class="mb-3">
                            <label class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" class="form-control" name="berat_badan" value="${data.berat_badan || ''}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Anamnesa</label>
                            <textarea class="form-control" name="anamnesa" rows="2" required>${data.anamnesa || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Temuan Klinis</label>
                            <textarea class="form-control" name="temuan_klinis" rows="2">${data.temuan_klinis || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diagnosis</label>
                            <textarea class="form-control" name="diagnosa" rows="2" required>${data.diagnosa || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prognosis</label>
                            <textarea class="form-control" name="prognosa" rows="2">${data.prognosa || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Terapi</label>
                            <textarea class="form-control" name="terapi" rows="2">${data.terapi || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="2">${data.catatan || ''}</textarea>
                        </div>
                    `;
                    new bootstrap.Modal(document.getElementById('editRecordModal')).show();
                });
        }
    </script>
</body>
</x-teemplate>