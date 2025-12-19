<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KodeTindakanTerapiController extends Controller
{
    public function patch(Request $request, $id){
        //? validasi input
        $validatedData = $this->validateKodeTindakanTerapi($request, $id);

        try {
            // Eloquent
            // $rasHewan = RasHewan::findOrFail($id);
            // $rasHewan->nama_ras = $this->formatNamaRasHewan($validatedData['nama_ras']);
            // $rasHewan->idjenis_hewan = $validatedData['idjenis_hewan'];
            // $rasHewan->save();

            // Query Builder
            DB::table('kode_tindakan_terapi')
                ->where('idkode_tindakan_terapi', $id) 
                ->update([
                    'deskripsi_tindakan_terapi' => $validatedData['deskripsi'],
                    'idkategori' => $request->get('idkategori'),
                    'idkategori_klinis' => $request->get('idkategori_klinis')
                ]);

            return redirect()->route('admin.kodetindakanterapi.index', ['page' => $request->get('page')])
                            ->with('success', 'Kategori klinis berhasil diperbarui.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('admin.kodetindakanterapi.edit', $id)
                            ->with('error', 'Gagal memperbarui Kategori Klinis: ' . $e->getMessage())
                            ->withInput();
        }
    }
    public function get(Request $request, $id) {
        $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')->join('kategori', 'kategori.idkategori', 'kode_tindakan_terapi.idkategori')->join('kategori_klinis', 'kategori_klinis.idkategori_klinis', 'kode_tindakan_terapi.idkategori_klinis')->where('kode_tindakan_terapi.idkode_tindakan_terapi', $id)->select('kode_tindakan_terapi.*', 'kategori.*', 'kategori_klinis.*')->first();

        return response()->json($kodeTindakanTerapi);
    }

    public function index()
    {
        // Eloquent
        // $kodeTindakanTerapi = KodeTindakanTerapi::all();

        // Query Builder
       $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')->join('kategori', 'kategori.idkategori', 'kode_tindakan_terapi.idkategori')->join('kategori_klinis', 'kategori_klinis.idkategori_klinis', 'kode_tindakan_terapi.idkategori_klinis')->select('kode_tindakan_terapi.*', 'kategori.*', 'kategori_klinis.*')->paginate(15);
       $kategories = DB::table('kategori')->select('*')->get();
       $kategoriKlinises = DB::table('kategori_klinis')->select('*')->get();

        return view('admin.kodetindakanterapi.index', 
        compact(['kodeTindakanTerapi', 'kategories', 'kategoriKlinises'])
    );
    }
    // public function create()
    // {
    //     $kategories = DB::table('kategori')->select('*')->get();
    //     $kategoriKlinises = DB::table('kategori_klinis')->select('*')->get();

    //     return view('admin.kodetindakanterapi.create', compact('kategories', 'kategoriKlinises'));
    // }
    public function store(Request $request)
    {
        // validasi input
        $validatedData = $this->validateKodeTindakanTerapi($request);

        // helper function untuk menyimpan data         
        $kodeTindakanTerapi = $this->createKodeTindakanTerapi($validatedData);

        return redirect()->route('admin.kodetindakanterapi.index')
                        ->with('success', 'Kode tindakan berhasil ditambahkan.');
    }
    protected function validateKodeTindakanTerapi(Request $request, $id = null)
    {
        // data yang bersifat uniq
        $uniqueRuleKode = $id ?
        'unique:kode_tindakan_terapi,kode,'. $id .',idkode_tindakan_terapi': 
        'unique:kode_tindakan_terapi,kode';

        // validasi input
        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:255',
                'min:3', 
                $uniqueRuleKode
            ],
            'deskripsi' => 'required|string|max:255|min:3'
        ],[
            'kode.required' => 'Kode tindakan wajib diisi.',
            'kode.string' => 'Kode tindakan harus berupa teks.',
            'kode.max' => 'Kode tindakan tidak boleh lebih dari 255 karakter.',
            'kode.min' => 'Kode tindakan minimal 3 karakter.',
            'kode.unique' => 'Kode tindakan sudah ada dalam database.',
            'deskripsi.required' => 'deskripsi wajib diisi.',
            'deskripsi.string' => 'deskripsi harus berupa teks.',
            'deskripsi.max' => 'deskripsi tidak boleh lebih dari 255 karakter.',
            'deskripsi.min' => 'deskripsi minimal 3 karakter.',
        ]);
    }
    //helper untuk membuat data baru
    protected function createKodeTindakanTerapi(array $data)
    {
        try{
            // Eloquent
            // return KodeTindakanTerapi::create([
            //     'kode' => $data['kode'],
            //     'deskripsi_tindakan' => $data['deskripsi_tindakan'],
            //     'biaya_tindakan' => $data['biaya_tindakan'],
            // ]);

            // Query Builder
            $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')->insert([
                'kode' => $data['kode']
            ]);

        return $kodeTindakanTerapi;
        } catch (\Exception $e){
            // tangani error jika diperlukan
            throw new \Exception('Gagal menyimpan kode tindakan: ' . $e->getMessage());
        }
    }   
    // helper untuk format nama menjadi titlr case
    protected function formatNamaKodeTindakanTerapi($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
    public function destroy(Request $request)
    {
        $id = $request->param('id');
    } 
}
