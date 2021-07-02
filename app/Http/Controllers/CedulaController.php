<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cedula;
Use App\Models\Bitacora;


class CedulaController extends Controller
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
        $this->authorize('viewAny', Cedula::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $cedulas = Cedula::fecha($vfecha)->busqueda($vbusqueda)->orderBy('fecha', 'desc')->paginate(10);
    
        return view('cedulas.lista',compact('page', 'vfecha', 'vbusqueda', 'cedulas'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Cedula::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        return view('cedulas.crear', compact('page', 'vfecha', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cedula::class);

        $request->validate([
            'fecha' => 'required',
            'cedula' => 'required'
        ]);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;
        
        $nuevacedula = new Cedula();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevacedula->fecha = $fechaformat;
        $nuevacedula->cedula = $request->cedula;
        $nuevacedula->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nueva cédula con id:'.$nuevacedula->idfuncionario;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/cedulas?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Cédula agregada correctamente!');
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
        $modelo = Cedula::findOrFail($id);
        $this->authorize('update', $modelo);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $cedulas = Cedula::findOrFail($id);

        return view('cedulas.editar',compact('page', 'vfecha', 'vbusqueda', 'cedulas'));
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
        $modelo = Cedula::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'fecha' => 'required',
            'cedula' => 'required'
        ]);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;
        
        $actualizacedula = Cedula::findOrFail($id);
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $actualizacedula->fecha = $fechaformat;
        $actualizacedula->cedula = $request->cedula;
        $actualizacedula->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Edición de la cédula con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/cedulas?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)->with('mensaje','¡Cédula editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $modelo = Cedula::findOrFail($id);
        $this->authorize('delete', $modelo);

        $eliminacedula = Cedula::findOrFail($id);
        $eliminacedula->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación de la cédula con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Cédula eliminada correctamente!');
    }
}
