<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class siteController extends Controller
{
    public function home() {
        return view('site.home');
    }
    public function organisasiView() {
        return view('site.organisasi');
    }
    public function layananView() {
        return view('site.layanan');
    }
    public function visimisiView() {
        return view('site.visimisi');
    }
    public function loginView() {
        return view('site.login');
    }
    public function cekKoneksi()
    {
        try {
            \DB::connection()->getPdo();
            return "Koneksi database berhasil!";
        } catch (\Exception $e) {
            return "Gagal terkoneksi ke database: " . $e->getMessage();
        }
    }
}
