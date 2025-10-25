<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RasHewan;

class RasHewanController extends Controller
{
    public function index()
    {
        $dataRasHewan = RasHewan::orderBy('nama_ras', 'asc')->get();
        return view('admin.ras-hewan.index', ['RasHewan'=> $dataRasHewan]);
    }
}

