<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Puesto;
use App\Models\Bitacora;

class CatalogoController extends Controller
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
        $vtabla = $request->vtabla;
        $vdescripcion = $request->vdescripcion;
        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        if($vtabla == 'articulos'){
            $catalogos = Articulo::busqueda($vbusqueda)->orderBy('articulo')->paginate(10);
        }
        elseif($vtabla == 'marcas'){
            $catalogos = Marca::busqueda($vbusqueda)->orderBy('marca')->paginate(10);
        }
        elseif($vtabla == 'categorias'){
            $catalogos = Categoria::busqueda($vbusqueda)->orderBy('categoria')->paginate(10);
        }
        elseif($vtabla == 'puestos'){
            $catalogos = Puesto::busqueda($vbusqueda)->orderBy('puesto')->paginate(10);
        }
        
        return view('catalogos.lista',compact('vtabla', 'vdescripcion', 'page', 'vbusqueda', 'catalogos'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vtabla = $request->vtabla;
        $vdescripcion = $request->vdescripcion;
        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('catalogos.crear', compact('vtabla', 'vdescripcion', 'page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required'
        ]);

        $vtabla = $request->vtabla;
        $vdescripcion = $request->vdescripcion;
        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        if($vtabla == 'articulos'){
            $catalogo = new Articulo();
            $catalogo->articulo = $request->descripcion;    
        }
        elseif($vtabla == 'marcas'){
            $catalogo = new Marca();
            $catalogo->marca = $request->descripcion;    
        }
        elseif($vtabla == 'categorias'){
            $catalogo = new Categoria();
            $catalogo->categoria = $request->descripcion;    
        }
        elseif($vtabla == 'puestos'){
            $catalogo = new Puesto();
            $catalogo->puesto = $request->descripcion;    
        }
        
        $catalogo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        
        if($vtabla == 'articulos'){
            $bitacora->operacion = 'Nuevo artículo con id:'.$catalogo->idarticulo;
        }
        elseif($vtabla == 'marcas'){
            $bitacora->operacion = 'Nueva marca con id:'.$catalogo->idmarca;
        }
        elseif($vtabla == 'categorias'){
            $bitacora->operacion = 'Nueva categoría con id:'.$catalogo->idcategoria;
        }
        elseif($vtabla == 'puestos'){
            $bitacora->operacion = 'Nuevo puesto con id:'.$catalogo->idpuesto;
        }
        
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if($vtabla == 'articulos'){
            $mensaje = '¡Nuevo artículo agregado correctamente!';
        }
        elseif($vtabla == 'marcas'){
            $mensaje = '¡Nueva marca agregada correctamente!';
        }
        elseif($vtabla == 'categorias'){
            $mensaje = '¡Nueva categoría agregada correctamente!';
        }
        elseif($vtabla == 'puestos'){
            $mensaje = '¡Nuevo puesto agregado correctamente!';
        }
        
        return redirect('/catalogos?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje',$mensaje);
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
        $vtabla = $request->vtabla;
        $vdescripcion = $request->vdescripcion;
        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        if($vtabla == 'articulos'){
            $catalogos = Articulo::findOrFail($id);
        }
        elseif($vtabla == 'marcas'){
            $catalogos = Marca::findOrFail($id);
        }
        elseif($vtabla == 'categorias'){
            $catalogos = Categoria::findOrFail($id);
        }
        elseif($vtabla == 'puestos'){
            $catalogos = Puesto::findOrFail($id);
        }
    
        return view('catalogos.editar',compact('vtabla', 'vdescripcion', 'page', 'vbusqueda', 'catalogos'));
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
        $request->validate([
            'descripcion' => 'required'
        ]);

        $vtabla = $request->vtabla;
        $vdescripcion = $request->vdescripcion;
        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        if($vtabla == 'articulos'){
            $CatalogosActualiza = Articulo::findOrFail($id);
            $CatalogosActualiza->articulo = $request->descripcion;
        }
        elseif($vtabla == 'marcas'){
            $CatalogosActualiza = Marca::findOrFail($id);
            $CatalogosActualiza->marca = $request->descripcion;
        }
        elseif($vtabla == 'categorias'){
            $CatalogosActualiza = Categoria::findOrFail($id);
            $CatalogosActualiza->categoria = $request->descripcion;
        }
        elseif($vtabla == 'puestos'){
            $CatalogosActualiza = Puesto::findOrFail($id);
            $CatalogosActualiza->puesto = $request->descripcion;
        }

        $CatalogosActualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        
        if($vtabla == 'articulos'){
            $bitacora->operacion = 'Edición del artículo con id:'.$id;
        }
        elseif($vtabla == 'marcas'){
            $bitacora->operacion = 'Edición de la marca con id:'.$id;
        }
        elseif($vtabla == 'categorias'){
            $bitacora->operacion = 'Edición de la categoría con id:'.$id;
        }
        elseif($vtabla == 'puestos'){
            $bitacora->operacion = 'Edición del puesto con id:'.$id;
        }
    
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if($vtabla == 'articulos'){
            $mensaje = '¡Artículo editado correctamente!';
        }
        elseif($vtabla == 'marcas'){
            $mensaje = '¡Marca editada correctamente!';
        }
        elseif($vtabla == 'categorias'){
            $mensaje = '¡Categoría editada correctamente!';
        }
        elseif($vtabla == 'puestos'){
            $mensaje = '¡Puesto editado correctamente!';
        }
    
        return redirect('/catalogos?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje',$mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $vtabla = $request->vtabla;
    
        if($vtabla == 'articulos'){
            $CatalogoEliminar = Articulo::findOrFail($id);
        }
        elseif($vtabla == 'marcas'){
            $CatalogoEliminar = Marca::findOrFail($id);
        }
        elseif($vtabla == 'categorias'){
            $CatalogoEliminar = Categoria::findOrFail($id);
        }
        elseif($vtabla == 'puestos'){
            $CatalogoEliminar = Puesto::findOrFail($id);
        }
        
        $CatalogoEliminar->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        
        if($vtabla == 'articulos'){
            $bitacora->operacion = 'Eliminación del artículo con id:'.$id;
        }
        elseif($vtabla == 'marcas'){
            $bitacora->operacion = 'Eliminación de la marca con id:'.$id;
        }
        elseif($vtabla == 'categorias'){
            $bitacora->operacion = 'Eliminación de la categoría con id:'.$id;
        }
        elseif($vtabla == 'puestos'){
            $bitacora->operacion = 'Eliminación del puesto con id:'.$id;
        }

        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if($vtabla == 'articulos'){
            $mensaje = '¡Artículo eliminado correctamente!';
        }
        elseif($vtabla == 'marcas'){
            $mensaje = '¡Marca eliminada correctamente!';
        }
        elseif($vtabla == 'categorias'){
            $mensaje = '¡Categoría eliminada correctamente!';
        }
        elseif($vtabla == 'puestos'){
            $mensaje = '¡Puesto eliminado correctamente!';
        }
    
        return back()->withInput()->with('mensaje', $mensaje);
    }
}