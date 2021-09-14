<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
// use PDF;
use App\Models\Funcionario;
use App\Models\Bien;
use App\Models\Articulo;
use App\Models\Area;
use App\Models\Vbien;
use App\Models\Vtmpbien;
use App\Models\Estado; 
use App\Models\Marca;
use App\Models\Operativo;
use App\Models\Cedula;
use App\Models\Tmpbien;
use App\Models\Vvale;
use App\Models\Vfolio;
use App\Models\Vfuncionario;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfresguardofuncionario(Request $request, $id)
    {  
        $vfecha = $request->vfecha;
          
        $funcionarios = Funcionario::findOrFail($id);
        $bienes = Vbien::where('fkfuncionario', $id)->get();
        $articulos = Articulo::orderBy('articulo', 'asc')->get();
        $marcas = Marca::orderBy('marca', 'asc')->get();      
        $areas = Area::where('idarea',3)->value('area');
        $operativos = Operativo::orderBy('operativo', 'asc')->get();
        
        return \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.myPDF', compact( 'vfecha', 'funcionarios','bienes', 'areas', 'articulos', 'marcas','operativos'))->stream('archivo.pdf');       
    }

    public function pdfvale(Request $request, $id)
    {  
        $vales = Vvale::findOrFail($id);

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w', strtotime($vales->fecha)));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n', strtotime($vales->fecha)));
        $fecha = $diaespañol.' '.date('d', strtotime($vales->fecha)).' de '.$mesespañol.' de '.date('Y', strtotime($vales->fecha));
            
        $folios = Vfolio::where('fkvale', $id)->orderBy('idfolio', 'asc')->get();

        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.vale', compact('fecha', 'vales', 'folios', 'autoriza', 'entrega'))->stream('archivo.pdf');
    }

    public function pdfpase(Request $request, $id)
    {  
        $pases = Vpase::findOrFail($id);

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w', strtotime($pases->fecha)));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n', strtotime($pases->fecha)));
        $fecha = $diaespañol.' '.date('d', strtotime($pases->fecha)).' de '.$mesespañol.' de '.date('Y', strtotime($pases->fecha));

        $detalles = Detalle::where('fkpase', $id);
            
        return \PDF::loadView('pdf.pase', compact('fecha', 'pases', 'folios', 'autoriza', 'entrega'))->stream('archivo.pdf');
    }
}