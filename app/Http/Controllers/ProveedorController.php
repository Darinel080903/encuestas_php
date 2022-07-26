<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
use App\Models\Proveedor;
Use App\Models\Bitacora;

class ProveedorController extends Controller
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
        $this->authorize('viewAny', Proveedor::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        
        //$proveedores = Proveedor::orderBy('proveedor', 'asc')->get();
        $proveedores = Proveedor::busqueda($vbusqueda)->orderBy('proveedor', 'asc')->paginate(20);
    
        return view('proveedores.lista',compact('page', 'vbusqueda', 'proveedores')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Proveedor::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;        
        
        $proveedores = Proveedor::orderBy('proveedor', 'asc')->get();        

        return view('proveedores.crear', compact('page', 'vbusqueda', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Proveedor::class);

        $request->validate([
            'proveedor' => 'required',
            'rfc' => 'required',
            'homoclave' => 'required'           
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevoproveedor = new Proveedor();
        $nuevoproveedor->proveedor = $request->proveedor;
        $nuevoproveedor->domicilio = $request->domicilio;
        $nuevoproveedor->rfc = $request->rfc;
        $nuevoproveedor->homoclave = $request->homoclave;        
        $nuevoproveedor->curp = $request->curp;
        if(isset($request->activo))
        {
            $nuevoproveedor->activo = 1;
        }
        else
        {
            $nuevoproveedor->activo = 0;
        }        
        $nuevoproveedor->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo proveedor con id:'.$nuevoproveedor->idproveedor;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/proveedores?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Proveedor agregado correctamente!');
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
        $modelo = Proveedor::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $proveedores = Proveedor::findOrFail($id);
                
        return view('proveedores.editar',compact('page', 'vbusqueda','proveedores'));
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
        $modelo = Proveedor::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'proveedor' => 'required',
            'rfc' => 'required',
            'homoclave' => 'required'  
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualizaproveedor = Proveedor::findOrFail($id);
        $actualizaproveedor->proveedor = $request->proveedor;
        $actualizaproveedor->domicilio = $request->domicilio;
        $actualizaproveedor->rfc = $request->rfc;
        $actualizaproveedor->homoclave = $request->homoclave;        
        $actualizaproveedor->curp = $request->curp;
        if(isset($request->activo))
        {
            $actualizaproveedor->activo = 1;
        }
        else
        {
            $actualizaproveedor->activo = 0;
        }
        $actualizaproveedor->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del proveedor con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/proveedores?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Proveedor editado correctamente!');
    }

    public function update2(Request $request, $id)
    {
         
        $actualizaproveedor = Proveedor::findOrFail($id);
        if(isset($request->activo))
        {
            $actualizaproveedor->activo = 1;
        }
        else
        {
            $actualizaproveedor->activo = 0;
        }
        $actualizaproveedor->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $bitacora->operacion = 'Proveedor activado correctamente con id:'.$id;
        }
        else
        {
            $bitacora->operacion = 'Proveedor desactivado correctamente con id:'.$id;
        }
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', 'Proveedor activado correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', 'Proveedor desactivado correctamente!');
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
        $modelo = Proveedor::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminaproveedor = Proveedor::findOrFail($id);
        $eliminaproveedor->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del proveedor con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Proveedor eliminado correctamente!');
    }
}
