<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categoria;
Use App\Models\Bitacora;

class CategoriaController extends Controller
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
        $this->authorize('viewAny', Categoria::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $datos = Categoria::busqueda($vbusqueda)->orderBy('categoria', 'asc')->paginate(20);
    
        return view('categorias.lista',compact('page', 'vbusqueda', 'datos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Categoria::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('categorias.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Categoria::class);

        $request->validate([
            'descripcion' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevo = new Categoria();
        $nuevo->categoria = $request->descripcion;
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Categoría agregada correctamente con id:'.$nuevo->idcatgoria;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/categorias?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Categoría agregada correctamente!');
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
        $modelo = Categoria::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $datos = Categoria::findOrFail($id);
        
        return view('categorias.editar',compact('page', 'vbusqueda', 'datos'));
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
        $modelo = Categoria::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'descripcion' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualiza = Categoria::findOrFail($id);
        $actualiza->categoria = $request->descripcion;
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Categoría editada correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/categorias?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Categoría editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Categoria::findOrFail($id);
        $this->authorize('delete', $modelo);

        $elimina = Categoria::findOrFail($id);
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Categoría eliminada correctamente con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Categoría eliminada correctamente!');
    }
}
