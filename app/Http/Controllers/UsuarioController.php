<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
Use App\Models\Bitacora;

class UsuarioController extends Controller
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
        $this->authorize('viewAny', User::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $usuarios = User::busqueda($vbusqueda)->orderBy('name', 'asc')->paginate(10);
        
        return view('usuarios.lista',compact('page', 'vbusqueda', 'usuarios'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        if($request->ajax()){
            $roles = Role::where('id', $request->role_id)->first();
            $permissions = $roles->permissions;
            return $permissions;
        }

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $roles = Role::all();

        return view('usuarios.crear', compact('page', 'vbusqueda', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'contraseña' => 'required|confirmed',
            'contraseña_confirmation' => 'required',
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $nuevousuario = new User();
        $nuevousuario->name = $request->nombre;
        $nuevousuario->email = $request->correo;
        if($request->contraseña != null)
        {
            $nuevousuario->password = Hash::make($request->contraseña);
        }
        $nuevousuario->save(); 

        if ($request->role != null) {
            $nuevousuario->roles()->attach($request->role);
            $nuevousuario->save(); 
        }

        if ($request->permissions != null) {
            foreach ($request->permissions as $item) {
                $nuevousuario->permissions()->attach($item);
                $nuevousuario->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nuevo usuario con id:'.$nuevousuario->id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/usuarios?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Usuario agregado correctamente!');
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
        $modelo = User::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;

        $usuarios = User::findOrFail($id);
        $roles = Role::all();
        $usuariorole = $usuarios->roles->first();
        if ($usuariorole != null) {
            $rolepermisos = $usuariorole->allRolePermissions;
        }
        else{
            $rolepermisos = null;
        }        
        $usuariopermisos = $usuarios->permissions;

        //dd($usuariopermisos);
    
        return view('usuarios.editar', compact('page', 'vbusqueda', 'roles', 'usuariorole', 'rolepermisos', 'usuariopermisos', 'usuarios'));
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
        $modelo = User::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'contraseña' => 'confirmed',
        ]);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
        
        $actualizausuario  = User::findOrFail($id);
        $actualizausuario->name = $request->nombre;
        $actualizausuario->email = $request->correo;
        if($request->contraseña != null)
        {
            $actualizausuario->password = Hash::make($request->contraseña);
        }
        $actualizausuario->save();

        $actualizausuario->roles()->detach();
        $actualizausuario->permissions()->detach();
        
        if ($request->role != null) {
            $actualizausuario->roles()->attach($request->role);
            $actualizausuario->save(); 
        }

        if ($request->permissions != null) {
            foreach ($request->permissions as $item) {
                $actualizausuario->permissions()->attach($item);
                $actualizausuario->save();
            }
        }

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición del usuario con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/usuarios?page='.$page.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Usuario editado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = User::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminausuario = User::findOrFail($id);
        $eliminausuario->roles()->detach();
        $eliminausuario->permissions()->detach();
        $eliminausuario->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación del usuario con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Usuario eliminado correctamente!');
    }
}
