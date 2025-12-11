<?php
namespace App\Http\Controllers\Resepsionis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\Ras;
use App\Models\RasHewan;

class DashboardResepsionisController extends Controller
{
    public function index()
    {
        // Query Builder untuk Pet
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->select('pet.*', 'user.nama as nama_pemilik', 'ras_hewan.nama_ras')
            ->get();

        // Query Builder untuk Pemilik
        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->get();

        // Query Builder untuk Temu Dokter (dengan relasi)
        $appointments = DB::table('temu_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as u_pemilik', 'pemilik.iduser', '=', 'u_pemilik.iduser')
            ->leftJoin('role_user as ru_dokter', 'temu_dokter.idrole_user', '=', 'ru_dokter.idrole_user')
            ->leftJoin('user as u_dokter', 'ru_dokter.iduser', '=', 'u_dokter.iduser')
            ->select(
                'temu_dokter.*',
                'pet.nama as nama_pet',
                'u_pemilik.nama as nama_pemilik',
                'u_dokter.nama as nama_dokter'
            )
            ->get();

        // Data dropdown untuk form
        $users = DB::table('user')->get();
        $breeds = DB::table('ras_hewan')->get();
        $petsForAppointment = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pet.idpet', 'pet.nama', 'user.nama as nama_pemilik')
            ->get();
        $doctors = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role.idrole', 2) // role = Dokter
            ->select('role_user.idrole_user', 'user.nama')
            ->get();

        return view('resepsionis.dashboard-resepsionis', compact(
            'pets', 'pemiliks', 'appointments',
            'users', 'breeds', 'petsForAppointment', 'doctors'
        ));
    }

    // --- PET CRUD ---
    public function storePet(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P', // L = jantan, P = betina (sesuaikan)
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        DB::table('pet')->insert([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
            'warna_tanda' => $request->warna_tanda ?? null,
        ]);

        return redirect()->back()->with('success', 'Pet berhasil ditambahkan.');
    }

    public function updatePet(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ]);

        DB::table('pet')
            ->where('idpet', $id)
            ->update([
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'idpemilik' => $request->idpemilik,
                'idras_hewan' => $request->idras_hewan,
                'warna_tanda' => $request->warna_tanda ?? null,
            ]);

        return redirect()->back()->with('success', 'Pet berhasil diperbarui.');
    }

    public function destroyPet($id)
    {
        DB::table('pet')->where('idpet', $id)->delete();
        return redirect()->back()->with('success', 'Pet berhasil dihapus.');
    }

    // --- PEMILIK CRUD ---
public function storePemilik(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'required|email|unique:user,email',
        'no_wa' => 'required|string|max:45',
        'alamat' => 'required|string|max:100',
    ]);

    try {
        DB::beginTransaction();

        // 1. Insert ke tabel user terlebih dahulu
        $iduser = DB::table('user')->insertGetId([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt('password123'), // default password
        ]);

        // 2. Insert ke tabel pemilik dengan iduser yang baru dibuat
        DB::table('pemilik')->insert([
            'iduser' => $iduser,
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Pemilik berhasil ditambahkan dengan password default: password123');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Gagal menambahkan pemilik: ' . $e->getMessage()]);
    }
}

public function updatePemilik(Request $request, $id)
{
    // Ambil data pemilik dulu untuk mendapatkan iduser
    $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
    
    if (!$pemilik) {
        return redirect()->back()->withErrors(['error' => 'Data pemilik tidak ditemukan']);
    }

    $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'required|email|unique:user,email,' . $pemilik->iduser . ',iduser',
        'no_wa' => 'required|string|max:45',
        'alamat' => 'required|string|max:100',
    ]);

    try {
        DB::beginTransaction();

        // Update user table
        DB::table('user')
            ->where('iduser', $pemilik->iduser)
            ->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);

        // Update pemilik table
        DB::table('pemilik')
            ->where('idpemilik', $id)
            ->update([
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat,
            ]);

        DB::commit();
        return redirect()->back()->with('success', 'Pemilik berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Gagal memperbarui pemilik: ' . $e->getMessage()]);
    }
}

    // --- TEMU DOKTER CRUD ---
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'required|exists:role_user,idrole_user',
            'waktu_daftar' => 'required|date',
        ]);

        // Hitung no_urut hari ini
        $today = now()->toDateString();
        $last = DB::table('temu_dokter')
            ->whereDate('waktu_daftar', $today)
            ->orderBy('no_urut', 'desc')
            ->first();

        $no_urut = $last ? $last->no_urut + 1 : 1;

        DB::table('temu_dokter')->insert([
            'no_urut' => $no_urut,
            'waktu_daftar' => $request->waktu_daftar,
            'status' => 'A', // A = active, C = cancelled
            'idpet' => $request->idpet,
            'idrole_user' => $request->idrole_user,
        ]);

        return redirect()->back()->with('success', 'Janji temu dokter berhasil dibuat.');
    }

    public function cancelAppointment($id)
    {
        DB::table('temu_dokter')
            ->where('idreservasi_dokter', $id)
            ->update(['status' => 'C']);

        return redirect()->back()->with('success', 'Janji temu berhasil dibatalkan.');
    }
    // Atau jika ingin tambahkan method untuk update appointment
public function updateAppointment(Request $request, $id)
{
    $request->validate([
        'idpet' => 'required|exists:pet,idpet',
        'idrole_user' => 'required|exists:role_user,idrole_user',
        'waktu_daftar' => 'required|date',
        'status' => 'required|in:A,C',
    ]);

    DB::table('temu_dokter')
        ->where('idreservasi_dokter', $id)
        ->update([
            'waktu_daftar' => $request->waktu_daftar,
            'status' => $request->status,
            'idpet' => $request->idpet,
            'idrole_user' => $request->idrole_user,
        ]);

    return redirect()->back()->with('success', 'Janji temu dokter berhasil diperbarui.');
}
}