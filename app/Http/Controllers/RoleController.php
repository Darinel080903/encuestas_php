<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Permission;
Use App\Models\Bitacora;


class RoleController extends Controller
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
        $this->authorize('viewAny', Role::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $roles = Role::busqueda($vbusqueda)->orderBy('name', 'asc')->paginate(10);
        
        return view('roles.lista',compact('page', 'vbusqueda', 'roles'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Role::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        return view('roles.crear', compact('page', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $request->validate([
            'nombre' => 'required',
            'slug' => 'required'
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevorole = new Role();
        $nuevorole->name = $request->nombre;
        $nuevorole->slug = $request->slug;
        $nuevorole->save();

        if($request->permiso != '')
        {
            $listapermisos = explode(',', trim($request->permiso));
            foreach ($listapermisos  as $item)
            {
                $nuevopermiso = new Permission();
                $nuevopermiso->name = $item;
                $nuevopermiso->slug = strtolower(str_replace(' ', '-', $item));
                $nuevopermiso->save();
                $nuevorole->permissions()->attach($nuevopermiso->id);
                $nuevorole->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo rol con id:'.$nuevorole->id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/roles?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Rol agregado correctamente!');
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
        $modelo = Role::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $roles = Role::findOrFail($id);
           
        return view('roles.editar', compact('page', 'vbusqueda', 'roles'));
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
        $modelo = Role::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'nombre' => 'required',
            'slug' => 'required',
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualizarole  = Role::findOrFail($id);
        $actualizarole->name = $request->nombre;
        $actualizarole->slug = $request->slug;
        $actualizarole->save();

        $actualizarole->permissions()->delete();
        $actualizarole->permissions()->detach();
    
        if($request->permiso != '')
        {
            $listapermisos = explode(',', trim($request->permiso));
            foreach ($listapermisos  as $item)
            {
                $nuevopermiso = new Permission();
                $nuevopermiso->name = $item;
                $nuevopermiso->slug = strtolower(str_replace(' ', '-', $item));
                $nuevopermiso->save();
                $actualizarole->permissions()->attach($nuevopermiso->id);
                $actualizarole->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del rol con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/roles?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Rol editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Role::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminarole = Role::findOrFail($id);
        $eliminarole->permissions()->delete();
        $eliminarole->delete();
        $eliminarole->permissions()->detach();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del rol con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Rol eliminado correctamente!');
    }
}
