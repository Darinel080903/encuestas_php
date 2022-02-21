<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
use App\Models\Partida;
Use App\Models\Bitacora;

class PartidaController extends Controller
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
        $this->authorize('viewAny', Partida::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
               
        $partidas = Partida::busqueda($vbusqueda)->orderBy('partida', 'asc')->paginate(20);
    
        return view('partidas.lista',compact('page', 'vbusqueda', 'partidas')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Partida::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;        
        
        $partidas = Partida::orderBy('partida', 'asc')->get();        

        return view('partidas.crear', compact('page', 'vbusqueda', 'partidas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Partida::class);

        $request->validate([
            'clave' => 'required',
            'partida' => 'required'            
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevapartida = new Partida();
        $nuevapartida->clave = $request->clave;
        $nuevapartida->partida = $request->partida;                
        if(isset($request->activo))
        {
            $nuevapartida->activo = 1;
        }
        else
        {
            $nuevapartida->activo = 0;
        }        
        $nuevapartida->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo proveedor con id:'.$nuevapartida->idpartida;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/partidas?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Partida agregada correctamente!');
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
        $modelo = Partida::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $partidas = Partida::findOrFail($id);
                
        return view('partidas.editar',compact('page', 'vbusqueda','partidas'));
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
        $modelo = Partida::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'clave' => 'required',
            'partida' => 'required' 
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualizapartida = Partida::findOrFail($id);
        $actualizapartida->clave = $request->clave;
        $actualizapartida->partida = $request->partida;        
        if(isset($request->activo))
        {
            $actualizapartida->activo = 1;
        }
        else
        {
            $actualizapartida->activo = 0;
        }
        $actualizapartida->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición de la partida con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/partidas?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Partida editada correctamente!');
    }

    public function update2(Request $request, $id)
    {
         
        $actualizapartida = Partida::findOrFail($id);
        if(isset($request->activo))
        {
            $actualizapartida->activo = 1;
        }
        else
        {
            $actualizapartida->activo = 0;
        }
        $actualizapartida->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $bitacora->operacion = 'Partida activada correctamente con id:'.$id;
        }
        else
        {
            $bitacora->operacion = 'Partida desactivada correctamente con id:'.$id;
        }
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', 'Partida activada correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', 'Partida desactivada correctamente!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Partida::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminapartida = Partida::findOrFail($id);
        $eliminapartida->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación de la partida con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Partida eliminada correctamente!');
    }
}
