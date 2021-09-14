<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vpase;
use App\Models\Pase;
use App\Models\Detalle;
use App\Models\Funcionario;
use App\Models\Bitacora;
use Carbon\Carbon;

class PaseController extends Controller
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
        $this->authorize('viewAny', Vpase::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Vpase::fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idpase')->paginate(20);
        }
        else
        {
            $datos = Vpase::usuario($usuario)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idfactura')->paginate(20);
        }
            
        return view('pases.lista',compact('page','vfecha', 'vbusqueda', 'datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vpase::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $funcionarios = Funcionario::where([['activo', 1],['firma', 1]])->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        
        return view('pases.crear', compact('page', 'vfecha', 'vbusqueda', 'funcionarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vpase::class);

        $request->validate([
            'fecha' => 'required',
            'hora' => 'required',
            'solicita' => 'required',
            'funcionario' => 'required'
        ]);
        
        $nuevo = new Pase();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevo->fecha = $fechaformat;
        $horaformat = date('H:i', strtotime($request->hora));
        $nuevo->hora = $horaformat;
        $nuevo->solicita = $request->solicita;
        $nuevo->observacion = $request->observacion;
        $nuevo->fkfuncionario = $request->funcionario;
        $nuevo->fkusuario = auth()->user()->id;
        $nuevo->save();

        $desglose = json_decode($request->vdetalle);

        if($desglose)
        {
            foreach ($desglose as $item)
            {                
                $agregar = new Detalle();
                $agregar->fkpase = $nuevo->idpase;
                $agregar->equipo = $item->equipo;
                $agregar->marca = $item->marca;
                $agregar->modelo = $item->modelo;
                $agregar->serie = $item->serie;
                $agregar->patrimonio = $item->patrimonio;
                $agregar->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Pase de salida agregado con id:'.$nuevo->idpase;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/pases?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Pase de salida agregado correctamente!');
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
        $modelo = Vpase::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $datos = Pase::findOrFail($id);
        }
        else
        {
            $datos = Pase::where('fkusuario', $usuario)->findOrFail($id);
        }
        $funcionarios = Funcionario::where([['activo', 1],['firma', 1]])->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        $detalles = Detalle::where('fkpase', $id)->orderby('iddetalle', 'asc')->get();

        return view('pases.editar',compact('page', 'vfecha', 'vbusqueda', 'datos', 'funcionarios', 'detalles'));
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
        $modelo = Vpase::findOrFail($id);
        $this->authorize('update', $modelo);
        
        $request->validate([
            'fecha' => 'required',
            'hora' => 'required',
            'solicita' => 'required',
            'funcionario' => 'required'
        ]);
    
        $actualiza = Pase::findOrFail($id);
        $actualiza->solicita = $request->solicita;
        $actualiza->observacion = $request->observacion;
        $actualiza->fkfuncionario = $request->funcionario;
        $actualiza->save();

        $detalles = json_decode($request->vdetalle);

        $eliminadetalles = Detalle::where('fkpase', $id);
        $eliminadetalles->delete();

        if($detalles)
        {
            foreach ($detalles as $item)
            {                
                $agregar = new Detalle();
                $agregar->fkpase = $id;
                $agregar->equipo = $item->equipo;
                $agregar->marca = $item->marca;
                $agregar->modelo = $item->modelo;
                $agregar->serie = $item->serie;
                $agregar->patrimonio = $item->patrimonio;
                $agregar->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Pase de salida editado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/pases?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Pase de salida editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Vpase::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminadetalles = Detalle::where('fkpase', $id);
        $eliminadetalles->delete();

        $elimina = Pase::findOrFail($id);    
        $elimina->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Pase de salida eliminado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Pase de salida eliminado correctamente!');
    }
}
