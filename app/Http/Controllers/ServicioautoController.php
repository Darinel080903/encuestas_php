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
use App\Models\Vcompra;
use App\Models\User;
use App\Models\Bitacora;

class ServicioautoController extends Controller
{
    // By CIRG - Protejer la ruta.
    public function __construct()
    {
        $this->middleware('auth');
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
                
        return view('solicitudes.crearauto', compact('page', 'vfecha', 'vbusqueda', 'folio', 'proveedores', 'partidas', 'areas', 'clases', 'proveedores', 'facturas', 'unidades', 'muebles', 'inmuebles', 'razones', 'funcionarios', 'otorga', 'elabora', 'solicita', 'autoriza', 'compras', 'grupos', 'autos')); 
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

        $request->validate([

            'partida' => 'required',
            'clave' => 'required'                                   
        ]);

             // Inicio Guarda solicitud
          $nuevo = new Solicitud();
          $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
          $nuevo->fecha = $fechaformat;        
          $nuevo->folio = $request->folio;
          $nuevo->fkpartida = $request->partida;
          $nuevo->fkarea = $request->area;
          $nuevo->fkareacargo = $request->areacargo;
          $nuevo->clave = $request->clave;          
          $nuevo->fkclase = 2;        
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

            $agregar = new Servicio();
            $agregar->descripcion= $request->descripcion;
            $agregar->fksolicitud = $nuevo->idsolicitud;
            $agregar->fkgrupo = 3;
            $agregar->fkauto = $request->auto;                
            $agregar->servicio = $request->servicio;
            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechaservicio)));
            $agregar->fecha = $fechaformat;
            $agregar->save();

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
        
        return view('solicitudes.editarauto',compact('page', 'vfecha', 'vbusqueda', 'partidas', 'solicitudes', 'areas', 'clases', 'proveedores', 'funcionarios', 'otorga', 'elabora', 'solicita', 'autoriza', 'compras', 'grupos', 'autos', 'servicios', 'grupo', 'auto', 'muebles', 'razones'));
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

        $request->validate([
            'partida' => 'required',
            'clave' => 'required'                                   
        ]);
       
        $actualizaauto = Solicitud::findOrFail($id);
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $actualizaauto->fecha = $fechaformat;
        $actualizaauto->folio = $request->folio;
        $actualizaauto->fkpartida = $request->partida;
        $actualizaauto->fkarea = $request->area;
        $actualizaauto->fkareacargo = $request->areacargo;
        $actualizaauto->clave = $request->clave;
        // $actualizaauto->disponible = $request->disponible;
        // $actualizaauto->fkotorga = $request->otorga;
        // $actualizaauto->fkclase = $request->clase;
        $actualizaauto->fkproveedor = $request->proveedor;
        $actualizaauto->factura = $request->factura;
        if($request->fechafactura)
        {
            $formatfechafactura = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechafactura)));
            $actualizaauto->fechafactura = $formatfechafactura;
        }
        $subtotal = str_replace(',', "", $request->subtotal);
        $actualizaauto->subtotal = $subtotal;
        $actualizaauto->iva = $request->iva;
        $actualizaauto->ajuste = $request->ajuste;
        $total = str_replace(',', "", $request->total);
        $actualizaauto->total = $total; 
        $actualizaauto->concepto = $request->concepto;
        $actualizaauto->fkelabora = $request->elabora;
        $actualizaauto->fksolicita = $request->solicita;
        $actualizaauto->fkautoriza = $request->autoriza;
        $actualizaauto->observacion = $request->observacion;       
        $actualizaauto->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $actualizaauto->activo = 1;
        }
        else
        {
            $actualizaauto->activo = 0;
        }
            $actualizaauto->save();

            $idservicio = Servicio::where('fksolicitud', $id)->value('idservicio');

            $actualiza = Servicio::findOrFail($idservicio);
            $actualiza->descripcion= $request->descripcion;
            //$actualiza->fksolicitud = $nuevo->idsolicitud;
            //$actualiza->fkgrupo = $request->grupo;
            $actualiza->fkauto = $request->auto;                
            $actualiza->servicio = $request->servicio;
            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fechaservicio)));
            $actualiza->fecha = $fechaformat;
            $actualiza->save();

            $bitacora = new Bitacora();
            $bitacora->fkusuario = auth()->user()->id;
            $bitacora->operacion = 'Solicitud editada con id:'.$id;
            $bitacora->fecha = date('Y-m-d H:i:s');
            $bitacora->ip = $request->ip();
            $bitacora->pc = gethostname();
            $bitacora->save();
    
        return redirect('/solicitudes?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Solicitud editada correctamente!');       

    }   
}
