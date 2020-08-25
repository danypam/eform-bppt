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

use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'preventBackHistory', 'web'])
    ->name('formbuilder::')
    ->group(function () {
        Route::redirect('/', url(config('formbuilder.url_path', '/form-builder').'/forms'));

        /**
         * Public form url
         */
        Route::get('/form/{identifier}', 'RenderFormController@render')->name('form.render');
        Route::post('/form/{identifier}', 'RenderFormController@submit')->name('form.submit');
        Route::get('/form/{identifier}/feedback', 'RenderFormController@feedback')->name('form.feedback');

        /**
         * My submission routes
         */
        Route::resource('/my-submissions', 'MySubmissionController');

        /**
         * Form submission management routes
         */
        Route::name('forms.')
            ->prefix('/forms/{fid}')
            ->group(function () {
                Route::resource('/submissions', 'SubmissionController');
            });

        /**
         * Form management routes
         */
        Route::resource('/forms', 'FormController');
    });




// Route::get('/', function() {
//     return cas()->authenticate();
// })->name('cas.login');
// Route::get('/cas/callback', 'Auth\CasController@callback')->name('cas.callback');
// Route::post('/cas/logout', [ 'middleware' => 'cas.auth', function() {
// //    cas()->logout();
// //    cas()->logout(url('/'));
//     cas()->logout('', url('/'));
//     Auth::logout();
// }])->name('cas.logout');







//AKSES LOGIN TANPA CAS
Route::get('/', function () {
   return view('/auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard','DashboardController@index');
Route::get('/login','AuthController@login')->name('login');
Route::post('/postlogin','AuthController@postlogin');
Route::get('/logout','AuthController@logout');

Route::group(['middleware' => ['auth', 'preventBackHistory']], function() {



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

    Route::get('/log','LogController@index');
    Route::get('/log/{id}/delete','LogController@delete');

    Route::resource('/formulir', 'FormulirController');

    Route::resource('/inbox', 'InboxController');
    Route::post('/submissions/approve','InboxController@approve');
//    Route::post('/submissions/{id}/reject','InboxController@reject');

    Route::get('/dashboard','DashboardController@index');
//    Route::get('/{id}/profile','PegawaiController@profile');

    Route::get('/forms_pdf','ExportController@forms_pdf');
    Route::get('/{id}/submission_pdf','ExportController@submission_pdf');

    Route::resource('/task', 'PicController');
    Route::get('/task/{form_id}/submissions/{submission_id}','PicController@showForm');
    Route::get('/task/{form_id}/submissions/{submission_id}/task_pdf','ExportController@task_pdf');

    Route::get('/task/{id}/take','PicController@take');
    Route::get('/task/{id}/cancel','PicController@cancel');
    Route::post('/task/complete','PicController@complete');

    Route::get('/getTable','FormController@getTable');
    Route::get('/getColumn/{tableName}','FormController@getColumn');

});
    Route::post('/notification/get','NotifikasiController@get');
    Route::post('/notification/read','NotifikasiController@read');
    Route::get('/submission/{id?}','NotifikasiController@show');
    Route::post('/rating/new','RatingController@setrating')->name('setrating');
