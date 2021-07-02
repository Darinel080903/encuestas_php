<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Fabrica;
Use App\Models\Bitacora;

class FabricaController extends Controller
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
        $this->authorize('viewAny', Fabrica::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $fabricas = Fabrica::busqueda($vbusqueda)->orderBy('fabrica', 'asc')->paginate(20);
    
        return view('fabricas.lista',compact('page', 'vbusqueda', 'fabricas')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Fabrica::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('fabricas.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Fabrica::class);

        $request->validate([
            'fabrica' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Fabrica();
        $nuevo->fabrica = $request->fabrica;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Fabrica agregada con id:'.$nuevo->idfabrica;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/fabricas?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Fabrica agregada correctamente!');
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
        $modelo = Fabrica::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $fabricas = Fabrica::findOrFail($id);
        
        return view('fabricas.editar',compact('page', 'vbusqueda', 'fabricas'));
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
        $modelo = Fabrica::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'fabrica' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Fabrica::findOrFail($id);
        $actualiza->fabrica = $request->fabrica;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Fabrica editada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/fabricas?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Fabrica editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Fabrica::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Fabrica::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Fabrica eliminada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Fabrica eliminada correctamente!');
    }
}
