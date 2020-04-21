<?php

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
use Illuminate\Support\Facades\Storage;
use App\Category;
use Carbon\Carbon;


Route::get('/excel/',"HomeController@index")->name('importAndSaveDb');
Route::post('excel/import', 'HomeController@import')->name('import');
Route::get('excel/import','HomeController@deneme');

Route::get('/', function () {

    return view('welcome');
});



Route::get('/veriekle', function () {

    $kategori= new Category;
    $kategori->category_name="toyota";
    $kategori->parent_id=1;
    $kategori->save();


    return view('welcome');
});