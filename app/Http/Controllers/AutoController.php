<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Auto;
use App\Models\Origen;
use App\Models\Vauto;
use App\Models\Fabrica;
use App\Models\Tipo;
use App\Models\Transmision;
use App\Models\Combustible;
use App\Models\Funcionario;
use App\Models\Autoimg;
use App\Models\Custodia;
use App\Models\Vcustodia;
use App\Models\Bitacora;

class AutoController extends Controller
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
        $this->authorize('viewAny', Vauto::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vactivo = $request->vactivo; 
        $vorigen = $request->vorigen;       
        $vbusqueda = $request->vbusqueda;

        $origenes = Origen::all();
        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador') or $usuariorole->hasRole('supervisor'))
        {
            $autos = Vauto::fecha($vfecha)->activo($vactivo)->origen($vorigen)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idauto')->paginate(20);
        }
        else
        {
            $autos = Vauto::usuario($usuario)->fecha($vfecha)->activo($vactivo)->origen($vorigen)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idauto')->paginate(20);
        }

        return view('autos.lista', compact('page', 'vfecha', 'vactivo', 'vorigen', 'vbusqueda', 'origenes', 'autos'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vauto::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vactivo = $request->vactivo;
        $vorigen = $request->vorigen;
        $vbusqueda = $request->vbusqueda;

        $fabricas = Fabrica::all();
        $transmisiones = Transmision::all();
        $origenes = Origen::all();
        $combustibles = Combustible::all();
        $funcionarios = Funcionario::where('activo', 1)->orderby('nombre', 'asc')->orderby('paterno', 'asc')->orderby('materno', 'asc')->get();

        return view('autos.crear', compact('page', 'vfecha', 'vactivo', 'vorigen', 'vbusqueda', 'fabricas', 'origenes', 'transmisiones', 'combustibles', 'funcionarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vauto::class);

        if($request->origen == "1")
        {
            $request->validate([
                'fecha' => 'required',
                'origen' => 'required',
                'numero' => 'required',
                'fabrica' => 'required',
                'tipo' => 'required',
                'modelo' => 'required',
                'placa' => 'required'
            ]);
        }
        else
        {
            $request->validate([
                'fecha' => 'required',
                'origen' => 'required',                
                'fabrica' => 'required',
                'tipo' => 'required',
                'modelo' => 'required',
                'placa' => 'required'
            ]);
        }       

        $nuevoauto = new Auto();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevoauto->fecha = $fechaformat;
        $nuevoauto->fkorigen = $request->origen;
        $nuevoauto->numero = $request->numero;
        $nuevoauto->fkfabrica = $request->fabrica;
        $nuevoauto->fktipo = $request->tipo;
        $nuevoauto->modelo = $request->modelo;
        $nuevoauto->placa = $request->placa;
        $nuevoauto->chasis = $request->serie;
        $nuevoauto->motor = $request->motor;
        $nuevoauto->fktransmision = $request->transmision;
        $nuevoauto->fkcombustible = $request->combustible;
        $nuevoauto->descripcion = $request->descripcion;
        // $nuevoauto->telefono = $request->telefono;
        // $nuevoauto->ubicacion = $request->ubicacion;
        // $nuevoauto->precio = $request->precio;
        // $nuevoauto->fkfuncionario = $request->funcionario;
        $nuevoauto->fkusuario = auth()->user()->id;
        if(isset($request->custodia))
        {
            $nuevoauto->custodia = 1;
        }
        else
        {
            $nuevoauto->custodia = 0;
        }
        if(isset($request->activo))
        {
            $nuevoauto->activo = 1;
        }
        else
        {
            $nuevoauto->activo = 0;
        }
        $nuevoauto->save();

        if(isset($request->custodia) and $request->funcionario)
        {
            $nuevacustodia = new Custodia();
            $nuevacustodia->ejercicio = date('Y');
            $nuevacustodia->fecha = date('Y-m-d');
            $nuevacustodia->fkauto = $nuevoauto->idauto;
            $nuevacustodia->fkfuncionario = $request->funcionario;
            $nuevacustodia->fkusuario = auth()->user()->id;
            $nuevacustodia->save();
        }
    
        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Auto agregado con id:'.$nuevoauto->idauto;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/autos?page='.$request->page.'&vfecha='.$request->vfecha.'&vactivo='.$request->vactivo.'&vorigen='.$request->vorigen.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Auto agregado correctamente!');
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
        $modelo = Vauto::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vactivo = $request->vactivo;
        $vorigen = $request->vorigen;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador') or $usuariorole->hasRole('supervisor'))
        {
            $autos = Auto::findOrFail($id);
        }
        else
        {
            $autos = Auto::where('fkusuario', $usuario)->findOrFail($id);
        }

        $fabricas = Fabrica::all();
        $tipos = Tipo::where('fkfabrica', $autos->fkfabrica)->get();
        $transmisiones = Transmision::all();
        $origenes = Origen::all();
        $combustibles = Combustible::all();
        $funcionarios = Funcionario::where('activo', 1)->orderby('nombre', 'asc')->orderby('paterno', 'asc')->orderby('materno', 'asc')->get();
        $custodia = Custodia::where('fkauto', $autos->idauto)->orderBy('idcustodia', 'desc')->limit(1)->value('fkfuncionario');
        if($custodia and $autos->custodia)
        {
            $max = Vcustodia::where('fkauto', $autos->idauto)->orderBy('idcustodia', 'desc')->limit(1)->value('idcustodia');
            $custodias = Vcustodia::where([['fkauto', $autos->idauto], ['idcustodia', '<>', $max]])->orderBy('idcustodia', 'desc')->get();    
        }
        else
        {
            $custodias = Vcustodia::where('fkauto', $autos->idauto)->orderBy('idcustodia', 'desc')->get();
        }
        
        return view('autos.editar',compact('page', 'vfecha', 'vactivo', 'vorigen', 'vbusqueda', 'autos', 'fabricas', 'origenes', 'tipos', 'transmisiones', 'combustibles', 'funcionarios', 'custodia', 'custodias'));
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
        $modelo = Vauto::findOrFail($id);
        $this->authorize('update', $modelo);
        
        if($request->origen == "1")
        {
            $request->validate([
                'fecha' => 'required',
                'origen' => 'required',
                'numero' => 'required',
                'fabrica' => 'required',
                'tipo' => 'required',
                'modelo' => 'required',
                'placa' => 'required'
            ]);
        }
        else
        {
            $request->validate([
                'fecha' => 'required',                
                'origen' => 'required',
                'fabrica' => 'required',
                'tipo' => 'required',
                'modelo' => 'required',
                'placa' => 'required'
            ]);
        }       

        $actualizaauto = Auto::findOrFail($id);
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $actualizaauto->fecha = $fechaformat;
        $actualizaauto->fkorigen = $request->origen;
        $actualizaauto->numero = $request->numero;
        $actualizaauto->fkfabrica = $request->fabrica;
        $actualizaauto->fktipo = $request->tipo;
        $actualizaauto->modelo = $request->modelo;
        $actualizaauto->placa = $request->placa;
        $actualizaauto->chasis = $request->serie;
        $actualizaauto->motor = $request->motor;
        $actualizaauto->fktransmision = $request->transmision;
        $actualizaauto->fkcombustible = $request->combustible;
        $actualizaauto->descripcion = $request->descripcion;
        // $actualizaauto->telefono = $request->telefono;
        // $actualizaauto->ubicacion = $request->ubicacion;
        // $actualizaauto->precio = $request->precio;
        // $actualizaauto->fkfuncionario = $request->funcionario;
        if(isset($request->custodia))
        {
            $actualizaauto->custodia = 1;
        }
        else
        {
            $actualizaauto->custodia = 0;
        }
        if(isset($request->activo))
        {
            $actualizaauto->activo = 1;
        }
        else
        {
            $actualizaauto->activo = 0;
        }
        $actualizaauto->save();

        if(isset($request->custodia) and $request->funcionario)
        {
            $valida = Custodia::where('fkauto', $id)->orderBy('idcustodia', 'desc')->limit(1)->value('fkfuncionario');
            if ($valida != $request->funcionario)
            {
                $nuevacustodia = new Custodia();
                $nuevacustodia->ejercicio = date('Y');
                $nuevacustodia->fecha = date('Y-m-d');
                $nuevacustodia->fkauto = $id;
                $nuevacustodia->fkfuncionario = $request->funcionario;
                $nuevacustodia->fkusuario = auth()->user()->id;
                $nuevacustodia->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Auto editado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/autos?page='.$request->page.'&vfecha='.$request->vfecha.'&vactivo='.$request->vactivo.'&vorigen='.$request->vorigen.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Auto editado correctamente!');
    }

    public function update2(Request $request, $id)
    {
        $modelo = Vauto::findOrFail($id);
        $this->authorize('update', $modelo);
        
        $actualizaauto = Auto::findOrFail($id);
        if(isset($request->activo))
        {
            $actualizaauto->activo = 1;
        }
        else
        {
            $actualizaauto->activo = 0;
        }
        $actualizaauto->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Activación del auto en venta con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', '¡Auto activado correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', '¡Auto desactivado correctamente!');
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
        $modelo = Vauto::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminacustodia = Custodia::where('fkauto', $id);
        $eliminacustodia->delete();

        $eliminarauto = Auto::findOrFail($id);
        
        foreach (Autoimg::where('fkauto', $id)->cursor() as $imgcursor)
        {
            if($imgcursor->imagen)
            {
                $imagenborrar = public_path().'/storage/auto/'.$imgcursor->imagen;
                if (File::exists($imagenborrar))
                {
                    unlink($imagenborrar);
                }
            }
            $imgcursor->delete();    
        }
        
        $eliminarauto->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Auto eliminado con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Auto eliminado correctamente!');
    }
}
