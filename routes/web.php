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

Route::get('/', function () {
    return view('/auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard','DashboardController@index');
Route::get('/login','AuthController@login');
Route::post('/postlogin','AuthController@postlogin');
Route::get('/logout','AuthController@logout');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/auth/ubahpass','AuthController@edit');
    Route::post('/auth/ubahpass/update','AuthController@update');

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::get('/users/{id}/delete','UserController@delete');
    Route::get('/users/{id}/deletee','UserController@deletee');
    Route::resource('products','ProductController');

    Route::get('/permission','PermissionController@index');
    Route::post('/permission/create','PermissionController@create');
    Route::get('/permission/{id}/edit','PermissionController@edit');
    Route::post('/permission/{id}/update','PermissionController@update');
    Route::get('/permission/{id}/delete','PermissionController@delete');

    Route::get('/jabatan','JabatanController@index');
    Route::post('/jabatan/create','JabatanController@create');
    Route::get('/jabatan/{id}/edit','JabatanController@edit');
    Route::post('/jabatan/{id}/update','JabatanController@update');
    Route::get('/jabatan/{id}/delete','JabatanController@delete');

    Route::get('/alamat','AlamatController@index');
    Route::post('/alamat/create','AlamatController@create');
    Route::get('/alamat/{id}/edit','AlamatController@edit');
    Route::post('/alamat/{id}/update','AlamatController@update');
    Route::get('/alamat/{id}/delete','AlamatController@delete');

    Route::get('/unit','UnitController@index');
    Route::post('/unit/create','UnitController@create');
    Route::get('/unit/{id}/edit','UnitController@edit');
    Route::post('/unit/{id}/update','UnitController@update');
    Route::get('/unit/{id}/delete','UnitController@delete');

    Route::get('/unitjab','UnitjabatanController@index');
    Route::post('/unitjab/create','UnitjabatanController@create');
    Route::get('/unitjab/{id}/edit','UnitjabatanController@edit');
    Route::post('/unitjab/{id}/update','UnitjabatanController@update');
    Route::get('/unitjab/{id}/delete','UnitjabatanController@delete');

    Route::get('/pegawai','PegawaiController@index');
    Route::post('/pegawai/create','PegawaiController@create');
    Route::get('/pegawai/{id}/profile','PegawaiController@profile');
    Route::get('/pegawai/{id}/edit','PegawaiController@edit');
    Route::post('/pegawai/{id}/update','PegawaiController@update');
    Route::get('/pegawai/{id}/delete','PegawaiController@delete');

    Route::get('/{id}/profile', 'UserController@profile');

    Route::resource('/formulir', 'FormulirController');

    Route::resource('/inbox', 'InboxController');
    Route::get('/submissions/{id}/approve','InboxController@approve');
    Route::get('/submissions/{id}/reject','InboxController@reject');

});
