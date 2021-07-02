<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Fabrica;
use App\Models\Tipo;
use App\Models\Vtipo;
Use App\Models\Bitacora;

use Illuminate\Http\Request;

class TipoController extends Controller
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
        $this->authorize('viewAny', Vtipo::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $tipos = Vtipo::busqueda($vbusqueda)->orderBy('tipo', 'asc')->paginate(20);
    
        return view('tipos.lista',compact('page', 'vbusqueda', 'tipos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vtipo::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $fabricas = Fabrica::all();

        return view('tipos.crear', compact('page', 'vbusqueda', 'fabricas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vtipo::class);

        $request->validate([
            'fabrica' => 'required',
            'tipo' => 'required',
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Tipo();
        $nuevo->fkfabrica = $request->fabrica;
        $nuevo->tipo = $request->tipo;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Tipo agrgado con id:'.$nuevo->idtipo;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/tipos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Tipo agregado correctamente!');
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
        $modelo = Vtipo::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $fabricas = Fabrica::all();
        $tipos = Tipo::findOrFail($id);
        
        return view('tipos.editar',compact('page', 'vbusqueda', 'fabricas', 'tipos'));
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
        $modelo = Vtipo::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'fabrica' => 'required',
            'tipo' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Tipo::findOrFail($id);
        $actualiza->fkfabrica = $request->fabrica;
        $actualiza->tipo = $request->tipo;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Tipo editado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/tipos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Tipo editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Vtipo::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Tipo::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Tipo eliminado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Tipo eliminado correctamente!');
    }
}
