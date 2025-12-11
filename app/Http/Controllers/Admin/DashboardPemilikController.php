<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pemilik;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        
        // Get data pemilik
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.iduser', $user->iduser)
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->first();

        if (!$pemilik) {
            return redirect()->back()->with('error', 'Data pemilik tidak ditemukan');
        }

        // Get pets milik pemilik ini
        $pets = DB::table('pet')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->select('pet.*', 'ras_hewan.nama_ras')
            ->get();

        // Get jadwal temu dokter
        $appointments = DB::table('temu_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->leftJoin('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
            ->leftJoin('user as dokter', 'role_user.iduser', '=', 'dokter.iduser')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->select(
                'temu_dokter.*',
                'pet.nama as nama_pet',
                'dokter.nama as nama_dokter'
            )
            ->orderBy('temu_dokter.waktu_daftar', 'desc')
            ->get();

        // Get rekam medis (jika tabel rekam_medis sudah ada)
        $rekamMedis = collect(); // Empty collection default
        
        // Check if table exists
        try {
            $rekamMedis = DB::table('rekam_medis')
                ->join('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
                ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
                ->leftJoin('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
                ->leftJoin('user as dokter', 'role_user.iduser', '=', 'dokter.iduser')
                ->where('pet.idpemilik', $pemilik->idpemilik)
                ->select(
                    'rekam_medis.*',
                    'pet.nama as nama_pet',
                    'dokter.nama as nama_dokter',
                    'temu_dokter.waktu_daftar'
                )
                ->orderBy('rekam_medis.tanggal_periksa', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist yet, use empty collection
            $rekamMedis = collect();
        }

        return view('pemilik.dashboard-pemilik', compact(
            'pemilik',
            'pets',
            'appointments',
            'rekamMedis'
        ));
    }

    // Update profil pemilik
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email,' . $user->iduser . ',iduser',
            'no_wa' => 'required|string|max:45',
            'alamat' => 'required|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Update user
            DB::table('user')
                ->where('iduser', $user->iduser)
                ->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                ]);

            // Update pemilik
            DB::table('pemilik')
                ->where('iduser', $user->iduser)
                ->update([
                    'no_wa' => $request->no_wa,
                    'alamat' => $request->alamat,
                ]);

            DB::commit();
            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui profil: ' . $e->getMessage()]);
        }
    }

    // View detail rekam medis
    public function viewRekamMedis($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        $pemilik = DB::table('pemilik')
            ->where('iduser', $user->iduser)
            ->first();

        if (!$pemilik) {
            return response()->json(['error' => 'Data pemilik tidak ditemukan'], 404);
        }

        try {
            $rekamMedis = DB::table('rekam_medis')
                ->join('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
                ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
                ->leftJoin('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
                ->leftJoin('user as dokter', 'role_user.iduser', '=', 'dokter.iduser')
                ->where('rekam_medis.idrekam_medis', $id)
                ->where('pet.idpemilik', $pemilik->idpemilik)
                ->select(
                    'rekam_medis.*',
                    'pet.nama as nama_pet',
                    'dokter.nama as nama_dokter',
                    'temu_dokter.waktu_daftar'
                )
                ->first();

            if (!$rekamMedis) {
                return response()->json(['error' => 'Rekam medis tidak ditemukan'], 404);
            }

            return response()->json($rekamMedis);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Tabel rekam_medis belum tersedia'], 500);
        }
    }
}
