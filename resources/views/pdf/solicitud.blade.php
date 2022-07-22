<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Solicitud</title>
        <link rel="icon" href="{{asset('storage/ico/favicon.ico')}}">
        
        <!-- Bootstrap CSS -->
        <script src="{{public_path('/js/app.js')}}"></script>
        <link href="{{public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 50px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 10px;
                right: 10px;
                height: 80px;

                /** Extra personal styles **/
                /* background-color: #03a9f4; */
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 10px; 
                right: 10px;
                height: 200px; 

                /** Extra personal styles **/
                /* background-color: #03a9f4; */
                color: white;
                text-align: center;
                /* line-height: 35px; */
            }
            .page-break {
                page-break-after: always;
            }
            .parentesis{
                float: right;                
            }

        </style>
    </head>
    <body>
        <header>
            <img class="float-left" src="{{ public_path('/storage/escudo/secretaria-general-de-gobierno.png') }}" alt="SGG">
            <img class="float-right mt-4" src="{{ public_path('/storage/escudo/chiapas-corazon-claro.png') }}" alt="Chiapas de Corazón">
        </header>
        <br>
        <h5 class="text-center mb-0"><small><b>SECRETARIA GENERAL DE GOBIERNO</b></small></h5> 
        <h5 class="text-center mb-0"><small><b>UNIDAD DE APOYO ADMINISTRATIVO</b></small></h5> 
        <h5 class="text-center mb-0"><small><b>AREA DE RECURSOS MATERIALES Y SERVICIOS GENERALES</b></small></h5> 
        <br>        
       
        <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th scope="col" width="15%">Solicitud No:</th>
                <th scope="col" width="10%"> </th>
                <th scope="col" width="10%" class="border-top-0"></th>
                <th scope="col" width="15%">Fecha de tramite</th>
                <th scope="col" width="10%"></th>
                <th scope="col" width="10%">{{date('d/m/Y', strtotime($solicitudes->fecha))}}</th>
              </tr>
            </thead>            
          </table>
                      
        <table class="table table-bordered table-sm">            
            <tbody>
              <tr>
                <th scope="row" width="20%" class="align-middle mt-0 mb-0"><small>Beneficiario:</small></th>
                <td><small> {{ $solicitudes->proveedor}} </small></td>                
              </tr>
              <tr>
                <th scope="row" class="align-middle"><small>R.F.C.:</small></th>
                <td><small>{{ $solicitudes->rfc.'-'.$solicitudes->homoclave}}</small></td>                
              </tr>
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Fecha:</small></th>
                <td><small>{{ $fechafactura }}</small></td> 
              </tr>
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Partida:</small></th>
                <td><small>{{ $solicitudes->clavepartida.'-'.$solicitudes->partida}}</small></td> 
              </tr>
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Clave presupuestante:</small></th>
                <td><small>{{ $solicitudes->clavepresupuestal}}</small></td> 
              </tr>
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Área solicitante:</small></th>
                <td><small>{{ $solicitudes->area}}</small></td> 
              </tr>
            </tbody>
        </table>
        
        {{-- <div class="row">
            <div class="col"><hr style="border: 1px solid 000;"></div>
        </div> --}}
        
        <div class="row">
            <div class="col">
                <table border="1" style="width: 100%;">             
                    <tr>
                        <th class="text-center" BGCOLOR="gray">No. de comprobante</th>
                        <th class="text-center" BGCOLOR="gray">Concepto</th>
                        <th class="text-center" BGCOLOR="gray">Importe</th>
                        <th class="text-center" BGCOLOR="gray">Ajuste</th>
                        <th class="text-center" BGCOLOR="gray">Neto a pagar</th>                       
                    </tr><br>                    
                        <tr>
                            <td class="text-center">{{$solicitudes->factura}}</td>
                            <td class="text-center">{{$solicitudes->descripcion}}</td> 
                            <td class="text-center">$ {!! number_format((float)($solicitudes->subtotal + $solicitudes->ajuste), 2) !!} </td>
                            <td class="text-center">$ {!! number_format((float)($solicitudes->ajuste), 2) !!}</td>
                            <td class="text-center">$ {!! number_format((float)($solicitudes->total  - $solicitudes->ajuste), 2) !!}</td>                                                       
                        </tr>                    
                    <tr>
                        <td colspan="2"></td>
                        {{-- <td class="text-center">Total</td> --}}
                        <td class="text-center">$ {!! number_format((float)($solicitudes->subtotal + $solicitudes->ajuste), 2) !!}</td>
                        <td class="text-center">$ {!! number_format((float)($solicitudes->ajuste), 2) !!}</td>
                        <td class="text-center">$ {!! number_format((float)($solicitudes->total - $solicitudes->ajuste), 2) !!}</td>                                                       
                        {{-- <td class="text-center">{!! number_format((float)($solicitudes->total)) !!} Lt.</td> --}}
                    </tr>
                </table>
            </div>
        </div>

        <table class="table table-borderless">            
            <tbody>                              
                <tr>
                    <td class="p-0"><b> Concepto de ajuste: {!! nl2br(e($solicitudes->concepto)) !!} </b> </td>  
                                                                            
                </tr>                
            </tbody>
        </table>               
         <table class="table table-borderless">            
            <tbody>                              
                <tr>
                    <td class="p-0"><b> Observaciones: {!! nl2br(e($solicitudes->observacion)) !!} </b> </td>  
                                                                            
                </tr>                
            </tbody>
        </table>
        <br>     
            <table class="table table-borderless">
                <tbody >
                    <tr>
                        <td  width="50%" class="text-center p-0"><strong></strong> SOLICITA <br><br><br></td>
                        <td  width="50%" class="text-center p-0"><strong></strong>TRAMITESE </td>
                    </tr>
                    <tr>
                        <td  width="50%" class="text-center p-0"><small><b>{{$entrega->nombre.' '.$entrega->paterno.' '.$entrega->materno}}</b></small></td>                       
                        <td  width="50%" class="text-center p-0"><small><b>{{$autoriza->nombre.' '.$autoriza->paterno.' '.$autoriza->materno}}</b></small></td>                       
                    </tr>
                    <tr>
                        <td  width="50%" class="text-center p-0"><small><strong>____________________________________________</strong><br/></small></td>
                        <td  width="50%" class="text-center p-0"><small><strong>____________________________________________</strong><br/></small></td>
                    </tr>
                    <tr>
                        <td  width="50%" class="text-center p-0"><small><strong>JEFE DE RECURSOS MATERIALES Y SERVICIOS <br>GENERALES</strong><br/></small></td>
                        <td  width="50%" class="text-center p-0"><small><strong>JEFE DE LA UNIDAD DE APOYO <br>ADMINISTRATIVO</strong><br/></small></td>
                    </tr>
                    
                </tbody>
            </table>
        
    </body> 
</html>