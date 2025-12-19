<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{
    public function index()
    {
        // Query Builder dengan alias yang benar
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select(
                'pemilik.idpemilik',
                'pemilik.no_wa',
                'pemilik.alamat',
                'user.nama as nama_pemilik', // Pastikan menggunakan alias
                'user.email',
                'user.iduser'
            )
            ->get();

        return view('admin.pemilik.index', compact('pemilik'));
    }

    public function create()
    {
        return view('admin.pemilik.create');
    }

    public function store(Request $request)
    {   
        // validasi input
        $validatedData = $this->validatePemilik($request);

        // helper function untuk menyimpan data
        $pemilik = $this->createPemilik($validatedData);

        return redirect()->route('admin.pemilik.index')
                        ->with('success', 'Pemilik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data pemilik dengan join user
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select(
                'pemilik.*',
                'user.nama as nama_pemilik',
                'user.email'
            )
            ->first();

        if (!$pemilik) {
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        return view('admin.pemilik.edit', compact('pemilik'));
    }

    public function update(Request $request, $id)
    {
        // Ambil data pemilik untuk mendapatkan iduser
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
        
        if (!$pemilik) {
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        // Validasi dengan mengecualikan email user saat ini
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email,' . $pemilik->iduser . ',iduser',
            'no_wa' => 'required|string|max:45',
            'alamat' => 'required|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Update user
            DB::table('user')
                ->where('iduser', $pemilik->iduser)
                ->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                ]);

            // Update pemilik
            DB::table('pemilik')
                ->where('idpemilik', $id)
                ->update([
                    'no_wa' => $request->no_wa,
                    'alamat' => $request->alamat,
                ]);

            DB::commit();
            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Pemilik berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pemilik: ' . $e->getMessage())
                ->withInput();
        }
    }

    protected function validatePemilik(Request $request, $id = null)
    {
        // data yang bersifat uniq
        $uniqueRule = $id ?
            'unique:pemilik,no_wa,' . $id . ',idpemilik' : 
            'unique:pemilik,no_wa';

        // validasi input
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'no_wa' => [
                'required',
                'string',
                'max:45',
                $uniqueRule
            ],
            'alamat' => 'required|string|max:100',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_wa.required' => 'No WA wajib diisi.',
            'no_wa.unique' => 'No WA sudah ada dalam database.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]); 
    }

    //helper untuk membuat data baru
    protected function createPemilik(array $data)
    {
        try {
            DB::beginTransaction();

            // Insert user terlebih dahulu
            $iduser = DB::table('user')->insertGetId([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => bcrypt('password123'), // default password
            ]);

            // Insert pemilik dengan iduser yang baru dibuat
            $pemilik = DB::table('pemilik')->insert([
                'iduser' => $iduser,
                'no_wa' => $data['no_wa'],
                'alamat' => $data['alamat'],
            ]);

            DB::commit();
            return $pemilik;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Gagal menyimpan pemilik: ' . $e->getMessage());
        }
    } 

    public function destroy($id)
    {
        try {
            // Ambil data pemilik untuk mendapatkan iduser
            $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
            
            if (!$pemilik) {
                return redirect()->route('admin.pemilik.index')
                    ->with('error', 'Data pemilik tidak ditemukan');
            }

            DB::beginTransaction();

            // Hapus pemilik
            DB::table('pemilik')->where('idpemilik', $id)->delete();

            // Hapus user terkait (opsional, tergantung business logic)
            // DB::table('user')->where('iduser', $pemilik->iduser)->delete();

            DB::commit();
            
            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Gagal menghapus pemilik: ' . $e->getMessage());
        }
    }
}