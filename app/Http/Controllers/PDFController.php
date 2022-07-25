<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
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
use App\Models\Vfuncionariocustodia;
use App\Models\Solicitud;
use App\Models\Servicio;
use App\Models\Vservicio;
use App\Models\Vsolicitud;
use App\Models\Vpase;
use App\Models\Vauto;
use App\Models\Vcompra;
use App\Models\Desglose;
use App\Models\Detalle;
use App\Models\Vhistorico;
use App\Models\Historico;
use App\Models\Vpemexvale;
use App\Models\Vpemexfolio;


class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfresguardo(Request $request)
    {  
        $request->validate([
            'funcionario' => 'required'
        ]);

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w'));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n'));
        $fecha = $diaespañol.' '.date('d').' de '.$mesespañol.' de '.date('Y');
        
        $funcionario = Vfuncionario::findOrFail($request->funcionario);
        $bienes = Vbien::where('fkfuncionario', $request->funcionario)->get();
        $entrega = Vfuncionario::where([['otorga', 1], ['activo', 1]])->first();
        
        // return \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.myPDF', compact( 'vfecha', 'funcionarios','bienes', 'areas', 'articulos', 'marcas','operativos'))->stream('archivo.pdf');
        return \PDF::loadView('pdf.imprimirresguardo', compact( 'fecha', 'funcionario', 'bienes', 'entrega'))->stream('archivo.pdf');
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

        $detalles = Detalle::where('fkpase', $id)->get();
            
        return \PDF::loadView('pdf.imprimirpase', compact('fecha', 'pases', 'detalles'))->stream('archivo.pdf');
    }

    public function pdfdevolucion(Request $request)
    {  
        $request->validate([
            'funcionario' => 'required'
        ]);

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w'));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n'));
        $fecha = $diaespañol.' '.date('d').' de '.$mesespañol.' de '.date('Y');

        $ids = [''];
        $detalles = json_decode($request->detalle);

        if($detalles)
        {
            foreach ($detalles as $key => $item) 
            {   
                $ids[$key] = [$item->idhistorico];
            }
        }

        $funcionario = Vfuncionario::findOrFail($request->funcionario);
        $devoluciones = Vhistorico::where('fkaccion', 4)->whereIn('idhistorico', $ids)->get();
        $responsable = Vfuncionario::where([['responsable', 1], ['fkarea', 2], ['activo', 1]])->orderBY('idfuncionario', 'desc')->limit(1)->get();
        
        return \PDF::loadView('pdf.imprimirdevolucion', compact('fecha', 'funcionario', 'devoluciones', 'responsable'))->stream('archivo.pdf');
    }

    public function pdfretorno(Request $request)
    {  
        $request->validate([
            'funcionario' => 'required'
        ]);
        
        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w'));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n'));
        $fecha = $diaespañol.' '.date('d').' de '.$mesespañol.' de '.date('Y');

        $ids = [''];
        $detalles = json_decode($request->detalle);

        if($detalles)
        {
            foreach ($detalles as $key => $item) 
            {
                $actualizabien = Bien::findOrFail($item->idbien);
                $actualizabien->fkraiz = null;
                $actualizabien->fkfuncionario = null;
                $actualizabien->fecha = date('Y-m-d H:i');
                $actualizabien->save();

                $historico = new Historico();
                $historico->fecha = date('Y-m-d H:i');
                $historico->fkaccion = 4;
                // $historico->accion = 'Devolución';
                $historico->fkbien = $item->idbien;
                $historico->fkfuncionario = $request->funcionario;
                $historico->fkusuario = auth()->user()->id;
                $historico->save();

                $ids[$key] = [$historico->idhistorico];
            }
        }

        $funcionario = Vfuncionario::findOrFail($request->funcionario);
        $devoluciones = Vhistorico::where('fkaccion', 4)->whereIn('idhistorico', $ids)->get();
        $responsable = Vfuncionario::where([['responsable', 1], ['fkarea', 2], ['activo', 1]])->orderBY('idfuncionario', 'desc')->limit(1)->get();
        
        return \PDF::loadView('pdf.imprimirdevolucion', compact('fecha', 'funcionario', 'devoluciones', 'responsable'))->stream('archivo.pdf');
    }

    public function pdfpemexvale(Request $request, $id)
    {  
        $vales = Vpemexvale::findOrFail($id);

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w', strtotime($vales->fecha)));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n', strtotime($vales->fecha)));
        $fecha = $diaespañol.' '.date('d', strtotime($vales->fecha)).' de '.$mesespañol.' de '.date('Y', strtotime($vales->fecha));
            
        $folios = Vpemexfolio::where('fkvale', $id)->orderBy('idfolio', 'asc')->get();

        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.pemexvale', compact('fecha', 'vales', 'folios', 'autoriza', 'entrega'))->stream('archivo.pdf');
    }

    public function pdfreportevale(Request $request)
    {  
        
        $vales = Vvale::ejercicio($request->ejercicio)->factura($request->factura)->orderBy('fecha', 'asc')->get();
        $vale = Vvale::ejercicio($request->ejercicio)->factura($request->factura)->orderBy('fecha', 'asc')->sum('monto');      
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
                
        return \PDF::loadView('pdf.imprimirvale', compact('autoriza', 'vales', 'vale'))->stream('archivo.pdf');
    }

    public function pdfsolicitud(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);
        $desgloses = Vcompra::where('fksolicitud', $id)->orderBy('idcompra', 'asc')->get();                    

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w', strtotime($solicitudes->fechafactura)));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n', strtotime($solicitudes->fechafactura)));
        $fechafactura = $diaespañol.' '.date('d', strtotime($solicitudes->fechafactura)).' de '.$mesespañol.' de '.date('Y', strtotime($solicitudes->fechafactura));
                
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.solicitud', compact('autoriza', 'entrega', 'solicitudes', 'fechafactura', 'desgloses'))->stream('archivo.pdf');
    }

    public function pdfsolicitudvehicular(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);        
        $servicios = Servicio::where('fksolicitud', $id)->first();      
        $autos = Vauto::where([['idauto', $servicios->fkauto], ['activo', 1]])->first();
               
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.solicitudvehicular', compact('autoriza', 'entrega', 'solicitudes', 'autos'))->stream('archivo.pdf');
    }

    public function pdfconformidad(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);        
        $servicios = Servicio::where('fksolicitud', $id)->first();      
        $autos = Vauto::where([['idauto', $servicios->fkauto], ['activo', 1]])->first();
        $auto = Vfuncionariocustodia::where([['fkauto', $autos->idauto], ['activo', 1]])->orderBy('fkfuncionario', 'desc')->first();
               
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.conformidad', compact('autoriza', 'entrega', 'solicitudes', 'autos', 'auto'))->stream('archivo.pdf');
    }

    public function pdfsolicitudinmueble(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);                
        $servicios = Vservicio::where('fksolicitud', $id)->first();      
                       
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.solicitudinmueble', compact('autoriza', 'entrega', 'solicitudes', 'servicios'))->stream('archivo.pdf');
    }

    public function pdfconformidadinmueble(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);        
        $servicios = Vservicio::where('fksolicitud', $id)->first();      
                      
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.conformidadinmueble', compact('autoriza', 'entrega', 'solicitudes', 'servicios'))->stream('archivo.pdf');
    }

    public function pdfsolicitudmueble(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);                
        $servicios = Vservicio::where('fksolicitud', $id)->first();      
                       
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.solicitudmueble', compact('autoriza', 'entrega', 'solicitudes', 'servicios'))->stream('archivo.pdf');
    }

    public function pdfconformidadmueble(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);        
        $servicios = Vservicio::where('fksolicitud', $id)->first();      
                      
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.conformidadmueble', compact('autoriza', 'entrega', 'solicitudes', 'servicios'))->stream('archivo.pdf');
    }

    public function pdfordencompra(Request $request, $id)
    {           
        $solicitudes = Vsolicitud::findOrFail($id);                
        $desgloses = Vcompra::where('fksolicitud', $id)->orderBy('idcompra', 'asc')->get();    
                        
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.ordencompra', compact('autoriza', 'entrega', 'solicitudes', 'desgloses'))->stream('archivo.pdf');
    }
    public function pdfsolicitudcompra(Request $request, $id)
    {           
        $solicitudes = Vsolicitud::findOrFail($id);                
        $desgloses = Vcompra::where('fksolicitud', $id)->orderBy('idcompra', 'asc')->get();    
                        
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.solicitudcompra', compact('autoriza', 'entrega', 'solicitudes', 'desgloses'))->stream('archivo.pdf');
    }

    public function pdfconstanciaretenciones(Request $request, $id)
    {           
        $solicitudes = Vsolicitud::findOrFail($id);
        $servicios = Vservicio::where('fksolicitud', $id)->first();                
        //$desgloses = Vcompra::where('fksolicitud', $id)->orderBy('idcompra', 'asc')->get();    
                        
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.constanciaretenciones', compact('autoriza', 'entrega', 'solicitudes', 'servicios'))->stream('archivo.pdf');
    }

    public function pdfsolicitudservicio(Request $request, $id)
    {   
        $solicitudes = Vsolicitud::findOrFail($id);
        $desgloses = Vcompra::where('fksolicitud', $id)->orderBy('idcompra', 'asc')->get();            

        $dias = ['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'];
        $diaespañol = Arr::get($dias, date('w', strtotime($solicitudes->fechafactura)));
        $meses = ['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $mesespañol = Arr::get($meses, date('n', strtotime($solicitudes->fechafactura)));
        $fechafactura = $diaespañol.' '.date('d', strtotime($solicitudes->fechafactura)).' de '.$mesespañol.' de '.date('Y', strtotime($solicitudes->fechafactura));
                
        $autoriza = Vfuncionario::where([['autoriza', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        $entrega = Vfuncionario::where([['entrega', 1],['activo', 1]])->orderBy('idfuncionario', 'desc')->first();
        
        return \PDF::loadView('pdf.solicitudservicio', compact('autoriza', 'entrega', 'solicitudes', 'fechafactura'))->stream('archivo.pdf');
    }
}