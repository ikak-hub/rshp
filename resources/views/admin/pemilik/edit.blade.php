<x-teemplate title="Edit Pemilik - RSHP UNAIR">
<div class="mt-20">
    <div class="container mx-auto max-w-2xl">
        <h1 class="text-center font-bold text-3xl mb-10">Edit Pemilik</h1>
        
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
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

            <form action="{{ route('admin.pemilik.update', ['id' => $pemilik->idpemilik]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                        Nama Pemilik <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama"
                           name="nama"
                           value="{{ old('nama', $pemilik->nama_pemilik) }}"   
                           placeholder="Masukkan nama pemilik"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @error('nama') border-red-500 @enderror"
                           required>
                    @error('nama')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email"
                           name="email"
                           value="{{ old('email', $pemilik->email) }}"   
                           placeholder="Masukkan email"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                    
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no_wa">
                        No WA <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="no_wa"
                           name="no_wa"
                           value="{{ old('no_wa', $pemilik->no_wa) }}"
                           placeholder="Masukkan no wa"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @error('no_wa') border-red-500 @enderror"
                           required>        
                    @error('no_wa')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="alamat"
                        name="alamat"
                        rows="3"
                        placeholder="Masukkan alamat lengkap"
                        class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @error('alamat') border-red-500 @enderror"
                        required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                   
                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('admin.pemilik.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>

        </div>

        <!-- Warning Box -->
        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
            <p class="font-bold">Peringatan:</p>
            <p class="text-sm">Perubahan data pemilik akan berpengaruh pada data hewan peliharaan yang terkait.</p>
        </div>
    </div>
</div>
</x-teemplate>