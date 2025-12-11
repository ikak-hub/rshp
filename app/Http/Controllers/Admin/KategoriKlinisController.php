<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\KategoriKlinis;

class KategoriKlinisController extends Controller
{
    public function patch(Request $request, $id) {
        //? validasi input
        $validatedData = $this->validateKategoriKlinis($request, $id);

        try {
            // Eloquent
            // $rasHewan = RasHewan::findOrFail($id);
            // $rasHewan->nama_ras = $this->formatNamaRasHewan($validatedData['nama_ras']);
            // $rasHewan->idjenis_hewan = $validatedData['idjenis_hewan'];
            // $rasHewan->save();

            // Query Builder
            DB::table('kategori_klinis')
                ->where('idkategori_klinis', $id) 
                ->update([
                    'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($validatedData['nama_kategori_klinis'])
                ]);

            return redirect()->route('admin.kategoriklinis.index')
                            ->with('success', 'Kategori klinis berhasil diperbarui.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('admin.kategoriklinis.edit', $id)
                            ->with('error', 'Gagal memperbarui Kategori Klinis: ' . $e->getMessage())
                            ->withInput();
        }
    }
    public function edit(Request $request, $id) {
        $kategoriKlinis = DB::table('kategori_klinis')->select('*')->where('idkategori_klinis', $id)->first();
        return view('admin.kategori-klinis.edit', ['kategoriKlinis' => $kategoriKlinis]);
    }

    public function index()
    {
        // Eloquent
        // $dataKategoriKlinis = KategoriKlinis::all();

        // Query Builder
        $dataKategoriKlinis = \DB::table('kategori_klinis')
        ->select('idkategori_klinis', 'nama_kategori_klinis')
        ->get();

        return view('admin.kategori-klinis.index', ['KategoriKlinis' => $dataKategoriKlinis]);
    }
    public function create()
    {
        return view('admin.kategori-klinis.create');
    }
    public function store(Request $request)
    {
        // validasi input
        $validatedData = $this->validateKategoriKlinis($request);

        // helper function untuk menyimpan data
        $kategoriKlinis = $this->createKategoriKlinis($validatedData);

        return redirect()->route('admin.kategoriklinis.index')
                        ->with('success', 'Kategori klinis berhasil ditambahkan.');
    }
    protected function validateKategoriKlinis(Request $request, $id = null)
    {
        // data yang bersifat uniq
        $uniqueRule = $id ?
        'unique:kategori_klinis,nama_kategori_klinis,'. $id .',idkategori_klinis': 
        
        'unique:kategori_klinis,nama_kategori_klinis';

        // validasi input
        return $request->validate([
            'nama_kategori_klinis' => [
                'required',
                'string',
                'max:255',
                'min:3', 
                $uniqueRule
            ],
        ],[
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.string' => 'Nama kategori klinis harus berupa teks.',
            'nama_kategori_klinis.max' => 'Nama kategori klinis tidak boleh lebih dari 255 karakter.',
            'nama_kategori_klinis.min' => 'Nama kategori klinis minimal 3 karakter.',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis sudah ada dalam database.',
        ]);
    }
    // Helper untuk membuat data baru
    protected function createKategoriKlinis(array $data)
    {   
        try{
            // Eloquent
            // return KategoriKlinis::create([
            //     'nama_kategori_klinis' => $data['nama_kategori_klinis'],
            // ]);

            // Query Builder
            $kategoriKlinis = \DB::table('kategori_klinis')->insert([
                'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($data['nama_kategori_klinis']),
            ]);
            
        return $kategoriKlinis;
        } catch (\Exception $e){
            // tangani error jika diperlukan
            throw new \Exception('Gagal menyimpan kategori klinis: ' . $e->getMessage());
        }
    }
    // helper untuk format nama menjadi titlr case
    protected function formatNamaKategoriKlinis($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
    public function destroy(Request $request, $id)
    {
        try {
            // Query Builder
            DB::table('kategori_klinis')
                ->where('idkategori_klinis', $id)
                ->delete();

            return redirect()->route('admin.kategoriklinis.index')
                            ->with('success', 'Kategori klinis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.kategoriklinis.index')
                            ->with('error', 'Gagal menghapus kategori klinis: ' . $e->getMessage());
        }
    }
}
