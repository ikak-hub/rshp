<x-teemplate title="Tambah Pemilik Baru - RSHP UNAIR">
<div class="mt-20">
    <div class="container mx-auto max-w-2xl">
    <h1 class="text-center font-bold text-3xl mb-10">Tambah Pemilik Baru</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">  
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Pemilik</h4>
                </div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>  
                    @endif

                    <form action="{{ route('admin.pemilik.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pemilik<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('nama') is-invalid @enderror"
                                id="nama"
                                name="nama"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama pemilik"
                                required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" 
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div>
                            @enderror
                            <label for="no_wa" class="form-label">No WA<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('no_wa') is-invalid @enderror"
                                id="no_wa"
                                name="no_wa"
                                value="{{ old('no_wa') }}"
                                placeholder="Masukkan no wa"
                                required>
                            @error('no_wa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        <label for="alamat" class="form-label">Alamat<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat"
                                name="alamat"
                                value="{{ old('alamat') }}"
                                placeholder="Masukkan alamat"
                                required>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>Kembali
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