<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\siteController;
use Illuminate\Support\Facades\Auth;

Route::get('#')->name('#');

Route::get('/', function () {
    return view('welcome');
})->name('welcome'); // Rute utama untuk halaman welcome

Route::get('/cek-koneksi', [siteController::class, 'cekKoneksi'])->name('site.cek-koneksi');
Route::get('/organisasi', [siteController::class, 'organisasiView'])->name('organisasi');
Route::get('/layanan', [siteController::class, 'layananView'])->name('layanan');
Route::get('/visimisi', [siteController::class, 'visimisiView'])->name('visimisi');

Route::get('/', [siteController::class, 'home'])->name('home'); // Rute untuk halaman home

// Authentication Routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// akses administrator
Route::middleware('isAdministrator')->group(function(){
    
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardAdminController::class, 'index'])->name('admin.dashboard');

    //? JENIS HEWAN ?//
    Route::get('/admin/jenis-hewan', [App\Http\Controllers\Admin\JenisHewanController::class, 'index'])->name('admin.jenis-hewan.index');
    Route::get('/admin/jenis-hewan/create', [App\Http\Controllers\Admin\JenisHewanController::class, 'create'])->name('admin.jenis-hewan.create');
    Route::post('/admin/jenis-hewan/store', [App\Http\Controllers\Admin\JenisHewanController::class, 'store'])->name('admin.jenis-hewan.store');
    Route::get('/admin/jenis-hewan/{id}/edit', [App\Http\Controllers\Admin\JenisHewanController::class, 'edit'])->name('admin.jenis-hewan.edit');
    Route::patch('/admin/jenis-hewan/{id}/update', [App\Http\Controllers\Admin\JenisHewanController::class, 'update'])->name('admin.jenis-hewan.patch');
    Route::delete('/admin/jenis-hewan/{id}', [App\Http\Controllers\Admin\JenisHewanController::class, 'destroy'])->name('admin.jenis-hewan.delete');

    //? PEMILIIK ?//
    Route::get('/admin/pemilik', [App\Http\Controllers\Admin\PemilikController::class, 'index'])->name('admin.pemilik.index');
    Route::get('/admin/pemilik/create', [App\Http\Controllers\Admin\PemilikController::class, 'create'])->name('admin.pemilik.create');
    Route::post('/admin/pemilik/store', [App\Http\Controllers\Admin\PemilikController::class, 'store'])->name('admin.pemilik.store');
    Route::delete('/admin/pemilik/{id}', [App\Http\Controllers\Admin\PemilikController::class, 'destroy'])->name('admin.pemilik.delete');

    //? RAS HWAN ?//
    Route::get('/admin/ras-hewan', [App\Http\Controllers\Admin\RasHewanController::class, 'index'])->name('admin.ras-hewan.index');
    Route::get('/admin/ras-hewan/create', [App\Http\Controllers\Admin\RasHewanController::class, 'create'])->name('admin.ras-hewan.create');
    Route::post('/admin/ras-hewan/store', [App\Http\Controllers\Admin\RasHewanController::class, 'store'])->name('admin.ras-hewan.store');
    Route::get('/admin/ras-hewan/{id}/edit', [App\Http\Controllers\Admin\RasHewanController::class, 'edit'])->name('admin.ras-hewan.edit');
    Route::put('/admin/ras-hewan/{id}', [App\Http\Controllers\Admin\RasHewanController::class, 'update'])->name('admin.ras-hewan.update');
    Route::delete('/admin/ras-hewan/{id}', [App\Http\Controllers\Admin\RasHewanController::class, 'destroy'])->name('admin.ras-hewan.delete');

    //? KATEGORI ?//
    Route::get('/admin/kategori', [App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/admin/kategori/create', [App\Http\Controllers\Admin\KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/admin/kategori/store', [App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/admin/kategori/{id}/edit', [App\Http\Controllers\Admin\KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::patch('/admin/kategori/{id}/edit', [App\Http\Controllers\Admin\KategoriController::class, 'patch'])->name('admin.kategori.patch');
    Route::delete('/admin/kategori/{id}', [App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('admin.kategori.delete');

    //? KATEGORI KLINIS ?//
    Route::get('/admin/kategori-klinis', [App\Http\Controllers\Admin\KategoriKlinisController::class, 'index'])->name('admin.kategoriklinis.index');
    Route::get('/admin/kategori-klinis/create',[App\Http\Controllers\Admin\KategoriKlinisController::class, 'create'])->name('admin.kategoriklinis.create');
    Route::post('/admin/kategori-klinis/store',[App\Http\Controllers\Admin\KategoriKlinisController::class, 'store'])->name('admin.kategoriklinis.store');
    Route::delete('/admin/kategori-klinis/{id}', [App\Http\Controllers\Admin\KategoriKlinisController::class, 'destroy'])->name('admin.kategoriklinis.delete');

    //? KODE TINDAKAN TERAPI ?//
    Route::get('/admin/kode-tindakan-terapi', [App\Http\Controllers\Admin\KodeTindakanTerapiController::class, 'index'])->name('admin.kodetindakanterapi.index');
    Route::get('/admin/kode-tindakan-terapi/create', [App\Http\Controllers\Admin\KodeTindakanTerapiController::class, 'create'])->name('admin.kodetindakanterapi.create');
    Route::post('/admin/kode-tindakan-terapi/store',[App\Http\Controllers\Admin\KodeTindakanTerapiController::class, 'store'])->name('admin.kodetindakanterapi.store');
    Route::delete('/admin/kode-tindakan-terapi/{id}', [App\Http\Controllers\Admin\KodeTindakanTerapiController::class, 'destroy'])->name('admin.kodetindakanterapi.delete');

    //? PET ?//
    Route::get('/admin/pet', [App\Http\Controllers\Admin\PetController::class, 'index'])->name('admin.pet.index');
    Route::get('/admin/pet/create', [App\Http\Controllers\Admin\PetController::class, 'create'])->name('admin.pet.create');
    Route::post('/admin/pet/store', [App\Http\Controllers\Admin\PetController::class, 'store'])->name('admin.pet.store');
    Route::delete('/admin/pet/{id}', [App\Http\Controllers\Admin\PetController::class, 'destroy'])->name('admin.pet.delete');

    //? ROLE ?//
    Route::get('/admin/role', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('admin.role.index');
    Route::get('/admin/role/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('admin.role.create');
    Route::post('/admin/role/store', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('admin.role.store');
    Route::delete('/admin/role/{id}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('admin.role.delete');
    Route::resource('/admin/role', App\Http\Controllers\Admin\RoleController::class)->names('admin.role');

    //? ROLE USER ?//
    Route::get('/admin/role-user', [App\Http\Controllers\Admin\RoleUserController::class, 'index'])->name('admin.roleuser.index');
    Route::get('/admin/role-user/create', [App\Http\Controllers\Admin\RoleUserController::class, 'create'])->name('admin.roleuser.create');
    Route::post('/admin/role-user/store', [App\Http\Controllers\Admin\RoleUserController::class, 'store'])->name('admin.roleuser.store');
    Route::get('/admin/role-user/{id}/edit', [App\Http\Controllers\Admin\RoleUserController::class, 'edit'])->name('admin.roleuser.edit');
    Route::put('/admin/role-user/{id}', [App\Http\Controllers\Admin\RoleUserController::class, 'update'])->name('admin.roleuser.update');
    Route::delete('/admin/role-user/{id}', [App\Http\Controllers\Admin\RoleUserController::class, 'destroy'])->name('admin.roleuser.delete');
    // Route::resource('/admin/role-user', App\Http\Controllers\Admin\RoleUserController::class)->names('admin.roleuser');

});

// akses resepsionis
Route::middleware('isResepsionis')->group(function(){
    Route::get('/resepsionis/dashboard', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'index'])->name('resepsionis.dashboard');
    
    // Pet Routes
    Route::post('/resepsionis/pet/store', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'storePet'])->name('resepsionis.pet.store');
    Route::put('/resepsionis/pet/{id}', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'updatePet'])->name('resepsionis.pet.update');
    Route::delete('/resepsionis/pet/{id}', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'destroyPet'])->name('resepsionis.pet.destroy');
    
    // Pemilik Routes
    Route::post('/resepsionis/pemilik/store', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'storePemilik'])->name('resepsionis.pemilik.store');
    Route::put('/resepsionis/pemilik/{id}', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'updatePemilik'])->name('resepsionis.pemilik.update');
    Route::delete('/resepsionis/pemilik/{id}', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'destroyPemilik'])->name('resepsionis.pemilik.destroy');
    
    // Temu Dokter Routes
    Route::post('/resepsionis/appointment/store', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'storeAppointment'])->name('resepsionis.appointment.store');
    Route::put('/resepsionis/appointment/{id}/cancel', [App\Http\Controllers\Resepsionis\DashboardResepsionisController::class, 'cancelAppointment'])->name('resepsionis.appointment.cancel');
});

// akses dokter
Route::middleware('isDokter')->group(function(){
    Route::get('/dokter/dashboard', [App\Http\Controllers\Admin\DashboardDokterController::class, 'index'])->name('dokter.dashboard');
});

// akses perawat
Route::middleware('isPerawat')->group(function(){
    Route::get('/perawat/dashboard', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'index'])->name('admin.dashboard-perawat');
// CRUD Rekam Medis
    Route::post('/perawat/rekam-medis', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'storeRekamMedis'])
        ->name('perawat.rekam-medis.store');
    Route::get('/perawat/rekam-medis/{id}', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'showRekamMedis'])
        ->name('perawat.rekam-medis.show');
    Route::get('/perawat/rekam-medis/{id}/edit', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'editRekamMedis'])
        ->name('perawat.rekam-medis.edit');
    Route::put('/perawat/rekam-medis/{id}', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'updateRekamMedis'])
        ->name('perawat.rekam-medis.update');
    Route::delete('/perawat/rekam-medis/{id}', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'destroyRekamMedis'])
        ->name('perawat.rekam-medis.destroy');
    
    // Profil & Patient
    Route::put('/perawat/profile', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'updateProfile'])
        ->name('perawat.profile.update');
    Route::get('/perawat/patient/{id}', [App\Http\Controllers\Admin\DashboardPerawatController::class, 'patientDetail'])
        ->name('perawat.patient.detail');
});

// akses pemilik
Route::middleware('isPemilik')->group(function(){
    Route::get('/pemilik/dashboard', [App\Http\Controllers\Admin\DashboardPemilikController::class, 'index'])->name('pemilik.dashboard');
    Route::put('/profile/update', [App\Http\Controllers\Admin\DashboardPemilikController::class, 'updateProfile'])->name('pemilik.profile.update'); 
    Route::get('/rekam-medis/{idpet}', [App\Http\Controllers\Admin\DashboardPemilikController::class, 'viewRekamMedis'])->name('pemilik.rekammedis.view');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');
