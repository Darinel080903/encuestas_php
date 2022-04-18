<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Pemexfactura;
use App\Models\Pemexdesglose;
use App\Models\Bitacora;

class PemexfacturaController extends Controller
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
        $this->authorize('viewAny', Pemexfactura::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador') OR $usuariorole->hasRole('supervisor'))
        {
            $datos = Pemexfactura::fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idfactura')->paginate(20);
        }
        else
        {
            $datos = Pemexfactura::usuario($usuario)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idfactura')->paginate(20);
        }

        return view('pemexfacturas.lista', compact('page', 'vfecha', 'vbusqueda', 'datos'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Pemexfactura::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        return view('pemexfacturas.crear', compact('page', 'vfecha', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Pemexfactura::class);

        $request->validate([
            'fecha' => 'required',
            'numero' => 'required',
            'proveedor' => 'required'
        ]);
        
        $nuevo = new Pemexfactura();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevo->fecha = $fechaformat;
        $nuevo->numero = $request->numero;
        $nuevo->proveedor = $request->proveedor;
        $monto = str_replace(',', "", $request->monto);
        $nuevo->monto = $monto;
        // if($request->pago){
        //     $pagoformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->pago)));
        //     $nuevo->pago = $pagoformat;
        // }
        $nuevo->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $nuevo->activo = 1;
        }
        else
        {
            $nuevo->activo = 0;
        }
        $nuevo->save();

        $desglose = json_decode($request->vdetalle);

        if($desglose)
        {
            foreach ($desglose as $item)
            {                
                $agregar = new Pemexdesglose();
                $agregar->fkfactura= $nuevo->idfactura;
                $agregar->numero = $item->numero;
                $agregar->concepto = $item->concepto;
                $agregar->unitario = $item->unitario;
                $agregar->monto = $item->monto;
                $agregar->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Donación agregada con id:'.$nuevo->idfactura;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/pemexfacturas?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Donación agregada correctamente!');
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
        $modelo = Pemexfactura::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Pemexfactura::findOrFail($id);
        }
        else
        {
            $datos = Pemexfactura::where('fkusuario', $usuario)->findOrFail($id);
        }
        $desgloses = Pemexdesglose::where('fkfactura', $id)->orderby('iddesglose', 'asc')->get();

        return view('pemexfacturas.editar',compact('page', 'vfecha', 'vbusqueda', 'datos', 'desgloses'));
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
        $modelo = Pemexfactura::findOrFail($id);
        $this->authorize('update', $modelo);
        
        $request->validate([
            'fecha' => 'required',
            'numero' => 'required',
            'proveedor' => 'required'
        ]);
    
        $actualiza = Pemexfactura::findOrFail($id);
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $actualiza->fecha = $fechaformat;
        $actualiza->numero = $request->numero;
        $actualiza->proveedor = $request->proveedor;
        $monto = str_replace(',', "", $request->monto);
        $actualiza->monto = $monto;
        // if($request->pago){
        //     $pagoformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->pago)));
        //     $actualiza->pago = $pagoformat;
        // }
        if(isset($request->activo))
        {
            $actualiza->activo = 1;
        }
        else
        {
            $actualiza->activo = 0;
        }
        $actualiza->save();

        $desglose = json_decode($request->vdetalle);

        $eliminadesglose = Pemexdesglose::where('fkfactura', $id);
        $eliminadesglose->delete();

        if($desglose)
        {
            foreach ($desglose as $item)
            {                
                $agregar = new Pemexdesglose();
                $agregar->fkfactura= $id;
                $agregar->numero = $item->numero;
                $agregar->concepto = $item->concepto;
                $agregar->unitario = $item->unitario;
                $agregar->monto = $item->monto;
                $agregar->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Donación editada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/pemexfacturas?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Donación editada correctamente!');
    }

    public function update2(Request $request, $id)
    {
        $modelo = Pemexfactura::findOrFail($id);
        $this->authorize('update', $modelo);
        
        $actualiza = Pemexfactura::findOrFail($id);
        if(isset($request->activo))
        {
            $actualiza->activo = 1;
        }
        else
        {
            $actualiza->activo = 0;
        }
        $actualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $bitacora->operacion = 'Donación activada con id:'.$id;
        }
        else
        {
            $bitacora->operacion = 'Donación desactivada con id:'.$id;
        }
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', '¡Donación activada correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', '¡Donación desactivada correctamente!');
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
        $modelo = Pemexfactura::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminadesglose = Pemexdesglose::where('fkfactura', $id);
        $eliminadesglose->delete();

        $elimina = Pemexfactura::findOrFail($id);    
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Factura eliminada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Factura eliminada correctamente!');
    }
}