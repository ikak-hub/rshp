<x-teemplate title="Tambah Kode Tindakan - RSHP UNAIR">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">  
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Kode Tindakan Terapi</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi Kesalahan!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>  
                    @endif      

                    <form action="{{ route('admin.kodetindakanterapi.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="idkategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="idkategori" id="idkategori" class="form-select @error('idkategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategories as $kategori)
                                    <option value="{{ $kategori->idkategori }}" {{ old('idkategori') == $kategori->idkategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idkategori_klinis" class="form-label">Kategori Klinis <span class="text-danger">*</span></label>
                            <select name="idkategori_klinis" id="idkategori_klinis" class="form-select @error('idkategori_klinis') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori Klinis --</option>
                                @foreach ($kategoriKlinises as $kategoriklinis)
                                    <option value="{{ $kategoriklinis->idkategori_klinis }}" {{ old('idkategori_klinis') == $kategoriklinis->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $kategoriklinis->nama_kategori_klinis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Tindakan <span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('kode') is-invalid @enderror"
                                id="kode"
                                name="kode"
                                value="{{ old('kode') }}"
                                placeholder="Masukkan kode tindakan (contoh: T001)"
                                required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi_tindakan_terapi" class="form-label">Deskripsi Tindakan <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror"
                                id="deskripsi_tindakan_terapi"
                                name="deskripsi_tindakan_terapi"
                                rows="4"
                                placeholder="Masukkan deskripsi tindakan terapi"
                                required>{{ old('deskripsi_tindakan_terapi') }}</textarea>
                            @error('deskripsi_tindakan_terapi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.kodetindakanterapi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-3" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Catatan:</strong> Semua field yang ditandai dengan (<span class="text-danger">*</span>) wajib diisi.
            </div>
        </div>
    </div>
</div>
</x-teemplate>