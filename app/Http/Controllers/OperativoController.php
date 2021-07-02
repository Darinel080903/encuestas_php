<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Operativo;
use App\Models\Bitacora;

class OperativoController extends Controller
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
        $this->authorize('viewAny', Operativo::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $operativos = Operativo::busqueda($vbusqueda)->orderBy('operativo')->paginate(10);
    
        return view('operativos.lista',compact('page', 'vbusqueda', 'operativos'));   
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Operativo::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('operativos.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Operativo::class);

        $request->validate([
            'operativo' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $operativonuevo = new Operativo();
        $operativonuevo->operativo = $request->operativo;    
        $operativonuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo sistema operativo con id:'.$operativonuevo->idoperativo;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
    
        return redirect('/operativos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Nuevo sistema operativo agregado correctamente!');
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
    public function edit(Request $request, $id)
    {
        $modelo = Operativo::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
    
        $operativos = Operativo::findOrFail($id);
        
        return view('operativos.editar',compact('page', 'vbusqueda', 'operativos'));
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
        $modelo = Operativo::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'operativo' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $operativoactualiza = Operativo::findOrFail($id);
        $operativoactualiza->operativo = $request->operativo;
        $operativoactualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del sistema operativo con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
    
        return redirect('/operativos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje', '¡Sistema operativo editado correctamente!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Operativo::findOrFail($id);
        $this->authorize('delete', $modelo);

        $operativoeliminar = Operativo::findOrFail($id);
        $operativoeliminar -> delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del sistema operativo con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return back()->withInput()->with('mensaje', '¡Sistema operativo eliminado correctamente!');
    }
}
