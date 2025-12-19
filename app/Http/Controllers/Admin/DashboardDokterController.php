<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardDokterController extends Controller
{
    /**
     * Display dashboard dokter
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Get dokter data
        $dokter = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->where('role_user.iduser', $user->iduser)
            ->where('role_user.idrole', 2)
            ->select('role_user.*', 'user.nama', 'user.email')
            ->first();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
        }

        // Get all pets
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as owner', 'pemilik.iduser', '=', 'owner.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->select('pet.*', 'owner.nama as nama_pemilik', 'owner.email', 'pemilik.no_wa', 'pemilik.alamat', 'ras_hewan.nama_ras')
            ->get();

        // Get rekam medis untuk dokter ini dengan hitung jumlah detail
        $rekamMedis = DB::table('rekam_medis')
            ->join('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->leftJoin('role_user as dokter_role', 'rekam_medis.dokter_pemeriksa', '=', 'dokter_role.idrole_user')
            ->leftJoin('user as dokter_user', 'dokter_role.iduser', '=', 'dokter_user.iduser')
            ->leftJoin('detail_rekam_medis', 'rekam_medis.idrekam_medis', '=', 'detail_rekam_medis.idrekam_medis')
            ->where('rekam_medis.dokter_pemeriksa', $dokter->idrole_user)
            ->select(
                'rekam_medis.*', 
                'pet.nama as nama_pet', 
                'pet.idpet', 
                'dokter_user.nama as nama_dokter',
                'temu_dokter.idreservasi_dokter',
                DB::raw('COUNT(DISTINCT detail_rekam_medis.iddetail_rekam_medis) as jumlah_tindakan')
            )
            ->groupBy(
                'rekam_medis.idrekam_medis',
                'rekam_medis.idreservasi_dokter',
                'rekam_medis.anamnesa',
                'rekam_medis.temuan_klinis',
                'rekam_medis.diagnosa',
                'rekam_medis.dokter_pemeriksa',
                'rekam_medis.created_at',
                'pet.nama',
                'pet.idpet',
                'dokter_user.nama',
                'temu_dokter.idreservasi_dokter'
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->get();

        // Get appointment hari ini
        $appointmentsToday = DB::table('temu_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->leftJoin('rekam_medis', 'temu_dokter.idreservasi_dokter', '=', 'rekam_medis.idreservasi_dokter')
            ->where('temu_dokter.idrole_user', $dokter->idrole_user)
            ->whereDate('temu_dokter.waktu_daftar', today())
            ->select(
                'temu_dokter.*',
                'pet.nama as nama_pet',
                'pet.idpet',
                'user.nama as nama_pemilik',
                'rekam_medis.idrekam_medis'
            )
            ->orderBy('temu_dokter.no_urut', 'asc')
            ->get();

        $pasienHariIni = $appointmentsToday->count();

        return view('admin.dashboard-dokter', compact('dokter', 'pets', 'rekamMedis', 'pasienHariIni', 'appointmentsToday'));
    }

    /**
     * Get patient detail (AJAX)
     */
    public function patientDetail($id)
    {
        try {
            $pet = DB::table('pet')
                ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->where('pet.idpet', $id)
                ->select('pet.*', 'user.nama as nama_pemilik', 'user.email', 'pemilik.no_wa', 'pemilik.alamat', 'ras_hewan.nama_ras')
                ->first();

            if (!$pet) {
                return response()->json(['error' => 'Data pasien tidak ditemukan'], 404);
            }

            return response()->json(['pet' => $pet]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data pasien: ' . $e->getMessage()], 500);
        }
    }

    /**
     * View rekam medis detail with all details
     */
    public function viewRekamMedis($id)
    {
        try {
            $rekamMedis = DB::table('rekam_medis')
                ->join('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
                ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
                ->leftJoin('role_user', 'rekam_medis.dokter_pemeriksa', '=', 'role_user.idrole_user')
                ->leftJoin('user as dokter', 'role_user.iduser', '=', 'dokter.iduser')
                ->where('rekam_medis.idrekam_medis', $id)
                ->select('rekam_medis.*', 'pet.nama as nama_pet', 'dokter.nama as nama_dokter')
                ->first();

            if (!$rekamMedis) {
                return response()->json(['error' => 'Rekam medis tidak ditemukan'], 404);
            }

            // Get detail rekam medis
            $details = DB::table('detail_rekam_medis')
                ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->where('detail_rekam_medis.idrekam_medis', $id)
                ->select(
                    'detail_rekam_medis.*',
                    'kode_tindakan_terapi.kode',
                    'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->orderBy('detail_rekam_medis.tanggal_input', 'desc')
                ->get();

            return response()->json([
                'rekam_medis' => $rekamMedis,
                'details' => $details
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show form create rekam medis
     */
    public function createRekamMedis($idreservasi)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $dokter = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->where('role_user.iduser', $user->iduser)
            ->where('role_user.idrole', 2)
            ->first();

        $appointment = DB::table('temu_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as owner', 'pemilik.iduser', '=', 'owner.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->where('temu_dokter.idreservasi_dokter', $idreservasi)
            ->select(
                'temu_dokter.*',
                'pet.nama as nama_pet',
                'pet.idpet',
                'owner.nama as nama_pemilik',
                'ras_hewan.nama_ras'
            )
            ->first();

        if (!$appointment) {
            return redirect()->back()->with('error', 'Data appointment tidak ditemukan');
        }

        $existingRM = DB::table('rekam_medis')
            ->where('idreservasi_dokter', $idreservasi)
            ->first();

        if ($existingRM) {
            return redirect()->route('dokter.dashboard')
                ->with('info', 'Rekam medis sudah ada untuk appointment ini')
                ->with('open_rekam_medis', $existingRM->idrekam_medis);
        }

        return view('admin.dokter.create-rekam-medis', compact('dokter', 'appointment'));
    }

    /**
     * Store new rekam medis
     */
    public function storeRekamMedis(Request $request)
    {
        $request->validate([
            'idreservasi_dokter' => 'required|exists:temu_dokter,idreservasi_dokter',
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'nullable|string',
            'diagnosa' => 'required|string',
        ], [
            'idreservasi_dokter.required' => 'ID Reservasi harus diisi',
            'anamnesa.required' => 'Anamnesa harus diisi',
            'diagnosa.required' => 'Diagnosa harus diisi',
        ]);

        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            $dokter = DB::table('role_user')
                ->where('iduser', $user->iduser)
                ->where('idrole', 2)
                ->first();

            $idRekamMedis = DB::table('rekam_medis')->insertGetId([
                'idreservasi_dokter' => $request->idreservasi_dokter,
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'dokter_pemeriksa' => $dokter->idrole_user,
                'created_at' => now(),
            ]);

            DB::table('temu_dokter')
                ->where('idreservasi_dokter', $request->idreservasi_dokter)
                ->update(['status' => 'S']);

            DB::commit();

            return redirect()->route('dokter.dashboard')
                ->with('success', 'Rekam medis berhasil dibuat! Silakan tambahkan detail pemeriksaan.')
                ->with('open_rekam_medis', $idRekamMedis);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * CREATE - Store new detail rekam medis
     */
    public function storeDetailRekamMedis(Request $request)
    {
        $request->validate([
            'idrekam_medis' => 'required|exists:rekam_medis,idrekam_medis',
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'nullable|string|max:1000',
        ], [
            'idrekam_medis.required' => 'ID Rekam medis harus diisi',
            'idkode_tindakan_terapi.required' => 'Kode tindakan/terapi harus dipilih',
            'detail.max' => 'Detail maksimal 1000 karakter',
        ]);

        try {
            DB::table('detail_rekam_medis')->insert([
                'idrekam_medis' => $request->idrekam_medis,
                'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
                'detail' => $request->detail,
                'tanggal_input' => now(),
                'created_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Detail rekam medis berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan detail: ' . $e->getMessage());
        }
    }

    /**
     * READ - Show single detail rekam medis (for edit modal)
     */
    public function showDetailRekamMedis($id)
    {
        try {
            $detail = DB::table('detail_rekam_medis')
                ->join('kode_tindakan_terapi', 'detail_rekam_medis.idkode_tindakan_terapi', '=', 'kode_tindakan_terapi.idkode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->where('detail_rekam_medis.iddetail_rekam_medis', $id)
                ->select(
                    'detail_rekam_medis.*',
                    'kode_tindakan_terapi.kode',
                    'kode_tindakan_terapi.deskripsi_tindakan_terapi',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                )
                ->first();

            if (!$detail) {
                return response()->json(['error' => 'Detail tidak ditemukan'], 404);
            }

            return response()->json($detail);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * UPDATE - Update detail rekam medis
     */
    public function updateDetailRekamMedis(Request $request, $id)
    {
        $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'nullable|string|max:1000',
        ], [
            'idkode_tindakan_terapi.required' => 'Kode tindakan/terapi harus dipilih',
            'detail.max' => 'Detail maksimal 1000 karakter',
        ]);

        try {
            $detailRecord = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->first();

            if (!$detailRecord) {
                return redirect()->back()->with('error', 'Detail tidak ditemukan');
            }

            DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->update([
                    'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
                    'detail' => $request->detail,
                ]);

            return redirect()->back()->with('success', 'Detail rekam medis berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui detail: ' . $e->getMessage());
        }
    }

    /**
     * DELETE - Delete detail rekam medis
     */
    public function destroyDetailRekamMedis($id)
    {
        try {
            $detail = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->first();

            if (!$detail) {
                return redirect()->back()->with('error', 'Detail tidak ditemukan');
            }

            DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $id)
                ->delete();

            return redirect()->back()->with('success', 'Detail rekam medis berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus detail: ' . $e->getMessage());
        }
    }

    /**
     * Get kode tindakan/terapi (AJAX)
     */
    public function getKodeTindakan($kategori = null)
    {
        try {
            $query = DB::table('kode_tindakan_terapi')
                ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
                ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
                ->select(
                    'kode_tindakan_terapi.*',
                    'kategori.nama_kategori',
                    'kategori_klinis.nama_kategori_klinis'
                );

            if ($kategori) {
                $query->where('kode_tindakan_terapi.idkategori', $kategori);
            }

            $data = $query->orderBy('kode_tindakan_terapi.kode', 'asc')->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show rekam medis page
     */
    public function indexRekamMedis()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $dokter = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->where('role_user.iduser', $user->iduser)
            ->where('role_user.idrole', 2)
            ->select('role_user.*', 'user.nama', 'user.email')
            ->first();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
        }

        // Get rekam medis dengan jumlah tindakan
        $rekamMedis = DB::table('rekam_medis')
            ->join('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->leftJoin('role_user as dokter_role', 'rekam_medis.dokter_pemeriksa', '=', 'dokter_role.idrole_user')
            ->leftJoin('user as dokter_user', 'dokter_role.iduser', '=', 'dokter_user.iduser')
            ->leftJoin('detail_rekam_medis', 'rekam_medis.idrekam_medis', '=', 'detail_rekam_medis.idrekam_medis')
            ->where('rekam_medis.dokter_pemeriksa', $dokter->idrole_user)
            ->select(
                'rekam_medis.*', 
                'pet.nama as nama_pet', 
                'pet.idpet', 
                'dokter_user.nama as nama_dokter',
                'temu_dokter.idreservasi_dokter',
                DB::raw('COUNT(DISTINCT detail_rekam_medis.iddetail_rekam_medis) as jumlah_tindakan')
            )
            ->groupBy(
                'rekam_medis.idrekam_medis',
                'rekam_medis.idreservasi_dokter',
                'rekam_medis.anamnesa',
                'rekam_medis.temuan_klinis',
                'rekam_medis.diagnosa',
                'rekam_medis.dokter_pemeriksa',
                'rekam_medis.created_at',
                'pet.nama',
                'pet.idpet',
                'dokter_user.nama',
                'temu_dokter.idreservasi_dokter'
            )
            ->orderBy('rekam_medis.created_at', 'desc')
            ->get();

        return view('admin.dokter.rekam-medis', compact('dokter', 'rekamMedis'));
    }

    /**
     * Update profile dokter
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:user,email,' . $user->iduser . ',iduser',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
        ]);

        try {
            DB::table('user')
                ->where('iduser', $user->iduser)
                ->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}