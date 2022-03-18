<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vvale;
use App\Models\Auto;
use App\Models\Vauto;
use App\Models\Vale;
use App\Models\Factura;
use App\Models\Folio;
use App\Models\Vfolio;
use App\Models\Desglose;
use App\Models\Funcionario;
use App\Models\Vfuncionariocustodia;
use App\Models\Bitacora;

class ValegasController extends Controller
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
        $this->authorize('viewAny', Vvale::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;
        $vejercicio = $request->vejercicio;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);
        if($usuariorole->hasRole('administrador'))
        {
            $datos = Vvale::ejercicio($vejercicio)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idvale')->paginate(20);
        }
        else
        {
            $datos = Vvale::usuario($usuario)->ejercicio($vejercicio)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idvale')->paginate(20);
        }

        $ejercicios = Vvale::orderBy('ejercicio', 'desc')->get()->unique('ejercicio');
        // dd($anios);

        return view('vales.lista', compact('page', 'vfecha', 'vbusqueda', 'vejercicio', 'datos', 'ejercicios'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vvale::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $autos = Vauto::whereNotNull('fkfuncionario')->where([['fkorigen', 1], ['activo', 1]])->get();
            $facturas = Factura::where('activo', 1)->get();
        }
        else
        {
            $autos = Vauto::whereNotNull('fkfuncionario')->where([['fkusuario', $usuario], ['fkorigen', 1], ['activo', 1]])->get();
            $facturas = Factura::where([['fkusuario', $usuario], ['activo', 1]])->get(); 
        }

        return view('vales.crear', compact('page', 'vfecha', 'vbusqueda', 'autos', 'facturas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vvale::class);

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
                $numero = Desglose::where('iddesglose', $item->concepto)->value('numero');
                $unidades = Folio::where('fkdesglose', $item->concepto)->sum('numero');
                $disponible = $numero - $unidades;
                if($disponible < $item->numero)
                {
                    return redirect('/vales?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error no se pudo realizar la operación, verifique las unidades disponibles!');
                }             
            }
        }

        $nuevo = new Vale();
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
        $nuevo->save();

        if($folios)
        {
            foreach ($folios as $item)
            {   
                $numero = Desglose::where('iddesglose', $item->concepto)->value('numero');
                $unidades = Folio::where('fkdesglose', $item->concepto)->sum('numero');
                $disponible = $numero - $unidades;
                if($disponible >= $item->numero)
                {
                    $agregar = new Folio();
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
                    return redirect('/vales?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error al guardar verifique las unidades disponibles!');
                }             
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Vale agregado con id:'.$nuevo->idvale;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/vales?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Vale agregado correctamente!');
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
        $modelo = Vvale::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Vvale::findOrFail($id);
            $autos = Auto::where([['fkorigen', 1], ['custodia', 1], ['activo', 1]])->get();
        }
        else
        {
            $datos = Vvale::where('fkusuario', $usuario)->findOrFail($id);
            $autos = Auto::where([['fkusuario', $usuario], ['fkorigen', 1], ['custodia', 1], ['activo', 1]])->get();
        }

        // $autos = Auto::whereNotNull('fkfuncionario')->where([['fkusuario', $usuario], ['fkorigen', 1], ['activo', 1]])->get();
        // $autos = Auto::where([['fkusuario', $usuario], ['fkorigen', 1], ['custodia', 1], ['activo', 1]])->get();
        // $funcionarios = Funcionario::where('idfuncionario', $datos->fkfuncionario)->get();
        // dd($autovalido);
        $autoactivo = Auto::where('idauto', $datos->fkauto)->value('activo');
        $autocustodia = Auto::where('idauto', $datos->fkauto)->value('custodia');
        $funcionarios = Vfuncionariocustodia::where([['fkauto', $datos->fkauto]])->orderBy('idcustodia', 'desc')->get();
        $facturas = Factura::where([['fkusuario', $usuario], ['activo', 1]])->get(); 
        $folios = Vfolio::where('fkvale', $id)->orderby('idfolio', 'asc')->get();

        return view('vales.editar',compact('page', 'vfecha', 'vbusqueda', 'datos', 'autos', 'autoactivo', 'autocustodia', 'funcionarios', 'facturas', 'folios'));
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
        $modelo = Vvale::findOrFail($id);
        $this->authorize('update', $modelo);
        
        $request->validate([
            'fecha' => 'required',
            'auto' => 'required',
            'funcionario' => 'required'
        ]);

        // if($folios)
        // {
        //     foreach ($folios as $item)
        //     {   
        //         $numero = Desglose::where('iddesglose', $item->concepto)->value('numero');
        //         $unidades = Folio::where('fkdesglose', $item->concepto)->sum('numero');
        //         $disponible = $numero - $unidades;
        //         if($disponible < $item->numero)
        //         {
        //             return redirect('/vales?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error no se pudo realizar la operación, verifique las unidades disponibles!');
        //         }             
        //     }
        // }
    
        $actualiza = Vale::findOrFail($id);
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
        $actualiza->save();

        $eliminafolios = Folio::where('fkvale', $id);
        $eliminafolios->delete();

        $folios = json_decode($request->vdetalle);

        if($folios)
        {
            foreach ($folios as $item)
            {   
                $numero = Desglose::where('iddesglose', $item->concepto)->value('numero');
                $unidades = Folio::where('fkdesglose', $item->concepto)->sum('numero');
                $disponible = $numero - $unidades;
                if($disponible >= $item->numero)
                {
                    $agregar = new Folio();
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
                    return redirect('/vales?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensajeerror','¡Error al guardar verifique las unidades disponibles!');
                }             
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Vale editado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/vales?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Vale editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Vvale::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminafolios = Folio::where('fkvale', $id);
        $eliminafolios->delete();

        $elimina = Vale::findOrFail($id);    
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Vale eliminado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Vale eliminado correctamente!');
    }
}