<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Inmueble;
Use App\Models\Bitacora;

class InmuebleController extends Controller
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
        $this->authorize('viewAny', Inmueble::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $inmuebles = Inmueble::busqueda($vbusqueda)->orderBy('inmueble', 'asc')->paginate(20);
    
        return view('inmuebles.lista',compact('page', 'vbusqueda', 'inmuebles')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Inmueble::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('inmuebles.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Inmueble::class);

        $request->validate([
            'inmueble' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Inmueble();
        $nuevo->inmueble = $request->inmueble;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Inmueble agregado correctamente con id:'.$nuevo->idinmueble;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/inmuebles?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Inmueble agregado correctamente!');
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
        $modelo = Inmueble::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $inmuebles = Inmueble::findOrFail($id);
        
        return view('inmuebles.editar',compact('page', 'vbusqueda', 'inmuebles'));
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
        $modelo = Inmueble::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'inmueble' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Inmueble::findOrFail($id);
        $actualiza->inmueble = $request->inmueble;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Inmueble editado correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/inmuebles?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Inmueble editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Inmueble::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Inmueble::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Inmueble eliminado correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Inmueble eliminado correctamente!');
    }
}
