<x-teemplate title="RSHP DASHBOARD PERAWAT">
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user_name')) }}&size=80&background=0D6EFD&color=fff" 
                             class="rounded-circle mb-2" alt="Avatar">
                        <h6 class="mb-0">{{ session('user_name') }}</h6>
                        <small class="text-muted">{{ session('user_role_name') }}</small>
                    </div>
                    <hr>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="#" data-section="dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="#" data-section="patients">
                            <i class="bi bi-list-ul"></i> Data Pasien
                        </a>
                        <a class="nav-link" href="#" data-section="medical-records">
                            <i class="bi bi-file-medical"></i> Rekam Medis
                        </a>
                        <a class="nav-link" href="#" data-section="profile">
                            <i class="bi bi-person"></i> Profil Saya
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Dashboard Section -->
            <div id="dashboard-section" class="content-section">
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white shadow">
                            <div class="card-body">
                                <h6 class="card-title">Total Pasien</h6>
                                <h2 class="mb-0">{{ $pets->count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                <h6 class="card-title">Rekam Medis</h6>
                                <h2 class="mb-0">{{ $rekamMedis->count() ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">
                                <h6 class="card-title">Pasien Hari Ini</h6>
                                <h2 class="mb-0">{{ $pasienHariIni ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Selamat Datang, {{ session('user_name') }}!</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Gunakan menu di sebelah kiri untuk mengakses fitur-fitur dashboard.</p>
                    </div>
                </div>
            </div>

            <!-- Patients Section -->
            <div id="patients-section" class="content-section" style="display:none;">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Pasien (Hewan)</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" id="searchPatient" placeholder="Cari pasien...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Hewan</th>
                                        <th>Pemilik</th>
                                        <th>Ras</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pets as $index => $pet)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $pet->nama }}</strong></td>
                                            <td>{{ $pet->pemilik->user->nama ?? 'N/A' }}</td>
                                            <td>{{ $pet->ras->nama_ras ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->age }} tahun</td>
                                            <td>
                                                <a href="{{ route('perawat.patient.detail', $pet->id) }}" 
                                                   class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Tidak ada data pasien</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Records Section -->
            <div id="medical-records-section" class="content-section" style="display:none;">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Rekam Medis</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecordModal">
                            <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pasien</th>
                                        <th>Diagnosa</th>
                                        <th>Perawat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rekamMedis ?? [] as $index => $rm)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d/m/Y') }}</td>
                                            <td><strong>{{ $rm->pet->nama ?? 'N/A' }}</strong></td>
                                            <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                                            <td>{{ $rm->perawat->user->nama ?? session('user_name') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-info text-white" 
                                                            onclick="viewRecord({{ $rm->id }})">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-warning" 
                                                            onclick="editRecord({{ $rm->id }})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('perawat.rekam-medis.destroy', $rm->id) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada rekam medis</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profile-section" class="content-section" style="display:none;">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user_name')) }}&size=120&background=0D6EFD&color=fff" 
                                     class="rounded-circle mb-3" alt="Avatar">
                                <h5>{{ session('user_name') }}</h5>
                                <p class="text-muted mb-2">{{ session('user_role_name') }}</p>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-camera"></i> Ubah Foto
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Informasi Profil</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('perawat.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" 
                                               value="{{ $perawat->user->nama ?? session('user_name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="{{ $perawat->user->email ?? '' }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" name="no_telp" 
                                               value="{{ $perawat->user->no_telp ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="3">{{ $perawat->user->alamat ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. Lisensi</label>
                                        <input type="text" class="form-control" name="no_lisensi" 
                                               value="{{ $perawat->no_lisensi ?? '' }}" readonly>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Medical Record -->
<div class="modal fade" id="addRecordModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('perawat.rekam-medis.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Pasien <span class="text-danger">*</span></label>
                        <select class="form-select" name="pet_id" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->nama }} - {{ $pet->pemilik->user->nama ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Periksa <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_periksa" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keluhan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="keluhan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diagnosa <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="diagnosa" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tindakan</label>
                        <textarea class="form-control" name="tindakan" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Resep Obat</label>
                        <textarea class="form-control" name="resep_obat" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Medical Record -->
<div class="modal fade" id="viewRecordModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="recordDetailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<style>
.nav-link {
    color: #6c757d;
    padding: 0.75rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.3s;
}
.nav-link:hover {
    background-color: #f8f9fa;
    color: #0d6efd;
}
.nav-link.active {
    background-color: #0d6efd;
    color: white;
}
.nav-link i {
    margin-right: 0.5rem;
}
.card {
    border: none;
    border-radius: 0.5rem;
}
.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navigation
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.content-section');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Hide all sections
            sections.forEach(s => s.style.display = 'none');
            
            // Show selected section
            const sectionId = this.dataset.section + '-section';
            document.getElementById(sectionId).style.display = 'block';
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchPatient');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#patients-section tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});

// View record detail
function viewRecord(id) {
    fetch(`/perawat/rekam-medis/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('recordDetailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Tanggal Periksa:</strong><br>
                        ${data.tanggal_periksa}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Pasien:</strong><br>
                        ${data.pet_name}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Keluhan:</strong><br>
                        ${data.keluhan || '-'}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Diagnosa:</strong><br>
                        ${data.diagnosa || '-'}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Tindakan:</strong><br>
                        ${data.tindakan || '-'}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Resep Obat:</strong><br>
                        ${data.resep_obat || '-'}
                    </div>
                    <div class="col-12">
                        <strong>Catatan:</strong><br>
                        ${data.catatan || '-'}
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('viewRecordModal')).show();
        });
}

// Edit record
function editRecord(id) {
    window.location.href = `/perawat/rekam-medis/${id}/edit`;
}
</script>
</x-teemplate>