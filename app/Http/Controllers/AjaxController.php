<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Tmpbien;
use App\Models\Vtmpbien;
use App\Models\Bien;
use App\Models\Tipo;
use App\Models\Auto;
use App\Models\Funcionario;
use App\Models\Desglose;
use App\Models\Factura;
use App\Models\Folio;

class AjaxController extends Controller
{
    public function cargarcampos(Request $request, $id)
    {
        if($request->ajax())
        {            
            $campos = Articulo::findOrFail($id);
            return response()->json($campos);
        }
        
    }
    
    public function tmpguardarbien(Request $request)
    {

         if($request->ajax())
        {          
            //creacion de validaciones
            $usuario = auth()->user()->id;
            $cuentatmpbienes = Tmpbien::where([['serie', $request->seriemodal], ['patrimonio', $request->patrimoniomodal], ['fkusuario', $usuario]])->count();
            $cuentabienes = Bien::where([['serie', $request->seriemodal], ['patrimonio', $request->patrimoniomodal]])->count();

            if($cuentatmpbienes == 0 && $cuentabienes == 0 ) //condicion de busqueda en tablas
            {
                 //guardar
                $tmpdependencia = new Vtmpbien();
                $tmpdependencia->fkarticulo = $request->articulomodal;
                $tmpdependencia->fkmarca = $request->marcamodal;
                $tmpdependencia->modelo = $request->modelomodal;
                $tmpdependencia->serie = $request->seriemodal;
                $tmpdependencia->patrimonio = $request->patrimoniomodal;
                $tmpdependencia->fkestado = $request->estadomodal;
                $tmpdependencia->observacion = $request->observacionmodal;
                $tmpdependencia->fkusuario = auth()->user()->id;
                $tmpdependencia->save();
                //guardar

                $retorno = Vtmpbien::where('fkusuario', $usuario)->get();
            }
            else if($cuentatmpbienes != 0 && $cuentabienes == 0)
            {
                $retorno = 'R';
            } 
            else if($cuentatmpbienes == 0 && $cuentabienes != 0)
            {
                $retorno = 'R';
            }
            
            return response()->json($retorno);
        }
    }

    public function eliminartmpbien($id) 
    {
        $usuario = auth()->user()->id;
        // delete        
        $eliminatmpbien = Tmpbien::findOrFail($id);
        $eliminatmpbien->delete();
       
        $retorno = Vtmpbien::where('fkusuario', $usuario)->get(); 
        return response()->json($retorno);
           
    }

    public function limpiartmpbien() 
    {
        
         $usuario = auth()->user()->id;
                
         $limpiatmpbien = Tmpbien::where('fkusuario', $usuario);
         $limpiatmpbien->delete();
       
         return response('Y');
                   
    }

    public function cargartipos(Request $request, $id)
    {
        if($request->ajax())
        {
            $tipos = Tipo::where('fkfabrica', $id)->orderBy('tipo', 'asc')->get();
            return response()->json($tipos);
        }
    }

    public function cargafuncionario(Request $request, $id)
    {
        if($request->ajax())
        {
            $idfuncionario = Auto::where('idauto', $id)->value('fkfuncionario');
            $funcionario = Funcionario::where('idfuncionario', $idfuncionario)->get();
            return response()->json($funcionario);
        }
    }

    public function cargaconceptos(Request $request, $id)
    {
        if($request->ajax())
        {
            $desgloses = Desglose::where('fkfactura', $id)->get();
            return response()->json($desgloses);
        }
    }

    public function cargamontos(Request $request, $id)
    {
        if($request->ajax())
        {
            $montos = Factura::findOrFail($id);
            return response()->json($montos);
        }
    }

    public function cargasaldos(Request $request, $id)
    {
        if($request->ajax())
        {
            $saldos = Folio::where('fkfactura', $id)->sum('monto');
            return response()->json($saldos);
        }
    }

    public function cargaunidades(Request $request, $id)
    {
        if($request->ajax())
        {
            $numero = Desglose::where('iddesglose', $id)->value('numero');
            $unidades = Folio::where('fkdesglose', $id)->sum('numero');
            $disponible = $numero - $unidades;
            return response()->json($disponible);
        }
    }

    public function cargaunitarios(Request $request, $id)
    {
        if($request->ajax())
        {
            $unitario = Desglose::where('iddesglose', $id)->value('unitario');
            return response()->json($unitario);
        }
    }
}