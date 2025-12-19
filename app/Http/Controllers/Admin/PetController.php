<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of pets
     */
    public function index()
    {
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->select(
                'pet.*',
                'user.nama as nama_pemilik',
                'ras_hewan.nama_ras'
            )
            ->orderBy('pet.nama', 'asc')
            ->get();

        return view('admin.pet.index', compact('pets'));
    }

    /**
     * Show the form for creating a new pet
     */
    public function create()
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama')
            ->orderBy('user.nama', 'asc')
            ->get();

        $rasHewan = DB::table('ras_hewan')
            ->orderBy('nama_ras', 'asc')
            ->get();

        return view('admin.pet.create', compact('pemilik', 'rasHewan'));
    }

    /**
     * Store a newly created pet
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ], [
            'nama.required' => 'Nama hewan harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'idras_hewan.required' => 'Ras hewan harus dipilih',
            'idpemilik.required' => 'Pemilik harus dipilih',
        ]);

        try {
            DB::table('pet')->insert([
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'warna_tanda' => $request->warna_tanda,
                'jenis_kelamin' => $request->jenis_kelamin,
                'idras_hewan' => $request->idras_hewan,
                'idpemilik' => $request->idpemilik,
                'created_at' => now(),
            ]);

            return redirect()->route('admin.pet.index')
                ->with('success', 'Data hewan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing pet
     */
    public function edit($id)
    {
        $pet = DB::table('pet')->where('idpet', $id)->first();

        if (!$pet) {
            return redirect()->back()->with('error', 'Data hewan tidak ditemukan');
        }

        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama')
            ->orderBy('user.nama', 'asc')
            ->get();

        $rasHewan = DB::table('ras_hewan')
            ->orderBy('nama_ras', 'asc')
            ->get();

        return view('admin.pet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    /**
     * Update pet
     */
    public function update(Request $request, $id)
    {
        $pet = DB::table('pet')->where('idpet', $id)->first();

        if (!$pet) {
            return redirect()->back()->with('error', 'Data hewan tidak ditemukan');
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ], [
            'nama.required' => 'Nama hewan harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'idras_hewan.required' => 'Ras hewan harus dipilih',
            'idpemilik.required' => 'Pemilik harus dipilih',
        ]);

        try {
            DB::table('pet')
                ->where('idpet', $id)
                ->update([
                    'nama' => $request->nama,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'warna_tanda' => $request->warna_tanda,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'idras_hewan' => $request->idras_hewan,
                    'idpemilik' => $request->idpemilik,
                ]);

            return redirect()->route('admin.pet.index')
                ->with('success', 'Data hewan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete pet
     */
    public function destroy($id)
    {
        try {
            $pet = DB::table('pet')->where('idpet', $id)->first();

            if (!$pet) {
                return redirect()->back()->with('error', 'Data hewan tidak ditemukan');
            }

            // Check if pet has appointments
            $hasAppointments = DB::table('temu_dokter')->where('idpet', $id)->exists();

            if ($hasAppointments) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus hewan yang memiliki riwayat appointment!');
            }

            DB::table('pet')->where('idpet', $id)->delete();

            return redirect()->route('admin.pet.index')
                ->with('success', 'Data hewan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}