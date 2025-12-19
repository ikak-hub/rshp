<x-teemplate title="Tambah Ras Hewan - RSHP UNAIR">
<div class="mt-20">
<div class="page container">
    <div class="row justify-content-center">
        <!-- <div class="col-md-8"> -->
            <div class="page-header-centered">
                <h1>Tambah Ras Hewan</h1>
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

                    <form action="{{ route('admin.pet.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Hewan<span class="text-danger">*</span></label>  
                            <input type="text" 
                                class="form-control @error('nama') is-invalid @enderror"
                                id="nama"
                                name="nama"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama hewan"
                                required>
                            @error('nama_ras_hewan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
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

                         