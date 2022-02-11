<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Autoimg;
use App\Models\Bitacora;

class AutoimgController extends Controller
{
    //By CIRG - Protejer la ruta.
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|mimes:jpeg,jpg,png', 
        ]);

        $img = new Autoimg();
        $img->fkauto = $request->fkauto;
        if ($request->hasFile('imagen'))
        {
            $archivo = $request->file('imagen');
            $nombre = 'SGG-'.time();
            $extension = $request->file('imagen')->extension();
            $archivo->move(public_path().'/storage/auto/', $nombre.'.'.$extension);
            $img->imagen = $nombre.'.'.$extension;
        }
        if(isset($request->activo))
        {
            $img->activo = 1;
        }
        else
        {
            $img->activo = 0;
        }
        $img->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Nueva imagen con id:'.$img->idimg.' del auto en venta con id:'.$img->fkauto;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return back()->with('mensaje', '¡Imagen agregada correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $page = $request->page;
        $vfecha = $request->vfecha;
        $vactivo = $request->vactivo;
        $vorigen = $request->vorigen;
        $vbusqueda = $request->vbusqueda;

        $imgs = Autoimg::where('fkauto', $id)->orderBy('idimg', 'asc')->get();
        
        return view('autosimgs.lista', compact('imgs', 'id', 'page', 'vfecha', 'vactivo', 'vorigen', 'vbusqueda'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $ImgActualiza = Autoimg::findOrFail($id);
        if(isset($request->activo))
        {
            $ImgActualiza->activo = 1;
        }
        else
        {
            $ImgActualiza->activo = 0;
        }
        $ImgActualiza->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Publicación de la imagen con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        if(isset($request->activo))
        {
            return back()->withInput()->with('mensaje', '¡Imagen publicada correctamente!');
        }
        else
        {
            return back()->withInput()->with('mensaje', '¡Imagen escondida correctamente!');
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
        $imgs = Autoimg::findOrFail($id);
        $archivoimg = public_path().'/storage/auto/'.$imgs->imagen;
        if(file_exists($archivoimg))
        {
            unlink($archivoimg);
        }
        $imgs->delete();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Eliminación de la imagen con id:'.$id;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return back()->with('mensaje', '¡Imagen eliminada correctamente!');
    }
}
