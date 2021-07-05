<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});

Route::get('/form',[Controller::class,'index'])->middleware('auth')->name('form');
Route::post('/form', [Controller::class,'store'])->name('form.post');
Route::get('/upload',[Controller::class,'showForm']);
Route::post('/upload',[Controller::class,'uploadFiles'])->name('form.upload');

Route::get('/login',[Controller::class,'login'])->name('lo');
// Route::post('/login',[Controller::class,'postLogin'])->name('login');

Route::get('/home',[Controller::class,'home'])->middleware('auth')->name('home');
Route::get('/admin',[Controller::class,'admin'])->middleware('auth','auth.admin')->name('admin');
Route::get('/logout',[Controller::class,'logout'])->name('logout');
Route::get('/setcookie',[Controller::class,'setCookie']);
Route::get('/getcookie',[Controller::class,'getCookie']);

Route::post('/login',[Controller::class,'postLogin1'])->name('login1');

