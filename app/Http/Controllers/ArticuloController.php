<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Articulo;
Use App\Models\Bitacora;

class ArticuloController extends Controller
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
        $this->authorize('viewAny', Articulo::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $articulos = Articulo::busqueda($vbusqueda)->orderBy('articulo', 'asc')->paginate(10);
    
        return view('articulos.lista',compact('page', 'vbusqueda', 'articulos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Articulo::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('articulos.crear', compact('page', 'vbusqueda'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Articulo::class);

        $request->validate([
            'articulo' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevoarticulo = new Articulo();
        $nuevoarticulo->articulo = $request->articulo;
        if(isset($request->dato)){
            $nuevoarticulo->dato = 1;
        }
        else{
            $nuevoarticulo->dato = null;
        }
        if(isset($request->raiz)){
            $nuevoarticulo->raiz = 1;
        }
        else{
            $nuevoarticulo->raiz = null;
        }
        $nuevoarticulo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo artículo con id:'.$nuevoarticulo->idarticulo;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/articulos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Artículo agregado correctamente!');
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
        $modelo = Articulo::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $articulos = Articulo::findOrFail($id);
        
        return view('articulos.editar',compact('page', 'vbusqueda', 'articulos'));
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
        $modelo = Articulo::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'articulo' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualizaarticulo = Articulo::findOrFail($id);
        $actualizaarticulo->articulo = $request->articulo;
        if(isset($request->dato)){
            $actualizaarticulo->dato = 1;
        }
        else{
            $actualizaarticulo->dato = null;
        }
        if(isset($request->raiz)){
            $actualizaarticulo->raiz = 1;
        }
        else{
            $actualizaarticulo->raiz = null;
        }
        $actualizaarticulo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del artículo con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/articulos?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Artículo editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Articulo::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminaarticulo = Articulo::findOrFail($id);
        $eliminaarticulo->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del artículo con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Artículo eliminado correctamente!');
    }
}
