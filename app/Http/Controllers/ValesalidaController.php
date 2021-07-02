<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Articulo;
use App\Models\Funcionario;
use App\Models\Vresguardo;
use App\Models\Area;
use App\Models\Marca;
use App\Models\Bien;
use App\Models\Vsalida;
use Carbon\Carbon;

class ValesalidaController extends Controller
{

    // By CIRG - Protejer la ruta.
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Vsalida::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $articulos = Articulo::busqueda($vbusqueda)->orderBy('articulo', 'asc')->paginate(10);
        $detalles = Marca::busqueda($vbusqueda)->orderBy('marca', 'asc')->paginate(10); 
        $areas = Area::all();
        // $areas = Area::orderBy('area', 'asc')->get();
        // $funcionarios = Funcionario::busqueda($vbusqueda)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->paginate(10);
            
        return view('valesalidas.valesalida',compact('page','vfecha', 'vbusqueda', 'areas','articulos', 'detalles'));
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vsalida::class);

        // $carbon = new Carbon(); 

        // dd($carbon);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $funcionarios = Funcionario::orderBy('nombre', 'asc')->get();
        
        return view('valesalidas.crear', compact('page', 'vfecha', 'vbusqueda', 'funcionarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
