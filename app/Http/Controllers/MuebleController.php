<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mueble;
Use App\Models\Bitacora;

class MuebleController extends Controller
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
        $this->authorize('viewAny', Mueble::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $muebles = Mueble::busqueda($vbusqueda)->orderBy('mueble', 'asc')->paginate(20);
    
        return view('muebles.lista',compact('page', 'vbusqueda', 'muebles')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        $this->authorize('create', Mueble::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('muebles.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Mueble::class);

        $request->validate([
            'mueble' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Mueble();
        $nuevo->mueble = $request->mueble;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Mueble agregado correctamente con id:'.$nuevo->idmueble;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/muebles?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Mueble agregado correctamente!');
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
        $modelo = Mueble::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $muebles = Mueble::findOrFail($id);
        
        return view('muebles.editar',compact('page', 'vbusqueda', 'muebles'));
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
        $modelo = Mueble::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'mueble' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Mueble::findOrFail($id);
        $actualiza->mueble = $request->mueble;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Mueble editado correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/muebles?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Mueble editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Mueble::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Mueble::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Mueble eliminado correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Mueble eliminado correctamente!');
    }
}
