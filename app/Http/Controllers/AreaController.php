<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Area;
Use App\Models\Bitacora;

class AreaController extends Controller
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
        $this->authorize('viewAny', Area::class);

        $page = $request->page;
        $vbusqueda = $request->vbusqueda;
    
        // $areas = Area::busqueda($vbusqueda)->whereNull('fkarea')->orderBy('area', 'asc')->paginate(10);

        $areas = Area::whereNull('fkarea')->get();

        $areastodas = Area::all();
    
        return view('areas.lista',compact('page', 'vbusqueda', 'areas', 'areastodas'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Area::class);

        $areas = Area::whereNull('fkarea')->get();
        return view('areas.crear', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Area::class);

        $request->validate([
            'area' => 'required'
        ]);

        $nuevaarea = new Area();  
        $nuevaarea->fkarea = $request->fkarea;
        $nuevaarea->area = $request->area;
        if(isset($request->activo))
        {
            $nuevaarea->activo = 1;
        }
        else
        {
            $nuevaarea->activo = 0;
        }
        $nuevaarea->save();

        $actualizaarea = Area::findOrFail($nuevaarea->idarea);
        $queries = DB::select("SELECT FindRootNode($nuevaarea->idarea) AS ruta;");
        $actualizaarea->ruta = $queries[0]->ruta;
        $data = $queries[0]->ruta;
        $j = 0;
        foreach (count_chars($data, 1) as $i => $val)
        {
            if(chr($i) == '.')
            {
                $j = $val;
            }
        }
        $actualizaarea->nivel = $j;
        $actualizaarea->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Área agregada con id:'.$nuevaarea->idarea;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/areas')->with('mensaje','¡Área agregada correctamente!');
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
    public function edit($id)
    {
        $modelo = Area::findOrFail($id);
        $this->authorize('update', $modelo);

        $area = Area::findOrFail($id);
        $areas = Area::whereNull('fkarea')->get();
        return view('areas.editar',compact('areas', 'area'));
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
        $modelo = Area::findOrFail($id);
        $this->authorize('update', $modelo);

        $request->validate([
            'area' => 'required'
        ]);

        $actualizaarea = Area::findOrFail($id);
        $actualizaarea->fkarea = $request->fkarea;
        $actualizaarea->area = $request->area;
        if(isset($request->activo))
        {
            $actualizaarea->activo = 1;
        }
        else
        {
            $actualizaarea->activo = 0;
        }
        $actualizaarea->save();

        $actualizaarea = Area::findOrFail($id);
        $queries = DB::select("SELECT FindRootNode($id) AS ruta;");
        $actualizaarea->ruta = $queries[0]->ruta;
        $data = $queries[0]->ruta;
        $j = 0;
        foreach (count_chars($data, 1) as $i => $val)
        {
            if(chr($i) == '.')
            {
                $j = $val;
            }
        }
        $actualizaarea->nivel = $j;
        $actualizaarea->save();
        
        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Área editada con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return redirect('/areas')->with('mensaje','¡Área editada correctamente!');
    }

    public function update2(Request $request, $id)
    {
         
        $actualizaarea = Area::findOrFail($id);
        if(isset($request->activo))
        {
            $actualizaarea->activo = 1;
        }
        else
        {
            $actualizaarea->activo = 0;
        }
        $actualizaarea->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $bitacora->operacion = 'Área activada correctamente con id:'.$id;
        }
        else
        {
            $bitacora->operacion = 'Área desactivada correctamente con id:'.$id;
        }
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', '¡Área activada correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', '¡Área desactivada correctamente!');
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
        $modelo = Area::findOrFail($id);
        $this->authorize('delete', $modelo);
        
        $eliminaarea = Area::findOrFail($id);
        $eliminaarea->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación de la área con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();
        
        return back()->withInput()->with('mensaje', '¡Área eliminada correctamente!');
    }
}
