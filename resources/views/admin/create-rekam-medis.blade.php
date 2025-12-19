<x-template title="RSHP - Rekam Medis">
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
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
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
        .detail-card {
            transition: all 0.3s;
            border-left: 4px solid #667eea;
        }
        .detail-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .badge-tindakan {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 0.35rem 0.8rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
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
                <a href="{{ route('dokter.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('dokter.dashboard') }}" class="nav-link">
                    <i class="bi bi-calendar-check"></i> Jadwal Temu
                </a>
                <a href="{{ route('dokter.dashboard') }}" class="nav-link">
                    <i class="bi bi-heart-pulse"></i> Data Pasien
                </a>
                <a href="{{ route('dokter.rekam-medis.index') }}" class="nav-link active">
                    <i class="bi bi-file-medical"></i> Rekam Medis
                </a>
                <a href="{{ route('dokter.dashboard') }}" class="nav-link">
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-file-medical me-2"></i>Rekam Medis Pasien</h2>
            <input type="text" class="form-control w-auto" id="searchRM" placeholder="Cari rekam medis...">
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
                                <th>Jumlah Tindakan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rmTableBody">
                            @forelse($rekamMedis as $index => $rm)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($rm->created_at)) }}</td>
                                <td><strong>{{ $rm->nama_pet }}</strong></td>
                                <td>{{ Str::limit($rm->diagnosa ?? '-', 50) }}</td>
                                <td>
                                    <span class="badge badge-tindakan">
                                        <i class="bi bi-clipboard-check me-1"></i>{{ $rm->jumlah_tindakan }} Tindakan
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-custom" onclick="viewRecordDetail({{ $rm->idrekam_medis }})">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">Belum ada rekam medis</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Record Detail -->
    <div class="modal fade" id="recordDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-medical-fill me-2"></i>Detail Rekam Medis & Tindakan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Rekam Medis Info -->
                    <div id="recordContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary"></div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Detail Tindakan -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">
                            <i class="bi bi-clipboard-pulse me-2"></i>Detail Tindakan & Terapi
                        </h6>
                        <button class="btn btn-sm btn-custom" onclick="addDetailFromModal()">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Tindakan
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
                        <div class="text-center py-4">
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <script>
        let currentRekamMedisId = null;

        // Search rekam medis
        document.getElementById('searchRM')?.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#rmTableBody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // View record detail
        function viewRecordDetail(id) {
            currentRekamMedisId = id;
            const modal = new bootstrap.Modal(document.getElementById('recordDetailModal'));
            modal.show();
            
            fetch(`/dokter/rekam-medis/${id}`)
                .then(response => response.json())
                .then(data => {
                    const rm = data.rekam_medis;
                    document.getElementById('recordContent').innerHTML = `
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="bi bi-calendar3 me-2"></i>Tanggal Periksa:</strong><br>
                                        ${new Date(rm.created_at).toLocaleString('id-ID')}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="bi bi-heart-pulse-fill me-2"></i>Pasien:</strong><br>
                                        ${rm.nama_pet}
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="bi bi-person-badge me-2"></i>Dokter:</strong><br>
                                        ${rm.nama_dokter || '-'}
                                    </div>
                                    <div class="col-12 mb-3">
                                        <strong><i class="bi bi-chat-left-text me-2"></i>Anamnesa:</strong><br>
                                        <p class="mb-0 mt-2">${escapeHtml(rm.anamnesa || '-')}</p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <strong><i class="bi bi-clipboard-data me-2"></i>Temuan Klinis:</strong><br>
                                        <p class="mb-0 mt-2">${escapeHtml(rm.temuan_klinis || '-')}</p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <strong><i class="bi bi-clipboard-check me-2"></i>Diagnosis:</strong><br>
                                        <p class="mb-0 mt-2">${escapeHtml(rm.diagnosa || '-')}</p>
                                    </div>
                                </div>
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
                details.forEach((detail, index) => {
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
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada detail tindakan/terapi</p>
                        <button class="btn btn-custom mt-2" onclick="addDetailFromModal()">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Tindakan
                        </button>
                    </div>
                `;
            }
        }

        // Add detail
        function addDetailFromModal() {
            if (!currentRekamMedisId) {
                alert('ID Rekam Medis tidak ditemukan');
                return;
            }
            
            bootstrap.Modal.getInstance(document.getElementById('recordDetailModal')).hide();
            
            document.getElementById('idrekam_medis').value = currentRekamMedisId;
            document.getElementById('addDetailForm').reset();
            document.getElementById('idrekam_medis').value = currentRekamMedisId;
            $('#kodeTindakan').val('').trigger('change');
            $('#tindakanInfo').addClass('d-none');
            
            loadKodeTindakan();
            new bootstrap.Modal(document.getElementById('addDetailModal')).show();
        }

        // Load kode tindakan
        function loadKodeTindakan() {
            fetch('/dokter/kode-tindakan')
                .then(response => response.json())
                .then(data => {
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

                    select.select2({
                        dropdownParent: $('#addDetailModal'),
                        width: '100%',
                        placeholder: 'Cari kode tindakan...'
                    });
                });
        }

        // Show tindakan info
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

        // Edit detail
        function editDetail(id) {
            const editModal = new bootstrap.Modal(document.getElementById('editDetailModal'));
            editModal.show();
            
            fetch(`/dokter/detail-rekam-medis/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editDetailForm').action = `/dokter/detail-rekam-medis/${id}`;
                    
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

        // Auto open rekam medis after action
        @if(session('open_rekam_medis'))
            setTimeout(() => {
                viewRecordDetail({{ session('open_rekam_medis') }});
            }, 500);
        @endif

        // Save last viewed
        document.getElementById('addDetailForm')?.addEventListener('submit', function() {
            if (currentRekamMedisId) {
                localStorage.setItem('lastViewedRekamMedis', currentRekamMedisId);
            }
        });

        window.addEventListener('load', function() {
            const lastViewed = localStorage.getItem('lastViewedRekamMedis');
            if (lastViewed && {{ session()->has('success') ? 'true' : 'false' }}) {
                setTimeout(() => {
                    viewRecordDetail(lastViewed);
                    localStorage.removeItem('lastViewedRekamMedis');
                }, 500);
            }
        });
    </script>
</x-template>