<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori; // Import model Kategori menggunakan Eloquent
use Illuminate\Support\Facades\DB; // Import Query Builder from table database


class KategoriController extends Controller
{
    public function patch(Request $request, $id){
        //? validasi input
        $validatedData = $this->validateKategori($request, $id);

        try {
            // Eloquent
            // $rasHewan = RasHewan::findOrFail($id);
            // $rasHewan->nama_ras = $this->formatNamaRasHewan($validatedData['nama_ras']);
            // $rasHewan->idjenis_hewan = $validatedData['idjenis_hewan'];
            // $rasHewan->save();

            // Query Builder
            DB::table('kategori')
                ->where('idkategori', $id) 
                ->update([
                    'nama_kategori' => $this->formatNamaKategori($validatedData['nama_kategori'])
                ]);

            return redirect()->route('admin.kategori.index')
                            ->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.kategori.edit', $id)
                            ->with('error', 'Gagal memperbarui Kategori: ' . $e->getMessage())
                            ->withInput();
        }
    }
    
    public function edit(Request $request, $id) {
        $kategori = DB::table('kategori')->select('*')->where('idkategori', $id)->first();
        return view('admin.kategori.edit', ['kategori' => $kategori]);
    }

    public function index()
    {
        // Eloquent
        // $kategori = Kategori::all(); // Mengambil semua data kategori

        // Query Builder
        $kategori = DB::table('kategori')
        ->select('idkategori', 'nama_kategori')
        ->get();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }
    public function store(Request $request)
    {
        // validasi input
        $validatedData = $this->validateKategori($request);

        // helper function untuk menyimpan data
        $kategori = $this->createKategori($validatedData);

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil ditambahkan.');

    }
    protected function validateKategori(Request $request, $id = null)
    {
        // data yang bersifat uniq
        $uniqueRule = $id ?
        'unique:kategori,nama_kategori,'. $id .',idkategori': 
        'unique:kategori,nama_kategori';

        // validasi input
        return $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'min:3', 
                $uniqueRule
            ],
        ],[
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
            'nama_kategori.unique' => 'Nama kategori sudah ada dalam database.',
        ]);
    }
    //helper untuk membuat data baru
    protected function createKategori(array $data)
    {
        try{

            // Eloquent
            // return Kategori::create([
            //     'nama_kategori' => $data['nama_kategori'],
            // ]);

            // Query Builder
            $kategori = DB::table('kategori')->insert([
                'nama_kategori'=>$this->formatNamaKategori($data['nama_kategori']),
            ]);

        return $kategori;
        } catch (\Exception $e){
            // tangani error jika diperlukan
            throw new \Exception('Gagal menyimpan data kategori: ' . $e->getMessage());
        }
    }
    // helper untuk format nama menjadi titlr case
    protected function formatNamaKategori($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
    public function destroy(Request $request)
    {
        $id = $request->param('id');
    }
}