<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MesinAbsensiController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasParalelController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\FingerSpotController;
use App\Http\Controllers\TemplateMessageController;
use App\Http\Controllers\InformasiSekolahController;
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

Route::get('/generate', function(){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
 });
 
Route::get('/', [LoginController::class,'login'])->name('login');
Route::get('/daftar', [LoginController::class,'Register'])->name('daftar');
Route::post('/action-login', [LoginController::class, 'action_login'])->name('action-login')->middleware('web');;
Route::post('/action-daftar', [LoginController::class, 'actionRegister'])->name('action-daftar');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/dashboardadmin', [DashboardController::class, 'dashboardAdmin'])->name('dashboardadmin')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| KelompokAkses
|--------------------------------------------------------------------------
|
*/
Route::get('/roles', [RolesController::class,'View'])->name('roles')->middleware('auth');
Route::get('/roles/form/{id}', [RolesController::class,'Form'])->name('roles-form')->middleware('auth');
Route::post('/roles/store', [RolesController::class, 'store'])->name('roles-store')->middleware('auth');
Route::post('/roles/edit', [RolesController::class, 'edit'])->name('roles-edit')->middleware('auth');
Route::delete('/roles/delete/{id}', [RolesController::class, 'deletedata'])->name('roles-delete')->middleware('auth');
Route::get('/roles/export', [RolesController::class,'Export'])->name('roles-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
|
*/
Route::get('/user', [UserController::class,'View'])->name('user')->middleware('auth');
Route::get('/user/form/{id}', [UserController::class,'Form'])->name('user-form')->middleware('auth');
Route::post('/user/store', [UserController::class, 'store'])->name('user-store')->middleware('auth');
Route::post('/user/edit', [UserController::class, 'edit'])->name('user-edit')->middleware('auth');
Route::delete('/user/delete/{id}', [UserController::class, 'deletedata'])->name('user-delete')->middleware('auth');
Route::get('/user/export', [UserController::class,'Export'])->name('user-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Mesin
|--------------------------------------------------------------------------
|
*/

Route::get('/mesinabsensi', [MesinAbsensiController::class,'index'])->name('mesinabsensi')->middleware('auth');
Route::get('/mesinabsensi/form/{id}', [MesinAbsensiController::class,'Form'])->name('mesinabsensi-form')->middleware('auth');
Route::post('/mesinabsensi/store', [MesinAbsensiController::class, 'store'])->name('mesinabsensi-store')->middleware('auth');
Route::post('/mesinabsensi/edit', [MesinAbsensiController::class, 'edit'])->name('mesinabsensi-edit')->middleware('auth');
Route::delete('/mesinabsensi/delete/{id}', [MesinAbsensiController::class, 'destroy'])->name('mesinabsensi-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Tahun Ajaran
|--------------------------------------------------------------------------
|
*/

Route::get('/tahunajaran', [TahunAjaranController::class,'index'])->name('tahunajaran')->middleware('auth');
Route::get('/tahunajaran/form/{id}', [TahunAjaranController::class,'Form'])->name('tahunajaran-form')->middleware('auth');
Route::post('/tahunajaran/store', [TahunAjaranController::class, 'store'])->name('tahunajaran-store')->middleware('auth');
Route::post('/tahunajaran/edit', [TahunAjaranController::class, 'edit'])->name('tahunajaran-edit')->middleware('auth');
Route::delete('/tahunajaran/delete/{id}', [TahunAjaranController::class, 'destroy'])->name('tahunajaran-delete')->middleware('auth');
Route::get('get-tahunajaran/{id}', [TahunAjaranController::class, 'getTahunAjaran']);


/*
|--------------------------------------------------------------------------
| Kelas
|--------------------------------------------------------------------------
|
*/

Route::get('/kelas', [KelasController::class,'index'])->name('kelas')->middleware('auth');
Route::get('/kelas/form/{id}', [KelasController::class,'Form'])->name('kelas-form')->middleware('auth');
Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas-store')->middleware('auth');
Route::post('/kelas/edit', [KelasController::class, 'edit'])->name('kelas-edit')->middleware('auth');
Route::delete('/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('kelas-delete')->middleware('auth');
Route::get('get-kelas/{id}', [KelasController::class, 'getKelas']);

/*
|--------------------------------------------------------------------------
| Kelas Paralel
|--------------------------------------------------------------------------
|
*/

Route::get('/kelas-paralel', [KelasParalelController::class,'index'])->name('kelas-paralel')->middleware('auth');
Route::get('/kelas-paralel/form/{id}', [KelasParalelController::class,'Form'])->name('kelas-paralel-form')->middleware('auth');
Route::post('/kelas-paralel/store', [KelasParalelController::class, 'store'])->name('kelas-paralel-store')->middleware('auth');
Route::post('/kelas-paralel/edit', [KelasParalelController::class, 'edit'])->name('kelas-paralel-edit')->middleware('auth');
Route::delete('/kelas-paralel/delete/{id}', [KelasParalelController::class, 'destroy'])->name('kelas-paralel-delete')->middleware('auth');
Route::get('get-kelas-paralel/{kelasID}', [KelasParalelController::class, 'getKelasParalel']);


/*
|--------------------------------------------------------------------------
| Ruangan
|--------------------------------------------------------------------------
|
*/

Route::get('/ruangan', [RuanganController::class,'index'])->name('ruangan')->middleware('auth');
Route::get('/ruangan/form/{id}', [RuanganController::class,'Form'])->name('ruangan-form')->middleware('auth');
Route::post('/ruangan/store', [RuanganController::class, 'store'])->name('ruangan-store')->middleware('auth');
Route::post('/ruangan/edit', [RuanganController::class, 'edit'])->name('ruangan-edit')->middleware('auth');
Route::delete('/ruangan/delete/{id}', [RuanganController::class, 'destroy'])->name('ruangan-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Siswa
|--------------------------------------------------------------------------
|
*/

Route::get('/siswa', [SiswaController::class,'index'])->name('siswa')->middleware('auth');
Route::get('/siswa/form/{id}', [SiswaController::class,'Form'])->name('siswa-form')->middleware('auth');
Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa-store')->middleware('auth');
Route::post('/siswa/edit', [SiswaController::class, 'edit'])->name('siswa-edit')->middleware('auth');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa-delete')->middleware('auth');
Route::post('/update-kelas-siswa', [SiswaController::class, 'updateKelas'])->name('update-kelas-siswa');
Route::post('/uploadsiswa', [FingerSpotController::class, 'CreateUser'])->name('uploadsiswa')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Guru
|--------------------------------------------------------------------------
|
*/

Route::get('/guru', [GuruController::class,'index'])->name('guru')->middleware('auth');
Route::get('/guru/form/{id}', [GuruController::class,'Form'])->name('guru-form')->middleware('auth');
Route::post('/guru/store', [GuruController::class, 'store'])->name('guru-store')->middleware('auth');
Route::post('/guru/edit', [GuruController::class, 'edit'])->name('guru-edit')->middleware('auth');
Route::delete('/guru/delete/{id}', [GuruController::class, 'destroy'])->name('guru-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Mapel
|--------------------------------------------------------------------------
|
*/

Route::get('/mapel', [MataPelajaranController::class,'index'])->name('mapel')->middleware('auth');
Route::get('/mapel/form/{id}', [MataPelajaranController::class,'Form'])->name('mapel-form')->middleware('auth');
Route::post('/mapel/store', [MataPelajaranController::class, 'store'])->name('mapel-store')->middleware('auth');
Route::post('/mapel/edit', [MataPelajaranController::class, 'edit'])->name('mapel-edit')->middleware('auth');
Route::delete('/mapel/delete/{id}', [MataPelajaranController::class, 'destroy'])->name('mapel-delete')->middleware('auth');
Route::get('get-mapel/{id}', [MataPelajaranController::class, 'getMapel']);

/*
|--------------------------------------------------------------------------
| Absensi
|--------------------------------------------------------------------------
|
*/

Route::get('/absensi', [AbsensiController::class,'index'])->name('absensi')->middleware('auth');
// Route::get('/guru/form/{id}', [GuruController::class,'Form'])->name('guru-form')->middleware('auth');
// Route::post('/guru/store', [GuruController::class, 'store'])->name('guru-store')->middleware('auth');
// Route::post('/guru/edit', [GuruController::class, 'edit'])->name('guru-edit')->middleware('auth');
// Route::delete('/guru/delete/{id}', [GuruController::class, 'destroy'])->name('guru-delete')->middleware('auth');


Route::get('get-provinsi/{provID}', [LocationController::class, 'getProvinsi']);
Route::get('get-kota/{provID}', [LocationController::class, 'getKota']);
Route::get('get-kecamatan/{kotaID}', [LocationController::class, 'getKecamatan']);
Route::get('get-kelurahan/{kecID}', [LocationController::class, 'getKelurahan']);


/*
|--------------------------------------------------------------------------
| Template Message
|--------------------------------------------------------------------------
|
*/

Route::get('/templatemessage', [TemplateMessageController::class,'index'])->name('templatemessage')->middleware('auth');
Route::get('/templatemessage/form/{id}', [TemplateMessageController::class,'Form'])->name('templatemessage-form')->middleware('auth');
Route::post('/templatemessage/store', [TemplateMessageController::class, 'store'])->name('templatemessage-store')->middleware('auth');
Route::post('/templatemessage/edit', [TemplateMessageController::class, 'edit'])->name('templatemessage-edit')->middleware('auth');
Route::delete('/templatemessage/delete/{id}', [TemplateMessageController::class, 'destroy'])->name('templatemessage-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Informasi Sekolah
|--------------------------------------------------------------------------
|
*/

Route::get('/informasisekolah', [InformasiSekolahController::class,'index'])->name('informasisekolah')->middleware('auth');
Route::post('/informasisekolah/edit', [InformasiSekolahController::class, 'edit'])->name('informasisekolah-edit')->middleware('auth');