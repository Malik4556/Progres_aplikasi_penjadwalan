<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HariController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ViewerController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenWaktuController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\DashboardkdController;
use App\Http\Controllers\DosenMatkulController;
use App\Http\Controllers\DashboarddapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::middleware('only_guest')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticating']);
});

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::middleware('only_direktorat')->group(function() {
    // Dashboard
        Route::get('/dashboard_dap', [DashboarddapController::class, 'index_dap']);
    // Ruangan
        Route::get('/ruangan', [RuanganController::class, 'index']);
        Route::get('/ruangan-add', [RuanganController::class, 'create']);
        Route::post('/ruangan', [RuanganController::class, 'store']);
        Route::get('/ruangan-edit/{id}', [RuanganController::class, 'edit']);
        Route::put('/ruangan/{id}', [RuanganController::class, 'update']);
        Route::get('/ruangan-delete/{id}', [RuanganController::class, 'delete']);
        Route::delete('/ruangan-destroy/{id}', [RuanganController::class, 'destroy']);

    // Kela
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas/generate', [KelasController::class, 'generate'])->name('kelas.generate');
    Route::get('/kelas-delete/{id}', [KelasController::class, 'delete'])->name('kelas.delete');
    Route::post('/kelas-delete/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy'); // Menggunakan POST untuk hapus
    Route::get('/kelas-delete-all', [KelasController::class, 'deleteAll'])->name('kelas.deleteAll');
    // Ubah menjadi kelas-delete-all untuk lebih jelas

    // View
        Route::get('/viewer-mahasiswa', [ViewerController::class, 'mahasiswa']);
        Route::get('/viewer-kesediaandos', [ViewerController::class, 'kesediaandos']);
        Route::get('/viewer-dosenwaktu', [ViewerController::class, 'dosenwaktu']);
        Route::get('/viewer-dosenmatkul', [ViewerController::class, 'dosenmatkul']);
        Route::post('/viewer-update-status', [ViewerController::class, 'updateStatus']);
        Route::post('/viewer-update-statusdoswak', [ViewerController::class, 'updateStatusDoswak']);
        Route::post('/viewer-update-statusdoskul', [ViewerController::class, 'updateStatusDoskul']);

    // Jadwal
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/generate', [JadwalController::class, 'generate'])->name('jadwal.generate');
        Route::post('/jadwal/generate', [JadwalController::class, 'generate'])->name('jadwal.generate');
        Route::get('/jadwal-delete/{id}', [JadwalController::class, 'delete'])->name('jadwal.delete');
        Route::get('/jadwal-delete', [JadwalController::class, 'deleteAll'])->name('jadwal.deleteAll');
        Route::get('/dosen/{class_id}', [JadwalController::class, 'getDosenForClass']);

    });

    Route::middleware('only_kepala')->group(function() {
    // Dashboard
        Route::get('/dashboard_kd', [DashboardkdController::class, 'index_kd']);
    // Mahasiswa
        Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
        Route::get('/mahasiswa-add', [MahasiswaController::class, 'create']);
        Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
        Route::get('/mahasiswa-edit/{id}', [MahasiswaController::class, 'edit']);
        Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
        Route::get('/mahasiswa-delete/{id}', [MahasiswaController::class, 'delete']);
        Route::delete('/mahasiswa-destroy/{id}', [MahasiswaController::class, 'destroy']);
        Route::post('/update-status', [MahasiswaController::class, 'updateStatus']);
        Route::get('/status', [MahasiswaController::class, 'status']);

    // Hari
        Route::get('/hari', [HariController::class, 'index']);
        Route::get('/hari-add', [HariController::class, 'create']);
        Route::post('/hari', [HariController::class, 'store']);
        Route::get('/hari-edit/{id}', [HariController::class, 'edit']);
        Route::put('/hari/{id}', [HariController::class, 'update']);
        Route::get('/hari-delete/{id}', [HariController::class, 'delete']);
        Route::delete('/hari-destroy/{id}', [HariController::class, 'destroy']);

    // Matakuliah
        Route::get('/matakuliah', [MatakuliahController::class, 'index']);
        Route::get('/matakuliah-add', [MatakuliahController::class, 'create']);
        Route::post('/matakuliah', [MatakuliahController::class, 'store']);
        Route::get('/matakuliah-edit/{id}', [MatakuliahController::class, 'edit']);
        Route::put('/matakuliah/{id}', [MatakuliahController::class, 'update']);
        Route::get('/matakuliah-delete/{id}', [MatakuliahController::class, 'delete']);
        Route::delete('/matakuliah-destroy/{id}', [MatakuliahController::class, 'destroy'])->name('mahasiswa.destroy');

    // Dosen
        Route::get('/dosen', [DosenController::class, 'index']);
        Route::get('/dosen-add', [DosenController::class, 'create']);
        Route::post('/dosen', [DosenController::class, 'store']);
        Route::get('/dosen-edit/{id}', [DosenController::class, 'edit']);
        Route::put('/dosen/{id}', [DosenController::class, 'update']);
        Route::get('/dosen-delete/{id}', [DosenController::class, 'delete']);
        Route::delete('/dosen-destroy/{id}', [DosenController::class, 'destroy']);

    // Jam
        Route::get('/jam', [JamController::class, 'index'])->name('jam.index');
        Route::get('/jam-add', [JamController::class, 'create']);
        Route::post('/jam', [JamController::class, 'store'])->name('jam.store');
        Route::get('/jam-edit/{id}', [JamController::class, 'edit'])->name('jam.edit');
        Route::put('/jam/{id}', [JamController::class, 'update'])->name('jam.update');
        Route::get('/jam-delete/{id}', [JamController::class, 'delete'])->name('jam.delete');
        Route::delete('/jam-destroy/{id}', [JamController::class, 'destroy'])->name('jam.destroy');

    // DosenMatakuliah
        Route::get('/dosenmatkul', [DosenMatkulController::class, 'index']);
        Route::get('/dosenmatkul-add', [DosenMatkulController::class, 'create']);
        Route::post('/dosenmatkul', [DosenMatkulController::class, 'store']);
        Route::get('/dosenmatkul-edit/{id}', [DosenMatkulController::class, 'edit']);
        Route::put('/dosenmatkul/{id}', [DosenMatkulController::class, 'update']);
        Route::get('/dosenmatkul-delete/{id}', [DosenMatkulController::class, 'delete']);
        Route::delete('/dosenmatkul-destroy/{id}', [DosenMatkulController::class, 'destroy'])->name('dosenmatkul.destroy');
        Route::get('/get-matakuliah-by-semester', [DosenMatkulController::class, 'getMatakuliahBySemester']);
        Route::post('/update-status-dosenmatkul', [DosenMatkulController::class, 'updateStatusDoskul']);
        Route::get('/statusdoskul', [DosenMatkulController::class, 'statusdoskul']);
        Route::get('/get-sks-by-matakuliah', [DosenMatkulController::class, 'getSksByMatakuliah']);



    // DosenWaktu
        Route::get('/dosenwaktu', [DosenWaktuController::class, 'index']);
        Route::get('/dosenwaktu-add', [DosenWaktuController::class, 'create']);
        Route::post('/dosenwaktu', [DosenWaktuController::class, 'store']);
        Route::get('/dosenwaktu-edit/{id}', [DosenWaktuController::class, 'edit']);
        Route::put('/dosenwaktu/{id}', [DosenWaktuController::class, 'update']);
        Route::get('/dosenwaktu-delete/{id}', [DosenWaktuController::class, 'delete']);
        Route::delete('/dosenwaktu-destroy/{id}', [DosenWaktuController::class, 'destroy'])->name('dosenwaktu.destroy');
        Route::post('/update-status-dosenwaktu', [DosenWaktuController::class, 'updateStatusDoswak']);
        Route::get('/statusdoswak', [DosenWaktuController::class, 'statusdoskul']);

    });
});



