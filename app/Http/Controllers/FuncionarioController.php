<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
use App\Models\Funcionario;
use App\Models\Area;
use App\Models\Categoria;
use App\Models\Puesto;
Use App\Models\Bitacora;

class FuncionarioController extends Controller
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
        $this->authorize('viewAny', Funcionario::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $usuario = User::findOrFail(auth()->user()->id);

        if($usuario->hasRole('administrador'))
        {
            $funcionarios = Funcionario::busqueda($vbusqueda)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->paginate(10);
        }
        else
        {
            $funcionarios = Funcionario::usuario(auth()->user()->id)->busqueda($vbusqueda)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->paginate(10);
        }
    
        return view('funcionarios.lista',compact('page', 'vbusqueda', 'funcionarios'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Funcionario::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        // $areas = Area::orderBy('area', 'asc')->get();
        $areas = Area::whereNull('fkarea')->get();
        $categorias = Categoria::orderBy('categoria', 'asc')->get();
        $puestos = Puesto::orderBy('puesto', 'asc')->get();

        return view('funcionarios.crear', compact('page', 'vbusqueda', 'areas', 'categorias', 'puestos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Funcionario::class);

        $request->validate([
            'adscripcion' => 'required',
            'area' => 'required',
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevofuncionario = new Funcionario();
        $nuevofuncionario->fkadscripcion = $request->adscripcion;
        $nuevofuncionario->fkarea = $request->area;
        $nuevofuncionario->nombre = $request->nombre;
        $nuevofuncionario->paterno = $request->paterno;
        $nuevofuncionario->materno = $request->materno;
        $nuevofuncionario->fkcategoria = $request->categoria;
        $nuevofuncionario->fkpuesto = $request->puesto;
        // if(isset($request->firma))
        // {
        //     $nuevofuncionario->firma = 1;
        // }
        // else
        // {
        //     $nuevofuncionario->firma = 0;
        // }
        if(isset($request->activo))
        {
            $nuevofuncionario->activo = 1;
        }
        else
        {
            $nuevofuncionario->activo = 0;
        }
        $nuevofuncionario->fkusuario = auth()->user()->id;
        $nuevofuncionario->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo funcionario con id:'.$nuevofuncionario->idfuncionario;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/funcionarios?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Funcionario agregado correctamente!');
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
        $modelo = Funcionario::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $funcionarios = Funcionario::findOrFail($id);
        // $areas = Area::orderBy('area', 'asc')->get();
        $areas = Area::whereNull('fkarea')->get();
        $categorias = Categoria::orderBy('categoria', 'asc')->get();
        $puestos = Puesto::orderBy('puesto', 'asc')->get();

        return view('funcionarios.editar',compact('page', 'vbusqueda', 'areas', 'categorias', 'puestos', 'funcionarios'));
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
        $modelo = Funcionario::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'adscripcion' => 'required',
            'area' => 'required',
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualizafuncionario = Funcionario::findOrFail($id);
        $actualizafuncionario->fkadscripcion = $request->adscripcion;
        $actualizafuncionario->fkarea = $request->area;
        $actualizafuncionario->nombre = $request->nombre;
        $actualizafuncionario->paterno = $request->paterno;
        $actualizafuncionario->materno = $request->materno;
        $actualizafuncionario->fkcategoria = $request->categoria;
        $actualizafuncionario->fkpuesto = $request->puesto;
        // if(isset($request->firma))
        // {
        //     $actualizafuncionario->firma = 1;
        // }
        // else
        // {
        //     $actualizafuncionario->firma = 0;
        // }
        if(isset($request->activo))
        {
            $actualizafuncionario->activo = 1;
        }
        else
        {
            $actualizafuncionario->activo = 0;
        }
        $actualizafuncionario->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del funcionario con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/funcionarios?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Funcionario editado correctamente!');
    }

    public function update2(Request $request, $id)
    {
         
        $actualizafuncionario = Funcionario::findOrFail($id);
        if(isset($request->activo))
        {
            $actualizafuncionario->activo = 1;
        }
        else
        {
            $actualizafuncionario->activo = 0;
        }
        $actualizafuncionario->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $bitacora->operacion = 'Funcionario activado correctamente con id:'.$id;
        }
        else
        {
            $bitacora->operacion = 'Funcionario desactivado correctamente con id:'.$id;
        }
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', '¡Funcionario activado correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', '¡Funcionario desactivado correctamente!');
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
        $modelo = Funcionario::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminafuncionario = Funcionario::findOrFail($id);
        $eliminafuncionario->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del funcionario con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Funcionario eliminado correctamente!');
    }
}
