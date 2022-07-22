<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Partida;
use App\Models\Area;
use App\Models\Clase;
use App\Models\Solicitud;
use App\Models\Vsolicitud;
use App\Models\User;
use App\Models\Bitacora;

class SolicitudController extends Controller
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
        $this->authorize('viewAny', Vsolicitud::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Vsolicitud::fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('folio')->paginate(20);
        }
        else
        {
            $datos = Vsolicitud::usuario($usuario)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('folio')->paginate(20);
        }

        return view('solicitudes.lista', compact('page', 'vfecha', 'vbusqueda', 'datos'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vsolicitud::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        // $usuario = auth()->user()->id;
        // $autos = Auto::whereNotNull('fkfuncionario')->where([['fkusuario', $usuario], ['fkorigen', 1], ['activo', 1]])->get();
        $partidas = Partida::where('activo', 1)->get();
        $areas = Area::where([['fkarea', null], ['activo', 1]])->get();
        $clases = Clase::orderBy('idclase', 'asc')->get();
        return view('solicitudes.crear', compact('page', 'vfecha', 'vbusqueda', 'partidas', 'areas'));
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