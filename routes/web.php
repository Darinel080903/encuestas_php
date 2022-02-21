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

Route::resource('/roles', 'App\Http\Controllers\RoleController');

Route::resource('/usuarios', 'App\Http\Controllers\UsuarioController');

Route::resource('/catalogos', 'App\Http\Controllers\CatalogoController');

Route::resource('/articulos', 'App\Http\Controllers\ArticuloController');

Route::resource('/marcas', 'App\Http\Controllers\MarcaController');

Route::resource('/operativos', 'App\Http\Controllers\OperativoController');

Route::resource('/areas', 'App\Http\Controllers\AreaController');

Route::put('/areas/{area}/update2', 'App\Http\Controllers\AreaController@update2');

Route::resource('/categorias', 'App\Http\Controllers\CategoriaController');

Route::resource('/puestos', 'App\Http\Controllers\PuestoController');

Route::resource('/funcionarios', 'App\Http\Controllers\FuncionarioController');

Route::put('/funcionarios/{funcionario}/update2', 'App\Http\Controllers\FuncionarioController@update2');

Route::resource('/cedulas', 'App\Http\Controllers\CedulaController');

Route::resource('/fabricas', 'App\Http\Controllers\FabricaController');

Route::resource('/tipos', 'App\Http\Controllers\TipoController');

Route::resource('/transmisiones', 'App\Http\Controllers\TransmisionController');

Route::resource('/combustibles', 'App\Http\Controllers\CombustibleController');

Route::resource('/autos', 'App\Http\Controllers\AutoController');

Route::put('/autos/{id}/update2', 'App\Http\Controllers\AutoController@update2');

Route::get('/autos/fabrica/{id}', 'App\Http\Controllers\AjaxController@cargartipos');

Route::resource('/autosimgs', 'App\Http\Controllers\AutoimgController');

Route::resource('/bienes', 'App\Http\Controllers\BienController');

Route::put('/bienes/{funcionario}/update2', 'App\Http\Controllers\BienController@update2');

Route::put('/bienes/{idbien}/desasociar', 'App\Http\Controllers\BienController@desasociar');

Route::get('/bienes/campos/{id}', 'App\Http\Controllers\AjaxController@cargarcampos');

Route::get('/bienes/funcionarios/{id}', 'App\Http\Controllers\AjaxController@cargarfuncionarios');

Route::get('/bienes/agregar', 'App\Http\Controllers\AjaxController@cargarcampos');

Route::get('/bienes/inventario/{id}', 'App\Http\Controllers\AjaxController@cargarbien');

Route::get('/bienes/historico/{id}', 'App\Http\Controllers\HistoricoController@historico');

Route::get('savetmp', 'App\Http\Controllers\AjaxController@tmpguardarbien');

Route::get('eliminatmpbien/{id}', 'App\Http\Controllers\AjaxController@eliminartmpbien');

Route::get('limpiatmpbien', 'App\Http\Controllers\AjaxController@limpiartmpbien');

Route::resource('/resguardos', 'App\Http\Controllers\ResguardoController');

Route::get('/resguardos/imprimir/pdf', 'App\Http\Controllers\PDFController@pdfresguardo');

Route::resource('/pases', 'App\Http\Controllers\PaseController');

Route::get('/pases/imprimir/{id}', 'App\Http\Controllers\PDFController@pdfpase');

Route::resource('/facturas', 'App\Http\Controllers\FacturaController');

Route::put('/facturas/{id}/update2', 'App\Http\Controllers\FacturaController@update2');

Route::resource('/vales', 'App\Http\Controllers\ValegasController');

Route::get('/vales/autos/{idauto}', 'App\Http\Controllers\AjaxController@cargafuncionario');

Route::get('/vales/conceptos/{idfactura}', 'App\Http\Controllers\AjaxController@cargaconceptos');

Route::get('/vales/montos/{idfactura}', 'App\Http\Controllers\AjaxController@cargamontos');

Route::get('/vales/saldos/{idfactura}', 'App\Http\Controllers\AjaxController@cargasaldos');

Route::get('/vales/unidades/{iddesglose}', 'App\Http\Controllers\AjaxController@cargaunidades');

Route::get('/vales/unitarios/{iddesglose}', 'App\Http\Controllers\AjaxController@cargaunitarios');

Route::get('/imprimir/vale/{id}', 'App\Http\Controllers\PDFController@pdfvale');

Route::resource('/devoluciones', 'App\Http\Controllers\DevolucionController');

Route::get('/devoluciones/devolucion/{idfuncionario}', 'App\Http\Controllers\AjaxController@cargadevoluciones');

Route::get('/devoluciones/imprimir/pdf', 'App\Http\Controllers\PDFController@pdfdevolucion');

// Route::get('/devoluciones/imprimir/{idfuncionario}', 'App\Http\Controllers\PDFController@pdfdevolucion');

// Route::get('/resguardo/funcionario/{id}', 'App\Http\Controllers\PDFController@pdfresguardofuncionario');

Route::resource('/retornos', 'App\Http\Controllers\RetornoController');

Route::get('/retornos/bienes/{idfuncionario}', 'App\Http\Controllers\AjaxController@cargabienes');

Route::get('/retornos/imprimir/pdf', 'App\Http\Controllers\PDFController@pdfretorno');

Route::resource('/pemexfacturas', 'App\Http\Controllers\PemexfacturaController');

Route::put('/pemexfacturas/{id}/update2', 'App\Http\Controllers\PemexfacturaController@update2');

Route::resource('/pemexvales', 'App\Http\Controllers\PemexvaleController');

Route::get('/pemexvales/conceptos/{idfactura}', 'App\Http\Controllers\AjaxController@cargaconceptospemex');

Route::get('/pemexvales/montos/{idfactura}', 'App\Http\Controllers\AjaxController@cargamontospemex');

Route::get('/pemexvales/saldos/{idfactura}', 'App\Http\Controllers\AjaxController@cargasaldospemex');

Route::get('/pemexvales/unidades/{iddesglose}', 'App\Http\Controllers\AjaxController@cargaunidadespemex');

Route::get('/pemexvales/unitarios/{iddesglose}', 'App\Http\Controllers\AjaxController@cargaunitariospemex');

Route::get('/imprimir/pemexvale/{id}', 'App\Http\Controllers\PDFController@pdfpemexvale');

Route::resource('/proveedores', 'App\Http\Controllers\ProveedorController');

Route::put('/proveedores/{proveedor}/update2', 'App\Http\Controllers\ProveedorController@update2');

Route::resource('/partidas', 'App\Http\Controllers\PartidaController');

Route::put('/partidas/{partida}/update2', 'App\Http\Controllers\PartidaController@update2');