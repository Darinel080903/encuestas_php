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

        $bienes = Vbien::fecha($vfecha)->busqueda($vbusqueda)->orderBy('idbien', 'asc')->orderBy('fkraiz', 'asc')->paginate(20);
    
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
        $articulosmodal = Articulo::where('raiz', '<>', 1)->orwhereNull('raiz')->orderBy('articulo', 'asc')->get();
        $articulos = Articulo::orderBy('articulo', 'asc')->get();        
        $marcas = Marca::orderBy('marca', 'asc')->get();
        $operativos = Operativo::orderBy('operativo', 'asc')->get();
        $cedulas = Cedula::orderBy('fecha', 'asc')->get();
        $estados = Estado::orderBy('idestado', 'asc')->get();
        $areas = Area::whereNull('fkarea')->get();
        $funcionarios = Funcionario::where('activo', 1)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();

        return view('bienes.crear', compact('page', 'vfecha', 'vbusqueda', 'bienesmodal', 'articulosmodal', 'articulos', 'marcas', 'operativos', 'cedulas', 'estados', 'areas', 'funcionarios'));
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
            'estado' => 'required'
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
        $nuevobien->fkcedula = $request->cedula;
        $nuevobien->fkestado = $request->estado;
        $nuevobien->observacion = $request->observacion;
        if($request->funcionario != null)
        {
            $nuevobien->fkfuncionario = $request->funcionario;
            $nuevobien->fecha = date('Y-m-d');
        }
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

        $historico = new Historico();
        $historico->fecha = date('Y-m-d H:i');
        $historico->accion = 'Alta';
        $historico->fkbien = $nuevobien->idbien;
        $historico->fkusuario = auth()->user()->id;
        $historico->save();

        if($request->funcionario != null)
        {
            $historico = new Historico();
            $historico->fecha = date('Y-m-d H:i');
            $historico->accion = 'Resguardo';
            $historico->fkbien = $nuevobien->idbien;
            $historico->fkfuncionario = $request->funcionario;
            $historico->fkusuario = auth()->user()->id;
            $historico->save();
        }

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
                        $nuevotmpbien->fkestado = $item->fkestado;
                        $nuevotmpbien->observacion = $item->observacion;
                        $nuevotmpbien->fkraiz = $nuevobien->idbien;
                        if($request->funcionario != null)
                        {
                            $nuevotmpbien->fkfuncionario = $request->funcionario;
                            $nuevotmpbien->fecha = date('Y-m-d');
                        }
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

                        $historico = new Historico();
                        $historico->fecha = date('Y-m-d H:i');
                        $historico->accion = 'Alta';
                        $historico->fkbien = $nuevotmpbien->idbien;
                        $historico->fkusuario = auth()->user()->id;
                        $historico->save();

                        if($request->funcionario != null)
                        {
                            $historico = new Historico();
                            $historico->fecha = date('Y-m-d H:i');
                            $historico->accion = 'Resguardo';
                            $historico->fkbien = $nuevotmpbien->idbien;
                            $historico->fkfuncionario = $request->funcionario;
                            $historico->fkusuario = auth()->user()->id;
                            $historico->save();
                        }
                    }
                    elseif($item->origen == 'i')
                    {
                        $idbien = Bien::Where([['serie', $item->serie], ['patrimonio', $item->patrimonio]])->value('idbien');
                        $actualizabien = Bien::findOrFail($idbien);
                        $actualizabien->observacion = $item->observacion;
                        $actualizabien->fkraiz = $nuevobien->idbien;
                        if($request->funcionario != null)
                        {
                            $historico = new Historico();
                            $historico->fecha = date('Y-m-d H:i');
                            $historico->accion = 'Resguardo';
                            $historico->fkbien = $idbien;
                            $historico->fkfuncionario = $request->funcionario;
                            $historico->fkusuario = auth()->user()->id;
                            $historico->save();

                            $actualizabien->fkfuncionario = $request->funcionario;
                            $actualizabien->fecha = date('Y-m-d');
                        }
                        else
                        {
                            $actualizabien->fkfuncionario = null;
                            $actualizabien->fecha = date('Y-m-d');
                        }
                        if(isset($request->activo))
                        {
                            $actualizabien->activo = 1;
                        }
                        else
                        {
                            $actualizabien->activo = 0;
                        }
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
        $bienesmodal = Vbien::where([['raiz', null], ['fkraiz', null], ['fkfuncionario', null], ['activo', 1]])->get();
        $articulosmodal = Articulo::where('raiz', '<>', 1)->orwhereNull('raiz')->orderBy('articulo', 'asc')->get();
        $articulos = Articulo::orderBy('articulo', 'asc')->get();        
        $marcas = Marca::orderBy('marca', 'asc')->get();
        $operativos = Operativo::orderBy('operativo', 'asc')->get();
        $cedulas = Cedula::orderBy('fecha', 'asc')->get();
        $estados = Estado::orderBy('idestado', 'asc')->get();
        $areas = Area::whereNull('fkarea')->get();
        $funcionarios = Funcionario::where('activo', 1)->orderBy('nombre', 'asc')->orderBy('paterno', 'asc')->orderBy('materno', 'asc')->get();
        
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
            $agregabien->origen = 'i';
            $agregabien->fkusuario = auth()->user()->id;
            $agregabien->save();
        }

        // registros que se van a la tabla temporal.                                        
        $tmpbienes = Vtmpbien::Where('fkusuario', $usuario)->get();
        
        if($bienes->fkraiz)
        {
            $bienraiz = Bien::findOrFail($bienes->fkraiz);
        }
        else
        {
            $bienraiz = null;
        }
    
        return view('bienes.editar', compact('page', 'vfecha', 'vbusqueda', 'bienesmodal', 'articulos', 'articulosmodal', 'marcas', 'operativos', 'areas', 'funcionarios', 'estados', 'cedulas', 'bienes', 'raiz', 'tmpbienes', 'bienraiz'));
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
            'estado' => 'required'
        ]);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $validar = Bien::where([['idbien', '<>', $id], ['serie', $request->serie]])->orWhere([['idbien', '<>', $id], ['patrimonio', $request->patrimonio]])->count();
        
        if($validar > 0)
        {
            return back()->withInput()->with('mensaje', '¡Error, numero de serie o número de patrimonio existente en el inventario!');
        }
        
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
        $actualizabien->fkcedula = $request->cedula;
        $actualizabien->fkestado = $request->estado;
        $actualizabien->observacion = $request->observacion;
        if($request->funcionario != null)
        {
            if($actualizabien->fkfuncionario != $request->funcionario)
            {
                if($actualizabien->fkfuncionario != null)
                {
                    $historico = new Historico();
                    $historico->fecha = date('Y-m-d H:i');
                    $historico->accion = 'Baja';
                    $historico->fkbien = $id;
                    $historico->fkfuncionario = $actualizabien->fkfuncionario;
                    $historico->fkusuario = auth()->user()->id;
                    $historico->save();
                }

                $historico = new Historico();
                $historico->fecha = date('Y-m-d H:i');
                $historico->accion = 'Resguardo';
                $historico->fkbien = $id;
                $historico->fkfuncionario = $request->funcionario;
                $historico->fkusuario = auth()->user()->id;
                $historico->save();

                $actualizabien->fkfuncionario = $request->funcionario;
                $actualizabien->fecha = date('Y-m-d');
            }
        }
        else
        {
            if($actualizabien->fkfuncionario != null)
            {
                $historico = new Historico();
                $historico->fecha = date('Y-m-d H:i');
                $historico->accion = 'Baja';
                $historico->fkbien = $id;
                $historico->fkfuncionario = $actualizabien->fkfuncionario;
                $historico->fkusuario = auth()->user()->id;
                $historico->save();
            }

            $actualizabien->fkfuncionario = null;
            $actualizabien->fecha = date('Y-m-d');
        }
        if(isset($request->activo))
        {
            $actualizabien->activo = 1;
        }
        else
        {
            $actualizabien->activo = 0;
        }
        $actualizabien->save();

        $articulos = Articulo::findOrFail($request->articulo);

        if($articulos->raiz == 1)
        {
            $usuario = auth()->user()->id;

            $cuentabienes = Bien::where('fkraiz', $id)->count();
            if($cuentabienes > 0)
            {
                $bienes = Bien::where('fkraiz', $id)->get();
                foreach ($bienes as $item)
                {
                    $cuentatmpbien = Tmpbien::where([['fkusuario', $usuario], ['patrimonio', $item->patrimonio]])->count();
                    if($cuentatmpbien == 0)
                    {
                        $desasociabien = Bien::findOrFail($item->idbien);
                        $desasociabien->fkraiz = null;
                        $desasociabien->save();
                    }
                }
            }

            $cuentatmpbienes = Tmpbien::where('fkusuario', $usuario)->count();
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
                        $nuevotmpbien->fkestado = $item->fkestado;
                        $nuevotmpbien->observacion = $item->observacion;
                        $nuevotmpbien->fkraiz = $id;
                        if($request->funcionario != null)
                        {
                            $nuevotmpbien->fkfuncionario = $request->funcionario;
                            $nuevotmpbien->fecha = date('Y-m-d');
                        }
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

                        $historico = new Historico();
                        $historico->fecha = date('Y-m-d H:i');
                        $historico->accion = 'Alta';
                        $historico->fkbien = $nuevotmpbien->idbien;
                        $historico->fkusuario = auth()->user()->id;
                        $historico->save();

                        if($request->funcionario != null)
                        {
                            $historico = new Historico();
                            $historico->fecha = date('Y-m-d H:i');
                            $historico->accion = 'Resguardo';
                            $historico->fkbien = $nuevotmpbien->idbien;
                            $historico->fkfuncionario = $request->funcionario;
                            $historico->fkusuario = auth()->user()->id;
                            $historico->save();
                        }
                    }
                    elseif($item->origen == 'i')
                    {
                        $idbien = Bien::Where([['serie', $item->serie], ['patrimonio', $item->patrimonio]])->value('idbien');
                        $actualizabien = Bien::findOrFail($idbien);
                        $actualizabien->observacion = $item->observacion;
                        $actualizabien->fkraiz = $id;
                        if($request->funcionario != null)
                        {
                            if($actualizabien->fkfuncionario != $request->funcionario)
                            {
                                if($actualizabien->fkfuncionario != null)
                                {
                                    $historico = new Historico();
                                    $historico->fecha = date('Y-m-d H:i');
                                    $historico->accion = 'Baja';
                                    $historico->fkbien = $idbien;
                                    $historico->fkfuncionario = $actualizabien->fkfuncionario;
                                    $historico->fkusuario = auth()->user()->id;
                                    $historico->save();
                                }

                                $historico = new Historico();
                                $historico->fecha = date('Y-m-d H:i');
                                $historico->accion = 'Resguardo';
                                $historico->fkbien = $idbien;
                                $historico->fkfuncionario = $request->funcionario;
                                $historico->fkusuario = auth()->user()->id;
                                $historico->save();
                            }

                            $actualizabien->fkfuncionario = $request->funcionario;
                            $actualizabien->fecha = date('Y-m-d');
                        }
                        else
                        {
                            if($actualizabien->fkfuncionario != null)
                            {
                                $historico = new Historico();
                                $historico->fecha = date('Y-m-d H:i');
                                $historico->accion = 'Baja';
                                $historico->fkbien = $idbien;
                                $historico->fkfuncionario = $actualizabien->fkfuncionario;
                                $historico->fkusuario = auth()->user()->id;
                                $historico->save();
                            }
                            
                            $actualizabien->fkfuncionario = null;
                            $actualizabien->fecha = date('Y-m-d');
                        }
                        $actualizabien->save();
                    }
                }
            }

            $limpiatmpbienes = Tmpbien::where('fkusuario', $usuario);
            $limpiatmpbienes->delete();
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
    
    public function desasociar(Request $request, $id)
    {
        $modelo = Vbien::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'articulo' => 'required',
            'marca' => 'required',
            'serie' => 'required',
            'patrimonio' => 'required',
            'estado' => 'required'
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
        $actualizabien->fkcedula = $request->cedula;
        $actualizabien->fkestado = $request->estado;
        $actualizabien->observacion = $request->observacion;
        $actualizabien->save();

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