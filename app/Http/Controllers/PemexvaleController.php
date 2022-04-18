<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vpemexvale;
use App\Models\Auto;
use App\Models\Vauto;
use App\Models\Pemexvale;
use App\Models\Pemexfactura;
use App\Models\Pemexfolio;
use App\Models\Vpemexfolio;
use App\Models\Pemexdesglose;
use App\Models\Funcionario;
use App\Models\Vfuncionariocustodia;
use App\Models\Bitacora;

class PemexvaleController extends Controller
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
        $this->authorize('viewAny', Vpemexvale::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vcomprobacion = $request->vcomprobacion;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador') OR $usuariorole->hasRole('supervisor'))
        {
            $datos = Vpemexvale::fecha($vfecha)->comprobacion($vcomprobacion)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idvale')->paginate(20);
        }
        else
        {
            $datos = Vpemexvale::usuario($usuario)->fecha($vfecha)->comprobacion($vcomprobacion)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idvale')->paginate(20);
        }

        return view('pemexvales.lista', compact('page', 'vfecha', 'vcomprobacion', 'vbusqueda', 'datos'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vpemexvale::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vcomprobacion = $request->vcomprobacion;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $autos = Auto::where([['fkorigen', 2], ['custodia', 1], ['activo', 1]])->orderby('placa', 'asc')->get();
            $facturas = Pemexfactura::where('activo', 1)->get(); 
        }
        else
        {
            $autos = Auto::where([['fkusuario', $usuario], ['fkorigen', 2], ['custodia', 1], ['activo', 1]])->orderby('placa', 'asc')->get();
            $facturas = Pemexfactura::where([['fkusuario', $usuario], ['activo', 1]])->get(); 
        }
         
        return view('pemexvales.crear', compact('page', 'vfecha', 'vcomprobacion', 'vbusqueda', 'autos', 'facturas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vpemexvale::class);

        $request->validate([
            'fecha' => 'required',
            'auto' => 'required',
            'funcionario' => 'required'
        ]);

        $folios = json_decode($request->vdetalle);

        if($folios)
        {
            foreach ($folios as $item)
            {   
                $numero = Pemexdesglose::where('iddesglose', $item->concepto)->value('numero');
                $unidades = Pemexfolio::where('fkdesglose', $item->concepto)->sum('numero');
                $disponible = $numero - $unidades;
                if($disponible < $item->numero)
                {
                    return redirect('/pemexvales?page='.$request->page.'&vfecha='.$request->vfecha.'&vcomprobacion='.$request->vcomprobacion.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error no se pudo realizar la operación, verifique las unidades disponibles!');
                }             
            }
        }

        $nuevo = new Pemexvale();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevo->fecha = $fechaformat;
        $nuevo->fkauto = $request->auto;
        $nuevo->fkfuncionario = $request->funcionario;
        $nuevo->kmini = $request->kmini;
        $nuevo->kmfin = $request->kmfin;
        $monto = str_replace(',', "", $request->monto);
        $nuevo->monto = $monto;
        $nuevo->recibe = $request->recibe;
        $nuevo->observacion = $request->observacion;
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

        if($folios)
        {
            foreach ($folios as $item)
            {   
                $numero = Pemexdesglose::where('iddesglose', $item->concepto)->value('numero');
                $unidades = Pemexfolio::where('fkdesglose', $item->concepto)->sum('numero');
                $disponible = $numero - $unidades;
                if($disponible >= $item->numero)
                {
                    $agregar = new Pemexfolio();
                    $agregar->fkvale = $nuevo->idvale;
                    $agregar->fkfactura = $item->factura;
                    $agregar->fkdesglose = $item->concepto;
                    $agregar->folioini = $item->folioini;
                    $agregar->foliofin = $item->foliofin;
                    $agregar->numero = $item->numero;
                    $agregar->unitario = $item->unitario;
                    $agregar->monto = $item->monto;
                    $agregar->save();
                }
                else
                {
                    return redirect('/pemexvales?page='.$request->page.'&vfecha='.$request->vfecha.'&vcomprobacion='.$request->vcomprobacion.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error al guardar verifique las unidades disponibles!');
                }             
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Dotación agregada con id:'.$nuevo->idvale;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/pemexvales?page='.$request->page.'&vfecha='.$request->vfecha.'&vcomprobacion='.$request->vcomprobacion.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Dotación agregada correctamente!');
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
        $modelo = Vpemexvale::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vcomprobacion = $request->vcomprobacion;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Pemexvale::findOrFail($id);
            $autos = Auto::where([['fkorigen', 2], ['custodia', 1], ['activo', 1]])->orderby('placa', 'asc')->get();
            $facturas = Pemexfactura::where('activo', 1)->get(); 
        }
        else
        {
            $datos = Pemexvale::where('fkusuario', $usuario)->findOrFail($id);
            $autos = Auto::where([['fkusuario', $usuario], ['fkorigen', 2], ['custodia', 1], ['activo', 1]])->orderby('placa', 'asc')->get();
            $facturas = Pemexfactura::where([['fkusuario', $usuario], ['activo', 1]])->get(); 
        }
        
        $autoactivo = Auto::where('idauto', $datos->fkauto)->value('activo');
        $autocustodia = Auto::where('idauto', $datos->fkauto)->value('custodia');
        $funcionarios = Vfuncionariocustodia::where([['fkauto', $datos->fkauto]])->orderBy('idcustodia', 'desc')->get();
        $folios = Vpemexfolio::where('fkvale', $id)->orderby('idfolio', 'asc')->get();

        return view('pemexvales.editar',compact('page', 'vfecha', 'vcomprobacion', 'vbusqueda', 'datos', 'autos', 'autoactivo', 'autocustodia', 'funcionarios', 'facturas', 'folios'));
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
        $modelo = Vpemexvale::findOrFail($id);
        $this->authorize('update', $modelo);
        
        $request->validate([
            'fecha' => 'required',
            'auto' => 'required',
            'funcionario' => 'required'
        ]);

        $actualiza = Pemexvale::findOrFail($id);
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $actualiza->fecha = $fechaformat;
        $actualiza->fkauto = $request->auto;
        $actualiza->fkfuncionario = $request->funcionario;
        $actualiza->kmini = $request->kmini;
        $actualiza->kmfin = $request->kmfin;
        $monto = str_replace(',', "", $request->monto);
        $actualiza->monto = $monto;
        $actualiza->recibe = $request->recibe;
        $actualiza->observacion = $request->observacion;
        if(isset($request->activo))
        {
            $actualiza->activo = 1;
        }
        else
        {
            $actualiza->activo = 0;
        }
        $actualiza->save();

        $eliminafolios = Pemexfolio::where('fkvale', $id);
        $eliminafolios->delete();

        $folios = json_decode($request->vdetalle);

        if($folios)
        {
            foreach ($folios as $item)
            {   
                $numero = Pemexdesglose::where('iddesglose', $item->concepto)->value('numero');
                $unidades = Pemexfolio::where('fkdesglose', $item->concepto)->sum('numero');
                $disponible = $numero - $unidades;
                if($disponible >= $item->numero)
                {
                    $agregar = new Pemexfolio();
                    $agregar->fkvale = $id;
                    $agregar->fkfactura = $item->factura;
                    $agregar->fkdesglose = $item->concepto;
                    $agregar->folioini = $item->folioini;
                    $agregar->foliofin = $item->foliofin;
                    $agregar->numero = $item->numero;
                    $agregar->unitario = $item->unitario;
                    $agregar->monto = $item->monto;
                    $agregar->save();
                }
                else
                {
                    return redirect('/pemexvales?page='.$request->page.'&vfecha='.$request->vfecha.'&vcomprobacion='.$request->vcomprobacion.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error al guardar verifique las unidades disponibles!');
                }             
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Dotación editada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/pemexvales?page='.$request->page.'&vfecha='.$request->vfecha.'&vcomprobacion='.$request->vcomprobacion.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Dotación editada correctamente!');
    }

    public function update2(Request $request, $id)
    {
        $modelo = Vpemexvale::findOrFail($id);
        $this->authorize('update', $modelo);
                
        $actualiza = Pemexvale::findOrFail($id);
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
            $bitacora->operacion = 'Dotación comprobada correctamente con id:'.$id;
        }
        else
        {
            $bitacora->operacion = 'Dotación descomprobada correctamente con id:'.$id;
        }
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', '¡Dotación comprobada correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', '¡Dotación descomprobada correctamente!');
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
        $modelo = Vpemexvale::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminafolios = Pemexfolio::where('fkvale', $id);
        $eliminafolios->delete();

        $elimina = Pemexvale::findOrFail($id);    
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Dotación eliminada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Dotación eliminada correctamente!');
    }
}
