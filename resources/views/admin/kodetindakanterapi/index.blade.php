<x-teemplate title="Manajemen Kode Tindakan Terapi - RSHP UNAIR">

    <div class="page-container">
        <div class="page-header">
            <h1>Manajemen Data Kode Tindakan Terapi</h1>
        </div>

        @if ($errors->any())
            <div class="position-fixed start-50 translate-middle-x mt-3 z-3" id="pop-message-err" style="top: 50px">
                <div class="alert alert-danger shadow">
                    @foreach ($errors->all() as $message)
                        <strong>{{ $message }}</strong> <br>
                    @endforeach
                </div>
            </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        <div class="mb-3">
            <!-- Tombol untuk tambah kategori klinis baru -->
            <form action="{{ route('admin.kodetindakanterapi.create') }}" method="GET" style="display: inline;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Kode Tindakan Baru
                </button>
            </form>
        </div>

        {{ $kodeTindakanTerapi->links() }}
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700 uppercase text-sm tracking-wider">
                    <th class="py-3 px-4 border-b">NO</th>
                    <th class="py-3 px-4 border-b">Kode Tindakan</th>
                    <th class="py-3 px-4 border-b">Kategori</th>
                    <th class="py-3 px-4 border-b">Kategori Klinis</th>
                    <th class="py-3 px-4 border-b">Deskripsi Tindakan</th>
                    <th class="py-3 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kodeTindakanTerapi as $index => $item)
                <tr class="hover:bg-gray-50">
                    <!-- pastikan nama yang dipanggil harus sama dengan yang ada di database, jadi jika di database namanya kodeTindakanTerapi maka di panggil juga kodeTindakanTerapi -->
                    <td class="py-2 px-4 border-b">{{ $item->idkode_tindakan_terapi }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->kode }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->nama_kategori }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->nama_kategori_klinis }}</td>
                    <td class="py-2 px-4 border-b">{{ $item->deskripsi_tindakan_terapi }}</td>
                    <td class="py-2 px-4 border-b">
                        <div class="flex items-center gap-2">
                            <button 
                                type="button"
                                class="btn btn-sm btn-warning"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEdit"
                                data-idkode_tindakan="{{ $item->idkode_tindakan_terapi }}"
                                id="edit-btn"
                            >
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <button type="button"
                                class="btn btn-sm btn-danger"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus kode tindakan ini?')) { document.getElementById('delete-form-{{ $item->idkode_tindakan_terapi }}').submit(); }">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>

                        <form id="delete-form-{{ $item->idkode_tindakan_terapi }}"
                            action="#"
                            method="POST"
                            class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Kategori Klinis</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-edit">
        @csrf
        @method('PATCH')
        <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Kategori <span class="mdi mdi-pencil"></span></label>
                    <select name="idkategori" id="select_kategori" class="form-select text-black" required>
                        @if ($kategories)
                        @foreach ($kategories as $kategori)
                            <option class="text-black kategori-options" data-idkategori="{{ $kategori->idkategori }}" value="{{ $kategori->idkategori }}">{{$kategori->nama_kategori}}</option>
                        @endforeach                        
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori Klinis <span class="mdi mdi-pencil"></span></label>
                    <select name="idkategori_klinis" id="select_kategori_klinis" class="form-select text-black" required>
                        @if ($kategoriKlinises)
                        @foreach ($kategoriKlinises as $kategoriklinis)
                            <option class="text-black kategori-klinis-options" data-idkategori_klinis="{{ $kategoriklinis->idkategori_klinis }}" value="{{ $kategoriklinis->idkategori_klinis }}">{{$kategoriklinis->nama_kategori_klinis}}</option>
                        @endforeach                        
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Tindakan</label>
                    <input 
                        type="text"
                        name="deskripsi" 
                        class="form-control"
                        id="input_deskripsi" 
                        value=""
                        required
                    >
                </div>

                <input type="hidden" name="kode" id="kodeInput">
                <input type="hidden" name="page" value="{{ request()->get('page') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalEdit = document.getElementById('modalEdit')
        const fetchKodeTindakanModalEdit = async (element) => {
            const id = element.currentTarget.dataset.idkode_tindakan
            const formEdit = document.getElementById('form-edit')
            formEdit.action = `/admin/kode-tindakan-terapi/${id}`

            const kategoriInputOptions = document.querySelectorAll('.kategori-options')
            const kategoriKlinisOptions = document.querySelectorAll('.kategori-klinis-options')
            
            const deskripsiInput = document.getElementById('input_deskripsi')
            deskripsiInput.value = `Loading . . .`
            const kodeInput = document.getElementById('kodeInput')

            try {
                const fetchKodeTindakan = await fetch(`/admin/kode-tindakan-terapi/${id}`)
                const fetchedKodeTindakan = await fetchKodeTindakan.json()
                console.log(fetchedKodeTindakan)
                deskripsiInput.value = fetchedKodeTindakan.deskripsi_tindakan_terapi
                kodeInput.value = fetchedKodeTindakan.kode
                kategoriInputOptions.forEach(opt=>{
                    const idkategori = opt.dataset.idkategori
                    if (idkategori == fetchedKodeTindakan.idkategori) {
                        opt.selected = true
                    }
                })
                kategoriKlinisOptions.forEach(opt=>{
                    const idkategori_klinis = opt.dataset.idkategori_klinis
                    if (idkategori_klinis == fetchedKodeTindakan.idkategori_klinis) {
                        opt.selected = true
                    }
                })
            } catch (error) {
                console.log(error)
            }
        }

        const editBtn = document.querySelectorAll("#edit-btn")
        editBtn.forEach(btn => {
            btn.addEventListener('click', (e) => fetchKodeTindakanModalEdit(e))
        })

    </script>

    <style>
        .page-container { max-width: 800px; margin: 30px auto; padding: 20px; }
        .page-header { text-align: center; margin-bottom: 20px; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .data-table th, .data-table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .data-table th { background-color: #6588e8; color: white; }
        .action-link { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .form-container { background-color: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-submit { background-color: #2ecc71; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
    </style>

</x-teemplate>