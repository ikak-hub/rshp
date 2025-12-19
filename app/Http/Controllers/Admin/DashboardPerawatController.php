<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;
use App\Models\Perawat;
use App\Models\KodeTindakanTerapi;
use App\Models\TemuDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardPerawatController extends Controller
{
    public function index() 
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil semua data pet dengan relasi
        $pets = Pet::with(['pemilik.user', 'ras.jenisHewan'])->get();
        
        // Ambil data rekam medis dengan relasi
        $rekamMedis = RekamMedis::with([
            'pet.pemilik.user',
            'temuDokter.roleUser.user',
            'detailRekamMedis.kodeTindakanTerapi'
        ])->latest('created_at')->get();
        
        // Ambil data perawat yang sedang login
        $perawat = Perawat::where('id_user', auth()->user()->iduser)->first();
        
        // Jika perawat belum ada di database, buat object dummy
        if (!$perawat) {
            $perawat = new Perawat();
            $perawat->user = auth()->user();
        }
        
        // Hitung pasien hari ini berdasarkan created_at rekam medis
        $pasienHariIni = RekamMedis::whereDate('created_at', today())->count();
        
        // Ambil kode tindakan untuk form
        $tindakanList = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();
        
        return view('admin.dashboard-perawat', compact('pets', 'rekamMedis', 'perawat', 'pasienHariIni', 'tindakanList'));
    }
    
    public function patientDetail($id)
    {
        $pet = Pet::with(['pemilik.user', 'ras.jenisHewan'])->findOrFail($id);
        
        // Ambil rekam medis pet ini
        $rekamMedis = RekamMedis::whereHas('temuDokter', function($q) use ($id) {
            $q->where('idpet', $id);
        })
        ->with([
            'temuDokter.roleUser.user',
            'detailRekamMedis.kodeTindakanTerapi.kategori'
        ])
        ->latest('created_at')
        ->get();
        
        return response()->json([
            'pet' => [
                'nama' => $pet->nama,
                'nama_ras' => $pet->ras->nama_ras ?? 'N/A',
                'tanggal_lahir' => $pet->tanggal_lahir,
                'jenis_kelamin' => $pet->jenis_kelamin,
                'nama_pemilik' => $pet->pemilik->user->nama ?? 'N/A',
                'email' => $pet->pemilik->user->email ?? 'N/A',
                'no_wa' => $pet->pemilik->no_wa ?? 'N/A',
                'alamat' => $pet->pemilik->alamat ?? 'N/A',
            ],
            'rekam_medis' => $rekamMedis
        ]);
    }
    
    public function storeRekamMedis(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'nullable|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|array',
            'tindakan.*' => 'exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail_tindakan' => 'nullable|array',
        ]);
        
        DB::beginTransaction();
        try {
            // Cari atau buat temu dokter untuk pet ini
            $lastNoUrut = TemuDokter::whereDate('waktu_daftar', today())->max('no_urut') ?? 0;
            
            $temuDokter = TemuDokter::firstOrCreate([
                'idpet' => $request->idpet,
                'status' => 'A',
            ], [
                'waktu_daftar' => now(),
                'no_urut' => $lastNoUrut + 1,
                'idrole_user' => auth()->user()->roleUser->first()->idrole_user ?? null,
            ]);
            
            // Buat rekam medis
            $rekamMedis = RekamMedis::create([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'idpet' => $request->idpet,
                'idreservasi_dokter' => $temuDokter->idreservasi_dokter,
                'dokter_pemeriksa' => auth()->user()->roleUser->first()->idrole_user ?? null,
                'tanggal_periksa' => now(),
                'berat_badan' => $request->berat_badan ?? 0,
                'prognosa' => $request->prognosa ?? null,
                'terapi' => $request->terapi ?? null,
                'catatan' => $request->catatan ?? null,
            ]);
            
            // Simpan detail tindakan/terapi jika ada
            if ($request->has('tindakan') && is_array($request->tindakan)) {
                foreach ($request->tindakan as $index => $idTindakan) {
                    DetailRekamMedis::create([
                        'idrekam_medis' => $rekamMedis->idrekam_medis,
                        'idkode_tindakan_terapi' => $idTindakan,
                        'detail' => $request->detail_tindakan[$index] ?? null,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('admin.dashboard-perawat')
                ->with('success', 'Rekam medis berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function showRekamMedis($id)
    {
        try {
            $rekamMedis = RekamMedis::with([
                'pet.pemilik.user',
                'pet.ras.jenisHewan',
                'temuDokter.roleUser.user',
                'detailRekamMedis.kodeTindakanTerapi.kategori',
                'detailRekamMedis.kodeTindakanTerapi.kategoriKlinis'
            ])->findOrFail($id);
            
            return response()->json([
                'idrekam_medis' => $rekamMedis->idrekam_medis,
                'tanggal_periksa' => $rekamMedis->tanggal_periksa ? date('d/m/Y H:i', strtotime($rekamMedis->tanggal_periksa)) : date('d/m/Y H:i', strtotime($rekamMedis->created_at)),
                'nama_pet' => $rekamMedis->pet->nama ?? 'N/A',
                'pemilik' => $rekamMedis->pet->pemilik->user->nama ?? 'N/A',
                'dokter' => $rekamMedis->temuDokter->roleUser->user->nama ?? 'N/A',
                'berat_badan' => $rekamMedis->berat_badan ?? '-',
                'anamnesa' => $rekamMedis->anamnesa ?? '-',
                'temuan_klinis' => $rekamMedis->temuan_klinis ?? '-',
                'diagnosa' => $rekamMedis->diagnosa ?? '-',
                'prognosa' => $rekamMedis->prognosa ?? '-',
                'terapi' => $rekamMedis->terapi ?? '-',
                'catatan' => $rekamMedis->catatan ?? '-',
                'detail_tindakan' => $rekamMedis->detailRekamMedis->map(function($detail) {
                    return [
                        'kode' => $detail->kodeTindakanTerapi->kode ?? '-',
                        'tindakan' => $detail->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-',
                        'kategori' => $detail->kodeTindakanTerapi->kategori->nama_kategori ?? 'N/A',
                        'detail' => $detail->detail ?? '-',
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data: ' . $e->getMessage()], 500);
        }
    }
    
    public function updateRekamMedis(Request $request, $id)
    {
        $request->validate([
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'nullable|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|array',
            'berat_badan' => 'nullable|numeric',
            'prognosa' => 'nullable|string',
            'terapi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
            
            $rekamMedis->update([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'berat_badan' => $request->berat_badan,
                'prognosa' => $request->prognosa,
                'terapi' => $request->terapi,
                'catatan' => $request->catatan,
            ]);
            
            // Hapus detail lama dan buat yang baru
            DetailRekamMedis::where('idrekam_medis', $id)->delete();
            
            if ($request->has('tindakan') && is_array($request->tindakan)) {
                foreach ($request->tindakan as $index => $idTindakan) {
                    DetailRekamMedis::create([
                        'idrekam_medis' => $id,
                        'idkode_tindakan_terapi' => $idTindakan,
                        'detail' => $request->detail_tindakan[$index] ?? null,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('admin.dashboard-perawat')
                ->with('success', 'Rekam medis berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function destroyRekamMedis($id)
    {
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
            
            // Hapus detail terlebih dahulu
            DetailRekamMedis::where('idrekam_medis', $id)->delete();
            
            // Hapus rekam medis
            $rekamMedis->delete();
            
            return redirect()->route('admin.dashboard-perawat')
                ->with('success', 'Rekam medis berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus rekam medis: ' . $e->getMessage());
        }
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:500',
            'email' => 'required|email|max:200|unique:user,email,' . auth()->user()->iduser . ',iduser',
            'no_hp' => 'nullable|string|max:45',
            'alamat' => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pendidikan' => 'nullable|string|max:100',
        ]);
        
        DB::beginTransaction();
        try {
            $user = auth()->user();
            
            // Update tabel user
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);
            
            // Update tabel perawat
            $perawat = Perawat::where('id_user', $user->iduser)->first();
            
            if ($perawat) {
                $perawat->update([
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'pendidikan' => $request->pendidikan,
                ]);
            } else {
                // Buat data perawat baru jika belum ada
                Perawat::create([
                    'id_user' => $user->iduser,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'pendidikan' => $request->pendidikan,
                ]);
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }
}