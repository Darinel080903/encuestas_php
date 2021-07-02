<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
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
        
               
        return \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.myPDF', compact( 'vfecha', 'funcionarios','bienes', 'areas', 'articulos', 'marcas','operativos',))->stream('archivo.pdf');
        
           
    }
}
