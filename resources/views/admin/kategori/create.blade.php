<x-teemplate title="Tambah Kategori - RSHP UNAIR">
<div class="mt-20">
    <div class="page container">
        <div class="row justify-content-center">
                <h1 class="page-title-centered">Tambah Kategori</h1>
        </div>
            <div class="card">
                <div class="card-header">
                    <h4>Selamat Datang</h4>
                </div>

                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif 

                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('nama_kategori') is-invalid @enderror" 
                                id="nama_kategori" 
                                name="nama_kategori" 
                                value="{{ old('nama_kategori') }}"
                                placeholder="Masukkan nama kategori"
                                required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                                <i classs="fas fa-arrow-left"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-teemplate>