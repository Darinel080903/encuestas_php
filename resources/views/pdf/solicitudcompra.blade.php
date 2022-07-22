<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Solicitud compra</title>
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
        <h5 class="text-center mb-0"><small><b>SOLICITUD DE COMPRA</b></small></h5>         
        <br>
        <p class="text-lefth mt-0 mb-0"><small><strong>{{$autoriza->nombre.' '.$autoriza->paterno.' '.$autoriza->materno}}</strong></small></p>
        <p class="text-lefth mt-0 mb-0"><small><strong>JEFE DE LA UNIDAD DE APOYO ADMINISTRATIVO</strong></small></p>                    
        <p class="text-lefth mt-0 mb-0"><small><strong>PRESENTE </strong></small></p>
        <p class="text-right mt-0 mb-0"><small>SOLC.COMPRA No. <strong>{{ $solicitudes->folio}}</strong></small></p>
                
        <div class="row">
            <div class="col">
                <table border="1" style="width: 100%;">             
                    <tr>
                        <th class="text-center" BGCOLOR="gray">Lote</th>
                        <th class="text-center" BGCOLOR="gray">Cantidad</th>
                        <th class="text-center" BGCOLOR="gray">Unidad</th>
                        <th class="text-center" BGCOLOR="gray">Especificación de los articulos</th>                                             
                    </tr><br>  
                    @foreach ($desgloses as $key => $item)                  
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td class="text-center">{{$item->cantidad}}</td> 
                            <td class="text-center">{{$item->unidad}}</td>
                            <td class="text-center">{{$item->descripcion}}</td>                                                                           
                        </tr> 
                    @endforeach                                           
                </table>
            </div>
        </div>
        <br>                
        <p class="text-lefth mb-0">Seran utilizados: <b>{{ $solicitudes->area}}</b></p>
        <p class="text-lefth mb-0">Durante el período: <b>Indefinido</b></p>
        <p class="text-lefth mb-0">Partida: <b>{{ $solicitudes->clavepartida.'-'.$solicitudes->partida}}</b></p>                    
        <p class="text-lefth mb-0">Clave presupuestal: <b>{{ $solicitudes->clavepresupuestal}}</b></p>
        <p class="text-lefth mb-0">Disponibilidad presupuestal: <b>______________________</b></p>
        <br>        
        <table class="table table-borderless">
            <tbody >
                <tr>
                    <td  width="50%" class="text-center p-0"><strong></strong> SOLICITA <br><br></td>                       
                </tr>                  
                <tr>
                    <td  width="50%" class="text-center p-0"><small><strong>____________________________________________</strong><br/></small></td>                        
                </tr> 
                <tr>
                    <td  width="50%" class="text-center p-0">Nombre y firma de quien otorga<br>la disponibilidad presupuestal</td>                        
                </tr>                                       
            </tbody>
        </table>
        
    </body> 
</html>