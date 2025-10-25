<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisHewan;

class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = jenishewan::all();
        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }
}
