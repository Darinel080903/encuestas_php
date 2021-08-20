<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Puesto;
Use App\Models\Bitacora;

class PuestoController extends Controller
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
        $this->authorize('viewAny', Puesto::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $datos = Puesto::busqueda($vbusqueda)->orderBy('puesto', 'asc')->paginate(20);
    
        return view('puestos.lista',compact('page', 'vbusqueda', 'datos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Puesto::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('puestos.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Puesto::class);

        $request->validate([
            'descripcion' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Puesto();
        $nuevo->puesto = $request->descripcion;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Puesto agregado correctamente con id:'.$nuevo->idpuesto;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/puestos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Puesto agregado correctamente!');
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
        $modelo = Puesto::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $datos = Puesto::findOrFail($id);
        
        return view('puestos.editar',compact('page', 'vbusqueda', 'datos'));
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
        $modelo = Puesto::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'descripcion' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Puesto::findOrFail($id);
        $actualiza->puesto = $request->descripcion;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Puesto editado correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/puestos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Puesto editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Puesto::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Puesto::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Puesto eliminado correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Puesto eliminado correctamente!');
    }
}
