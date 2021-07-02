<?php

use Illuminate\Support\Facades\Route;
//use App \ Http \ Controllers \ PDFController ;

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/usuarios', 'App\Http\Controllers\UsuarioController');

Route::resource('/roles', 'App\Http\Controllers\RoleController');

Route::resource('/catalogos', 'App\Http\Controllers\CatalogoController');

Route::resource('/operativos', 'App\Http\Controllers\OperativoController');

Route::resource('/articulos', 'App\Http\Controllers\ArticuloController');

Route::resource('/areas', 'App\Http\Controllers\AreaController');

Route::put('areas/{area}/update2', 'App\Http\Controllers\AreaController@update2');

Route::resource('/funcionarios', 'App\Http\Controllers\FuncionarioController');

Route::put('funcionarios/{funcionario}/update2', 'App\Http\Controllers\FuncionarioController@update2');

Route::resource('/cedulas', 'App\Http\Controllers\CedulaController');

Route::resource('/bienes', 'App\Http\Controllers\BienController');

Route::get('bienes/campos/{id}', 'App\Http\Controllers\AjaxController@cargarcampos');

Route::get('bienes/agregar', 'App\Http\Controllers\AjaxController@cargarcampos');

Route::put('bienes/{funcionario}/update2', 'App\Http\Controllers\BienController@update2');

Route::get('savetmp', 'App\Http\Controllers\AjaxController@tmpguardarbien');

Route::get('eliminatmpbien/{id}', 'App\Http\Controllers\AjaxController@eliminartmpbien'); // aumento

Route::get('limpiatmpbien', 'App\Http\Controllers\AjaxController@limpiartmpbien'); // aumento

Route::get('resguardo/funcionario/{id}', 'App\Http\Controllers\PDFController@pdfresguardofuncionario');

Route::resource('/resguardos', 'App\Http\Controllers\ResguardoController');

Route::resource('/valesalidas', 'App\Http\Controllers\valesalidaController');

//Route::get('/valesalida', 'App\Http\Controllers\valesalidaController');

Route::resource('/fabricas', 'App\Http\Controllers\FabricaController');

Route::resource('/tipos', 'App\Http\Controllers\TipoController');

Route::resource('/transmisiones', 'App\Http\Controllers\TransmisionController');

Route::resource('/combustibles', 'App\Http\Controllers\CombustibleController');

Route::resource('/autos', 'App\Http\Controllers\AutoController');

Route::get('/autos/fabrica/{id}', 'App\Http\Controllers\AjaxController@cargartipos');

Route::put('/autos/{id}/update2', 'App\Http\Controllers\AutoController@update2');

Route::resource('/autosimgs', 'App\Http\Controllers\AutoimgController');

Route::resource('/facturas', 'App\Http\Controllers\FacturaController');