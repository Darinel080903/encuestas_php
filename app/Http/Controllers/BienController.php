<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tmpbien;
use App\Models\Vtmpbien;
use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Operativo;
use App\Models\Cedula;
use App\Models\Estado;
use App\Models\Area;
use App\Models\Funcionario;
use App\Models\Bien;
use App\Models\Vbien;
use App\Models\Historico;
Use App\Models\Bitacora;

class BienController extends Controller
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
        $this->authorize('viewAny', Vbien::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $bienes = Vbien::fecha($vfecha)->busqueda($vbusqueda)->orderBy('patrimonio', 'asc')->paginate(10);
    
        return view('bienes.lista',compact('page', 'vfecha', 'vbusqueda', 'bienes'));  
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vbien::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $bienesmodal = Vbien::where([['raiz', null], ['fkraiz', null], ['fkfuncionario', null], ['activo', 1]])->get();
        $articulos = Articulo::orderBy('articulo', 'asc')->get();
        $articulosmodal = Articulo::where('raiz', '<>', 1)->orwhereNull('raiz')->orderBy('articulo', 'asc')->get();
        $marcas = Marca::orderBy('marca', 'asc')->get();
        $operativos = Operativo::orderBy('operativo', 'asc')->get();
        $areas = Area::whereNull('fkarea')->get();
        $funcionarios = Funcionario::where('activo', 1)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        $estados = Estado::orderBy('idestado', 'asc')->get();
        $cedulas = Cedula::orderBy('fecha', 'asc')->get();

        return view('bienes.crear', compact('page', 'vfecha', 'vbusqueda', 'bienesmodal', 'articulos', 'articulosmodal', 'marcas', 'operativos', 'areas', 'funcionarios', 'estados', 'cedulas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vbien::class);

        $request->validate([
            'articulo' => 'required',
            'marca' => 'required',
            'serie' => 'required',
            'patrimonio' => 'required',
            'estado' => 'required',
        ]);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $validar = Bien::where('serie', $request->serie)->orWhere('patrimonio', $request->patrimonio)->count();
        
        if($validar > 0)
        {
            return back()->withInput()->with('mensaje', '¡Error, numero de serie o número de patrimonio existente en el inventario!');
        }

        $nuevobien = new Bien();
        $nuevobien->fkarticulo = $request->articulo;
        $nuevobien->fkmarca = $request->marca;
        $nuevobien->modelo = $request->modelo;
        $nuevobien->procesador = $request->procesador;
        $nuevobien->memoria = $request->memoria;
        $nuevobien->disco = $request->disco;
        $nuevobien->ip = $request->ip;
        $nuevobien->fkoperativo = $request->operativo;
        $nuevobien->serie = $request->serie;
        $nuevobien->patrimonio = $request->patrimonio;
        if($request->funcionario != null)
        {
            $nuevobien->fkfuncionario = $request->funcionario;
        }
        $fechaformat = date('Y-m-d');
        $nuevobien->fecha = $fechaformat;
        $nuevobien->fkestado = $request->estado;
        $nuevobien->fkcedula = $request->cedula;
        $nuevobien->observacion = $request->observacion;
        $nuevobien->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $nuevobien->activo = 1;
        }
        else
        {
            $nuevobien->activo = 0;
        }
        $nuevobien->save();

        //tenemos que validar si la tabla Tmpbien tiene datos del cpu raiz de ser asi mandarlos a guardar los datos dependientes.
        $articulos = Articulo::findOrFail($request->articulo);

        if($articulos->raiz == 1 ) //condicion de busqueda en tablas
        {
            $usuario = auth()->user()->id;        //obtenemos la instancia del usuario logueado
            $cuentatmpbienes = Tmpbien::where([['fkusuario', $usuario]])->count();    //estamos contando si hay registros en la tabla temporal.
            
            if($cuentatmpbienes != 0 )
            {
                $tmpbienes = Tmpbien::where('fkusuario', $usuario)->get();
                
                foreach ($tmpbienes as $item)
                {   
                    if($item->origen == 'n')
                    {
                        $nuevotmpbien = new Bien();
                        $nuevotmpbien->fkarticulo = $item->fkarticulo;
                        $nuevotmpbien->fkmarca = $item->fkmarca;
                        $nuevotmpbien->modelo = $item->modelo;
                        $nuevotmpbien->serie = $item->serie;
                        $nuevotmpbien->patrimonio = $item->patrimonio;
                        if($request->funcionario != null)
                        {
                            $nuevotmpbien->fkfuncionario = $request->funcionario;
                            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
                            $nuevotmpbien->fecha = $fechaformat;
                        }                    
                        $nuevotmpbien->fkestado = $item->fkestado;
                        $nuevotmpbien->observacion = $item->observacion;
                        $nuevotmpbien->fkraiz = $nuevobien->idbien;
                        $nuevotmpbien->fkusuario = auth()->user()->id;
                        if(isset($request->activo))
                        {
                            $nuevotmpbien->activo = 1;
                        }
                            else
                        {
                            $nuevotmpbien->activo = 0;
                        }
                        $nuevotmpbien->save();
                    }
                    elseif($item->origen == 'i')
                    {
                        $idbien = Bien::Where([['serie', $item->serie], ['patrimonio', $item->patrimonio]])->value('idbien');
                        $actualizabien = Bien::findOrFail($idbien);
                        if($request->funcionario != null)
                        {
                            $actualizabien->fkfuncionario = $request->funcionario;
                            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
                            $actualizabien->fecha = $fechaformat;
                        }
                        $actualizabien->fkraiz = $nuevobien->idbien;
                        $actualizabien->save();
                    }                      
                }
                    
                $limpiatmpbienes = Tmpbien::where('fkusuario', $usuario); //eliminamos los registros de la tabla temporal.
                $limpiatmpbienes->delete();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo bien con id:'.$nuevobien->idbien;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/bienes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Bien agregado correctamente!');
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
        $modelo = Vbien::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $bienes = Bien::findOrFail($id);
        $articulos = Articulo::orderBy('articulo', 'asc')->get();
        $articulosmodal = Articulo::where('raiz', '<>', 1)->orwhereNull('raiz')->orderBy('articulo', 'asc')->get();
        $marcas = Marca::orderBy('marca', 'asc')->get();
        $operativos = Operativo::orderBy('operativo', 'asc')->get();
        $areas = Area::whereNull('fkarea')->get();
        $funcionarios = Funcionario::where('activo', 1)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        $estados = Estado::orderBy('idestado', 'asc')->get();
        $cedulas = Cedula::orderBy('fecha', 'asc')->get();

        $raiz = Articulo::Where('idarticulo', $bienes->fkarticulo)->value('raiz');

        // registros que se van a la tabla temporal.
        $bienestotmp = Bien::Where('fkraiz', $bienes->idbien)->get();

        //obtenemos la instancia del usuario logueado
        $usuario = auth()->user()->id;

        //eliminamos los registros de la tabla temporal.
        $limpiartmpbienes = Tmpbien::where('fkusuario', $usuario);
        $limpiartmpbienes->delete();

        //se agregan los datos a la tabla Tmpbienes                
        foreach ($bienestotmp as $item)
        {                
                
            $agregabien = new Tmpbien();
            $agregabien->fkarticulo = $item->fkarticulo;
            $agregabien->fkmarca = $item->fkmarca;
            $agregabien->modelo = $item->modelo;
            $agregabien->serie = $item->serie;
            $agregabien->patrimonio = $item->patrimonio;                            
            $agregabien->fkestado = $item->fkestado;
            $agregabien->observacion = $item->observacion;
            $agregabien->fkusuario = auth()->user()->id;
            $agregabien->save();
                
        }

        // registros que se van a la tabla temporal.                                        
        $tmpbienes = Vtmpbien::Where('fkusuario', $usuario)->get();          

        return view('bienes.editar',compact('page', 'vfecha', 'vbusqueda', 'articulos', 'articulosmodal', 'marcas', 'operativos', 'areas', 'funcionarios', 'estados', 'cedulas', 'bienes', 'raiz', 'tmpbienes'));
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
        $modelo = Vbien::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'articulo' => 'required',
            'marca' => 'required',
            'serie' => 'required',
            'patrimonio' => 'required',
            'estado' => 'required',
        ]);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;
        
        $actualizabien = Bien::findOrFail($id);
        $actualizabien->fkarticulo = $request->articulo;
        $actualizabien->fkmarca = $request->marca;
        $actualizabien->modelo = $request->modelo;
        $actualizabien->procesador = $request->procesador;
        $actualizabien->memoria = $request->memoria;
        $actualizabien->disco = $request->disco;
        $actualizabien->ip = $request->ip;
        $actualizabien->fkoperativo = $request->operativo;
        $actualizabien->serie = $request->serie;
        $actualizabien->patrimonio = $request->patrimonio;
        if($request->funcionario != null)
        {
            $actualizabien->fkfuncionario = $request->funcionario;
            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
            $actualizabien->fecha = $fechaformat;
        }
        $actualizabien->fkestado = $request->estado;
        $actualizabien->fkcedula = $request->cedula;
        $actualizabien->observacion = $request->observacion;
        $actualizabien->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $actualizabien->activo = 1;
        }
        else
        {
            $actualizabien->activo = 0;
        }
        $actualizabien->save();

        //limpiamos de la tabla bien los registros dependientes fkraiz.

        $articulos = Articulo::findOrFail($request->articulo);

        if($articulos->raiz == 1 ) //condicion de busqueda en tablas
        {
            $limpiartmpbien = Bien::where('fkraiz', $id); //eliminamos los registros de la tabla temporal.
            $limpiartmpbien->delete();

            $usuario = auth()->user()->id;        //obtenemos la instancia del usuario logueado
            $cuentatmpbienes = Tmpbien::where([['fkusuario', $usuario]])->count();    //estamos contando si hay registros raiz en la tabla Bienes.
            
            if($cuentatmpbienes != 0 )
            {
                $tmpbienes = Tmpbien::where('fkusuario', $usuario)->get();
                
                foreach ($tmpbienes as $item)
                {                
                 
                    $agregatmpbien = new Bien();
                    $agregatmpbien->fkarticulo = $item->fkarticulo;
                    $agregatmpbien->fkmarca = $item->fkmarca;
                    $agregatmpbien->modelo = $item->modelo;
                    $agregatmpbien->serie = $item->serie;
                    $agregatmpbien->patrimonio = $item->patrimonio;
                    if($request->funcionario != null)
                    {
                        $agregatmpbien->fkfuncionario = $request->funcionario;
                        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
                        $agregatmpbien->fecha = $fechaformat;
                    }                                                
                    $agregatmpbien->fkestado = $item->fkestado;
                    $agregatmpbien->observacion = $item->observacion;                    
                    $agregatmpbien->fkraiz = $id;
                    $agregatmpbien->fkusuario = auth()->user()->id;
                    if(isset($request->activo))
                    {
                        $agregatmpbien->activo = 1;
                    }
                        else
                    {
                        $agregatmpbien->activo = 0;
                    }
                    $agregatmpbien->save();
                 
                }
                  
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del bien con id:'.$actualizabien->idbien;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/bienes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Bien, editado correctamente!');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $modelo = Vbien::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminabien = Bien::findOrFail($id);
        $eliminabien->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del bien con id:'.$eliminabien->idbien;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Bien, eliminado correctamente!');       
    }
}