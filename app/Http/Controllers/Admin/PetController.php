<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet; // Import model Pet

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with(['pemilik.user', 'ras'])->get(); // Eager load relasi pemilik dan ras
        return view('admin.pet.index', compact('pets'));
    }
}
