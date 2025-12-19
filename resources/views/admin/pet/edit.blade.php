<x-teemplate title="Edit Data Hewan - RSHP UNAIR">
    <style>
        .page-container {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }

        .page-header h1 {
            color: #333;
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .form-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 500;
        }

        .text-danger {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .radio-group {
            display: flex;
            gap: 1.5rem;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .radio-label input[type="radio"] {
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
        }

        .info-box {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            margin: 0;
            color: #1e40af;
        }
    </style>

    <div class="page-container">
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Terjadi kesalahan!</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="page-header">
            <h1><i class="fas fa-edit"></i> Edit Data Hewan</h1>
        </div>

        <div class="form-container">
            <div class="info-box">
                <p><i class="fas fa-info-circle"></i> Mengubah data hewan: <strong>{{ $pet->nama }}</strong></p>
            </div>

            <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="form-label">
                        Nama Hewan <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                        class="form-control @error('nama') is-invalid @enderror"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $pet->nama) }}"
                        placeholder="Masukkan nama hewan"
                        required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_lahir" class="form-label">
                        Tanggal Lahir <span class="text-danger">*</span>
                    </label>
                    <input type="date" 
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}"
                        max="{{ date('Y-m-d') }}"
                        required>
                    @error('tanggal_lahir')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="warna_tanda" class="form-label">
                        Warna/Tanda Khusus
                    </label>
                    <input type="text" 
                        class="form-control @error('warna_tanda') is-invalid @enderror"
                        id="warna_tanda"
                        name="warna_tanda"
                        value="{{ old('warna_tanda', $pet->warna_tanda) }}"
                        placeholder="Contoh: Putih dengan bintik hitam di dahi">
                    @error('warna_tanda')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Jenis Kelamin <span class="text-danger">*</span>
                    </label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" 
                                name="jenis_kelamin" 
                                value="L" 
                                {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                required>
                            <span><i class="fas fa-mars"></i> Jantan</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" 
                                name="jenis_kelamin" 
                                value="P" 
                                {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                required>
                            <span><i class="fas fa-venus"></i> Betina</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="idras_hewan" class="form-label">
                        Ras Hewan <span class="text-danger">*</span>
                    </label>
                    <select class="form-control @error('idras_hewan') is-invalid @enderror"
                        id="idras_hewan"
                        name="idras_hewan"
                        required>
                        <option value="">Pilih Ras Hewan</option>
                        @foreach($rasHewan as $ras)
                            <option value="{{ $ras->idras_hewan }}" 
                                {{ old('idras_hewan', $pet->idras_hewan) == $ras->idras_hewan ? 'selected' : '' }}>
                                {{ $ras->nama_ras }}
                            </option>
                        @endforeach
                    </select>
                    @error('idras_hewan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="idpemilik" class="form-label">
                        Pemilik <span class="text-danger">*</span>
                    </label>
                    <select class="form-control @error('idpemilik') is-invalid @enderror"
                        id="idpemilik"
                        name="idpemilik"
                        required>
                        <option value="">Pilih Pemilik</option>
                        @foreach($pemilik as $p)
                            <option value="{{ $p->idpemilik }}" 
                                {{ old('idpemilik', $pet->idpemilik) == $p->idpemilik ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('idpemilik')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="button-group">
                    <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-teemplate>