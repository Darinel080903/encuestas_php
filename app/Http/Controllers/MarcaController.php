<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Marca;
Use App\Models\Bitacora;

class MarcaController extends Controller
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
        $this->authorize('viewAny', Marca::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $datos = Marca::busqueda($vbusqueda)->orderBy('marca', 'asc')->paginate(20);
    
        return view('marcas.lista',compact('page', 'vbusqueda', 'datos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Marca::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('marcas.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Marca::class);

        $request->validate([
            'descripcion' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Marca();
        $nuevo->marca = $request->descripcion;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Marca agregada correctamente con id:'.$nuevo->idmarca;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/marcas?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Marca agregada correctamente!');
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
        $modelo = Marca::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $datos = Marca::findOrFail($id);
        
        return view('marcas.editar',compact('page', 'vbusqueda', 'datos'));
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
        $modelo = Marca::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'descripcion' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Marca::findOrFail($id);
        $actualiza->marca = $request->descripcion;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Marca editada correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/marcas?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Marca editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Marca::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Marca::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Marca eliminada correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Marca eliminada correctamente!');
    }
}
