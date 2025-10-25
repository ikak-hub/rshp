<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKlinis;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        $dataKategoriKlinis = KategoriKlinis::all();
        return view('admin.kategori-klinis.index', ['KategoriKlinis' => $dataKategoriKlinis]);
    }
}
