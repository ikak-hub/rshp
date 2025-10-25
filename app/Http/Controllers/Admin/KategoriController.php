<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori; // Import model Kategori

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all(); // Mengambil semua data kategori
        return view('admin.kategori.index', compact('kategori'));
    }
}