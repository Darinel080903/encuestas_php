<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vbien;
use App\Models\Vhistorico;

class HistoricoController extends Controller
{
    // By CIRG - Protejer la ruta.
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function historico(Request $request, $id)
    {
        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $bien = Vbien::findOrFail($id);
        $data = Vhistorico::where('fkbien', $id)->orderBy('idhistorico', 'desc')->get();
    
        return view('historicos.lista',compact('page', 'vfecha', 'vbusqueda', 'bien', 'data'));  
        // return('cirg');
    }
}
