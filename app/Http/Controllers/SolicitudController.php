<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Partida;
use App\Models\Proveedor;
use App\Models\Area;
use App\Models\Clase;
use App\Models\Solicitud;
use App\Models\Factura;
use App\Models\Unidad;
use App\Models\Mueble;
use App\Models\Inmueble;
use App\Models\Razon;
use App\Models\Funcionario;
use App\Models\Compra;
use App\Models\Grupo;
use App\Models\Auto;
use App\Models\Servicio;
use App\Models\Vsolicitud;
use App\Models\Vauto;
use App\Models\User;
use App\Models\Bitacora;

class SolicitudController extends Controller
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
        $this->authorize('viewAny', Vsolicitud::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Vsolicitud::fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('folio')->paginate(20);
        }
        else
        {
            $datos = Vsolicitud::usuario($usuario)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('folio')->paginate(20);
        }

        return view('solicitudes.lista', compact('page', 'vfecha', 'vbusqueda', 'datos'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vsolicitud::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        //$usuario = auth()->user()->id;
        //$autos = Auto::whereNotNull('fkfuncionario')->where([['fkusuario', $usuario], ['fkorigen', 1], ['activo', 1]])->get();
        //$proveedores = Proveedor::all();
        $folio= Solicitud::max('folio');
        $folio= $folio+1;
        $partidas = Partida::where('activo', 1)->get();
        $areas = Area::where([['fkarea', null], ['activo', 1]])->get();        
        $clases = Clase::orderBy('idclase', 'asc')->get();
        $proveedores = Proveedor::orderBy('idproveedor', 'asc')->get();
        $facturas = Factura::fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idfactura')->get();
        $unidades = Unidad::busqueda($vbusqueda)->orderBy('unidad', 'asc')->get();
        $muebles = Mueble::busqueda($vbusqueda)->orderBy('mueble', 'asc')->get();
        $inmuebles = Inmueble::busqueda($vbusqueda)->orderBy('inmueble', 'asc')->get();
        $razones = Razon::busqueda($vbusqueda)->orderBy('razon', 'asc')->get();        
        $funcionarios = Funcionario::where('activo', 1)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        $otorga = Funcionario::where([['valida', 1], ['activo', 1]])->get();
        $elabora = Funcionario::where([['elabora', 1], ['activo', 1]])->get();        
        $solicita = Funcionario::where([['entrega', 1], ['activo', 1]])->get();
        $autoriza = Funcionario::where([['autoriza', 1], ['activo', 1]])->get();
        $compras = Compra::orderBy('idcompra', 'asc')->get();
        $grupos = Grupo::orderBy('idgrupo', 'asc')->get();        
        $autos = Auto::where([['fkorigen', 1], ['activo', 1]])->get();
                
        return view('solicitudes.crear', compact('page', 'vfecha', 'vbusqueda', 'folio', 'proveedores', 'partidas', 'areas', 'clases', 'proveedores', 'facturas', 'unidades', 'muebles', 'inmuebles', 'razones', 'funcionarios', 'otorga', 'elabora', 'solicita', 'autoriza', 'compras', 'grupos', 'autos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vsolicitud::class);

        if($request->clase == 1) //compra
        {
            $request->validate([

                'partida' => 'required',
                'clave' => 'required',
                'clase' => 'required',
                //'grupo' => 'required',
                //'proveedor' => 'required',
                //'factura' => 'required'                               
            ]); 
        }
        else if($request->clase == 2) //servicio
        {
            if($request->grupo == 1) //inmueble
            {
                $request->validate([

                'partida' => 'required',
                'clave' => 'required',
                'clase' => 'required',                
                'proveedor' => 'required',
                'factura' => 'required',
                //'descripcion' => 'required',
                //'inmueble' => 'required'                
                ]);
            }                        
            elseif($request->grupo == 2) //mueble 
            {
                $request->validate([

                'partida' => 'required',
                'clave' => 'required',
                'clase' => 'required',                
                'proveedor' => 'required',
                'factura' => 'required',
                //'descripcion' => 'required',
                //'mueble' => 'required'                
                ]);
            }   
            elseif($request->grupo == 3) //vehiculo 
            {
                $request->validate([

                'partida' => 'required',
                'clave' => 'required',
                'clase' => 'required',                
                'proveedor' => 'required',
                'factura' => 'required',
                //'descripcion' => 'required',
                //'vehiculo' => 'required'                
                ]);
            }     
        }

        // Inicio Guarda solicitud
        $nuevo = new Solicitud();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevo->fecha = $fechaformat;        
        $nuevo->folio = $request->folio;
        $nuevo->fkpartida = $request->partida;
        $nuevo->fkarea = $request->area;
        $nuevo->fkareacargo = $request->areacargo;
        $nuevo->clave = $request->clave;
        $nuevo->disponible = $request->disponible;        
        $nuevo->fkotorga = $request->otorga;
        $nuevo->fkclase = $request->clase;        
        $nuevo->fkproveedor = $request->proveedor;
        $nuevo->factura = $request->factura;
        if($request->fechafactura)
        {
            $formatfechafactura = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechafactura)));
            $nuevo->fechafactura = $formatfechafactura;
        }        
        $subtotal = str_replace(',', "", $request->subtotal);
        $nuevo->subtotal = $subtotal;
        $nuevo->iva = $request->iva;
        $nuevo->ajuste = $request->ajuste;
        $total = str_replace(',', "", $request->total);
        $nuevo->total = $total;        
        $nuevo->concepto = $request->concepto;
        $nuevo->fkelabora = $request->elabora;
        $nuevo->fksolicita = $request->solicita;
        $nuevo->fkautoriza = $request->autoriza;
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
        // Fin Guarda solicitud


        if($request->clase == 1) //compra
        {
            
            $compra = json_decode($request->vdetalle);

            if($compra)
            {
                foreach ($compra as $item)
                {                
                    $agregar = new Compra();
                    $agregar->fksolicitud= $nuevo->idsolicitud;
                    $agregar->cantidad = $item->numero;
                    $agregar->fkunidad = $item->unidad;
                    $agregar->descripcion = $item->concepto;
                    $agregar->unitario = $item->unitario;
                    $total = str_replace(',', "", $request->total);
                    $agregar->total = $total;                    
                    $agregar->save();
                }
            }
        }
        else if($request->clase == 2) //servicio
        {
            if($request->grupo == 1 ) //inmueble
            {
                $agregar = new Servicio();
                $agregar->descripcion= $request->inmuebledescripcion;                
                $agregar->fksolicitud = $nuevo->idsolicitud;
                $agregar->fkgrupo = $request->grupo;
                $agregar->fkinmueble = $request->inmueble;
                $agregar->servicio = $request->inmuebleservicio;               
                $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
                $agregar->fecha = $fechaformat;              
                $agregar->save();
            }
            else if($request->grupo == 2) //mueble
            {
                $agregar = new Servicio();
                $agregar->descripcion= $request->muebledescripcion;
                $agregar->fksolicitud = $nuevo->idsolicitud;
                $agregar->fkgrupo = $request->grupo;
                $agregar->fkmueble = $request->mueble;
                $agregar->fkrazon = $request->razon;
                $agregar->modelo = $request->modelo;
                $agregar->servicio = $request->muebleservicio;
                $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechaactivo)));
                $agregar->fecha = $fechaformat;
                $agregar->save();
            }
            else if($request->grupo == 3) //vehiculo
            {
                $agregar = new Servicio();
                $agregar->descripcion= $request->vehiculodescripcion;
                $agregar->fksolicitud = $nuevo->idsolicitud;
                $agregar->fkgrupo = $request->grupo;
                $agregar->fkauto = $request->auto;                
                $agregar->servicio = $request->servicio;
                $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechaservicio)));
                $agregar->fecha = $fechaformat;
                $agregar->save();
            }
        }

        

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Solicitud agregada con id:'.$nuevo->idsolicitud;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/solicitudes?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Solicitud agregada correctamente!');
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
        $modelo = Vsolicitud::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);
      
        $folio= Solicitud::max('folio');
        $partidas = Partida::where('activo', 1)->get(); 
        $solicitudes = Solicitud::findOrFail($id);               
        $areas = Area::where([['fkarea', null], ['activo', 1]])->get();
        $clases = Clase::orderBy('idclase', 'asc')->get();
        $proveedores = Proveedor::orderBy('idproveedor', 'asc')->get();
        $funcionarios = Funcionario::where('activo', 1)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        $otorga = Funcionario::where([['valida', 1], ['activo', 1]])->get();
        $elabora = Funcionario::where([['elabora', 1], ['activo', 1]])->get();        
        $solicita = Funcionario::where([['entrega', 1], ['activo', 1]])->get();
        $autoriza = Funcionario::where([['autoriza', 1], ['activo', 1]])->get();
        $compras = Compra::where('fksolicitud', $id)->get();
        $grupos = Grupo::orderBy('idgrupo', 'asc')->get();                
        $grupo = Servicio::where('fksolicitud', $id)->value('fkgrupo');
        $servicios = Servicio::where('fksolicitud', $id)->first();
        $autos = Auto::where([['fkorigen', 1], ['activo', 1]])->get();
        $auto = Vauto::where([['idauto', $servicios->fkauto], ['activo', 1]])->first();
        //$muebles = Mueble::where([['idmueble', $servicios->fkmueble]])->first();
        $muebles = Mueble::orderBy('mueble', 'asc')->get();
        $razones = Razon::orderBy('razon', 'asc')->get();
        
        return view('solicitudes.editar',compact('page', 'vfecha', 'vbusqueda', 'partidas', 'solicitudes', 'areas', 'clases', 'proveedores', 'funcionarios', 'otorga', 'elabora', 'solicita', 'autoriza', 'compras', 'grupos', 'autos', 'servicios', 'grupo', 'auto', 'muebles', 'razones'));

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
        $modelo = Vsolicitud::findOrFail($id);
        $this->authorize('update', $modelo);
       
        $actualizasolicitud = Solicitud::findOrFail($id);
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $actualizasolicitud->fecha = $fechaformat;
        $actualizasolicitud->folio = $request->folio;
        $actualizasolicitud->fkpartida = $request->partida;
        $actualizasolicitud->fkarea = $request->area;
        $actualizasolicitud->fkareacargo = $request->areacargo;
        $actualizasolicitud->clave = $request->clave;
        $actualizasolicitud->disponible = $request->disponible;
        $actualizasolicitud->fkotorga = $request->otorga;
        $actualizasolicitud->fkclase = $request->clase;
        $actualizasolicitud->fkproveedor = $request->proveedor;
        $actualizasolicitud->factura = $request->factura;
        if($request->fechafactura)
        {
            $formatfechafactura = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechafactura)));
            $actualizasolicitud->fechafactura = $formatfechafactura;
        }
        $actualizasolicitud->subtotal = $request->subtotal;
        $actualizasolicitud->iva = $request->iva;
        $actualizasolicitud->ajuste = $request->ajuste;
        $actualizasolicitud->total = $request->total;
        $actualizasolicitud->concepto = $request->concepto;
        $actualizasolicitud->fkelabora = $request->elabora;
        $actualizasolicitud->fksolicita = $request->solicita;
        $actualizasolicitud->fkautoriza = $request->autoriza;
        $actualizasolicitud->observacion = $request->observacion;
        // $monto = str_replace(',', "", $request->monto);
        // $nuevo->monto = $monto;
        // if($request->pago){
        //     $pagoformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->pago)));
        //     $nuevo->pago = $pagoformat;
        // }
        $actualizasolicitud->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $actualizasolicitud->activo = 1;
        }
        else
        {
            $actualizasolicitud->activo = 0;
        }
        $actualizasolicitud->save();

        if($request->clase == 1) //compra
        {
            
            $compra = json_decode($request->vdetalle);

            if($compra)
            {
                foreach ($compra as $item)
                {                
                    $actualizar = Solicitud::findOrFail($id);
                    $actualizar->fksolicitud= $nuevo->idsolicitud;
                    $actualizar->cantidad = $item->numero;
                    $actualizar->fkunidad = $item->unidad;
                    $actualizar->descripcion = $item->concepto;
                    $actualizar->unitario = $item->unitario;
                    $total = str_replace(',', "", $request->total);
                    $actualizar->total = $total;                    
                    $actualizar->save();
                }
            }
        }
        else if($request->clase == 2) //servicio
        {
            if($request->grupo == 1 ) //inmueble
            {
                $agregar = new Servicio();
                $agregar->descripcion= $request->inmuebledescripcion;                
                $agregar->fksolicitud = $nuevo->idsolicitud;
                $agregar->fkgrupo = $request->grupo;
                $agregar->fkinmueble = $request->inmueble;
                $agregar->servicio = $request->inmuebleservicio;               
                $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
                $agregar->fecha = $fechaformat;              
                $agregar->save();
            }
            else if($request->grupo == 2) //mueble
            {
                $agregar = new Servicio();
                $agregar->descripcion= $request->muebledescripcion;
                $agregar->fksolicitud = $nuevo->idsolicitud;
                $agregar->fkgrupo = $request->grupo;
                $agregar->fkmueble = $request->mueble;
                $agregar->fkrazon = $request->razon;
                $agregar->modelo = $request->modelo;
                $agregar->servicio = $request->muebleservicio;
                $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechaactivo)));
                $agregar->fecha = $fechaformat;
                $agregar->save();
            }
            else if($request->grupo == 3) //vehiculo
            {
                $actualizar = new Servicio();
                $actualizar->descripcion= $request->vehiculodescripcion;
                $actualizar->fksolicitud = $nuevo->idsolicitud;
                $actualizar->fkgrupo = $request->grupo;
                $actualizar->fkauto = $request->auto;                
                $actualizar->servicio = $request->servicio;
                $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechaservicio)));
                $actualizar->fecha = $fechaformat;
                $actualizar->save();
            }
        }

       
        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Solicitud editada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/solicitudes?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Solicitud editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Vsolicitud::findOrFail($id);
        $this->authorize('delete', $modelo);

        if($modelo->fkclase == 1)
        {
            $eliminacompra = Compra::where('fksolicitud', $id);
            $eliminacompra->delete();
        }
        elseif($modelo->fkclase == 2)
        {
            $eliminaservicio = Servicio::where('fksolicitud', $id);
            $eliminaservicio->delete();
        }
        
        $eliminasolicitud = Solicitud::findOrFail($id);        
        $eliminasolicitud->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Solicitud eliminada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Solicitud eliminada correctamente!');
    }
}