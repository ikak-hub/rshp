<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RasHewan;
use Illuminate\Support\Facades\DB;

class RasHewanController extends Controller
{
    public function index()
    {
        // Eloquent
        // $dataRasHewan = RasHewan::orderBy('nama_ras', 'asc')->get();

        // Query Builder
        $dataRasHewan = DB::table('ras_hewan')
        ->select('ras_hewan.idras_hewan', 'ras_hewan.nama_ras', 'jenis_hewan.nama_jenis_hewan')
        ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
        ->get();

        return view('admin.ras-hewan.index', ['RasHewan'=> $dataRasHewan]);
    }
    public function create()
    {
        return view('admin.ras-hewan.create');
    }
    public function store(Request $request)
    {
        // validasi input
        $validatedData = $this->validateRasHewan($request);

        // helper function untuk menyimpan data
        $rasHewan = $this->createRasHewan($validatedData);

        return redirect()->route('admin.ras-hewan.index')
                        ->with('success', 'Ras hewan berhasil ditambahkan.');
    }
    protected function validateRasHewan(Request $request, $id = null)
    {
        // data yang bersifat uniq
        $uniqueRule = $id ? 'unique:ras_hewan,nama_ras,'. $id .',idras_hewan' : 'unique:ras_hewan,nama_ras';
        // dd($request->all());
        
        // validasi input
        return ( $request->validate([
            'nama_ras' => [
                'required',
                'string',
                'max:255',
                'min:3', 
                $uniqueRule
            ],
            'idjenis_hewan' => [
                'required',
                'integer',
            ],
        ],[
            'nama_ras.required' => 'Nama ras hewan wajib diisi.',
            'nama_ras.string' => 'Nama ras hewan harus berupa teks.',
            'nama_ras.max' => 'Nama ras hewan tidak boleh lebih dari 255 karakter.',
            'nama_ras.min' => 'Nama ras hewan minimal 3 karakter.',
            'nama_ras.unique' => 'Nama ras hewan sudah ada dalam database.',
            'idjenis_hewan.required' => 'Jenis hewan wajib diisi.',
            'idjenis_hewan.integer' => 'Jenis hewan harus berupa angka.',
        ]));
    }
    // helper untuk membuat data baru
    protected function createRasHewan(array $data)
    {
        try {  
            
            // eloquent
            // return RasHewan::create([
            //     'nama_ras' => $this->formatNamaRasHewan($data['nama_ras']),
            //     'idjenis_hewan' => $data['idjenis_hewan'],
            // ]);

            // Query Builder
            $rasHewan = DB::table('ras_hewan')->insert([
                'nama_ras' => $this->formatNamaRasHewan($data['nama_ras']),
                'idjenis_hewan' => $data['idjenis_hewan'],
            ]);

        return $rasHewan;
        } catch (\Exception $e) {
            // tangani error jika diperlukan
            throw new \Exception('Gagal menyimpan ras hewan: ' . $e->getMessage());
        }
    }
    // helper untuk format nama menjadi titlr case
    protected function formatNamaRasHewan($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
    // edit dan update
    public function edit($id)
    {
        // Eloquent
        // $rasHewan = RasHewan::findOrFail($id);

        // Query Builder
        $rasHewan = DB::table('ras_hewan')
            ->where('idras_hewan', $id)
            ->first();

        $jenisHewans = DB::table('jenis_hewan')->get(['*']);

        return view('admin.ras-hewan.edit', [
            'rasHewan' => $rasHewan,
            'jenisHewans' => $jenisHewans
        ]);
    }
    // update function
    public function update(Request $request, $id)
    {

        //? validasi input
        //debug dd('its reach me 1');
        //debug dd($request->all());
        $validatedData = $this->validateRasHewan($request, $id);
        //debug dd('its reach me 2');


        try {
            // Eloquent
            // $rasHewan = RasHewan::findOrFail($id);
            // $rasHewan->nama_ras = $this->formatNamaRasHewan($validatedData['nama_ras']);
            // $rasHewan->idjenis_hewan = $validatedData['idjenis_hewan'];
            // $rasHewan->save();

            // Query Builder
            DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->update([
                    'nama_ras' => $this->formatNamaRasHewan($validatedData['nama_ras']),
                    'idjenis_hewan' => $validatedData['idjenis_hewan'],
                ]);

            return redirect()->route('admin.ras-hewan.index')
                            ->with('success', 'Ras hewan berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.ras-hewan.edit', $id)
                            ->with('error', 'Gagal memperbarui ras hewan: ' . $e->getMessage())
                            ->withInput();
        }
    }
    public function destroy($id)
    {
        try {
            // Eloquent
            // $rasHewan = RasHewan::findOrFail($id);
            // $rasHewan->delete();

            // Query Builder
            DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->delete();

            return redirect()->route('admin.ras-hewan.index')
                            ->with('success', 'Ras hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ras-hewan.index')
                            ->with('error', 'Gagal menghapus ras hewan: ' . $e->getMessage());
        }
    }

}

