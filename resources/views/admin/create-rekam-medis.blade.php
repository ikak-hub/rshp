<x-teemplate title="Buat Rekam Medis - RSHP UNAIR">
<style>
    body {
        background: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .form-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
    }
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 1rem 1rem 0 0 !important;
    }
    .btn-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
        color: white;
    }
</style>

<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-clipboard-plus me-2"></i>Buat Rekam Medis Baru</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('dokter.rekam-medis.store') }}" method="POST">
                @csrf
                
                @if($appointment)
                    <!-- From Appointment -->
                    <input type="hidden" name="idreservasi_dokter" value="{{ $appointment->idreservasi_dokter }}">
                    <input type="hidden" name="idpet" value="{{ $appointment->idpet }}">
                    
                    <div class="alert alert-info mb-4">
                        <h6 class="mb-2"><i class="bi bi-info-circle me-2"></i>Informasi Pasien</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama Hewan:</strong> {{ $appointment->nama_pet }}<br>
                                <strong>Ras:</strong> {{ $appointment->nama_ras }}
                            </div>
                            <div class="col-md-6">
                                <strong>Pemilik:</strong> {{ $appointment->nama_pemilik }}<br>
                                <strong>No. Urut:</strong> {{ $appointment->no_urut }}
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Direct Entry (without appointment) -->
                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-heart-pulse me-1"></i>Pilih Pasien <span class="text-danger">*</span></label>
                        <select name="idpet" id="idpet" class="form-select @error('idpet') is-invalid @enderror" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->idpet }}" 
                                        {{ (old('idpet', request('idpet')) == $pet->idpet) ? 'selected' : '' }}
                                        data-pemilik="{{ $pet->nama_pemilik }}"
                                        data-ras="{{ $pet->nama_ras }}">
                                    {{ $pet->nama }} - {{ $pet->nama_pemilik }} ({{ $pet->nama_ras }})
                                </option>
                            @endforeach
                        </select>
                        @error('idpet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih pasien yang akan diperiksa</small>
                    </div>

                    <div id="petInfoAlert" class="alert alert-info d-none mb-4">
                        <h6 class="mb-2"><i class="bi bi-info-circle me-2"></i>Informasi Pasien</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama Hewan:</strong> <span id="petName">-</span><br>
                                <strong>Ras:</strong> <span id="petRas">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Pemilik:</strong> <span id="petOwner">-</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-chat-dots me-1"></i>Anamnesa <span class="text-danger">*</span></label>
                    <textarea name="anamnesa" 
                              class="form-control @error('anamnesa') is-invalid @enderror" 
                              rows="4" 
                              placeholder="Keluhan dan riwayat penyakit pasien..."
                              required>{{ old('anamnesa') }}</textarea>
                    @error('anamnesa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Contoh: Hewan mengalami demam sejak 2 hari yang lalu, nafsu makan menurun</small>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-clipboard-check me-1"></i>Temuan Klinis</label>
                    <textarea name="temuan_klinis" 
                              class="form-control @error('temuan_klinis') is-invalid @enderror" 
                              rows="4" 
                              placeholder="Hasil pemeriksaan fisik dan klinis...">{{ old('temuan_klinis') }}</textarea>
                    @error('temuan_klinis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Contoh: Suhu tubuh 39.5°C, mukosa pucat, detak jantung 120x/menit</small>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-clipboard2-pulse me-1"></i>Diagnosis <span class="text-danger">*</span></label>
                    <textarea name="diagnosa" 
                              class="form-control @error('diagnosa') is-invalid @enderror" 
                              rows="3" 
                              placeholder="Diagnosis penyakit atau kondisi pasien..."
                              required>{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Contoh: Suspect viral infection, gastroenteritis akut</small>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-custom">
                        <i class="bi bi-save me-1"></i> Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-warning mt-3">
        <i class="bi bi-lightbulb me-2"></i>
        <strong>Tips:</strong> Setelah menyimpan rekam medis, Anda dapat menambahkan detail tindakan/terapi yang dilakukan.
    </div>
</div>

<script>
    // Show pet info when selected (for direct entry)
    document.getElementById('idpet')?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (this.value) {
            document.getElementById('petName').textContent = selected.text.split(' - ')[0];
            document.getElementById('petRas').textContent = selected.getAttribute('data-ras');
            document.getElementById('petOwner').textContent = selected.getAttribute('data-pemilik');
            document.getElementById('petInfoAlert').classList.remove('d-none');
        } else {
            document.getElementById('petInfoAlert').classList.add('d-none');
        }
    });

    // Trigger change event if there's a pre-selected pet
    @if(request('idpet'))
        document.getElementById('idpet')?.dispatchEvent(new Event('change'));
    @endif
</script>
</x-teemplate>