<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Formato de conformidad</title>
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
        <p class="text-lefth mb-0">Recibi a mi entera satisfacción la reparación de:</p><br>
        <p class="text-lefth mb-0">Vehiculo:</p>
        <p class="text-lefth mb-0">Marca:<b> {{$autos->fabrica}}</b></p>                    
        <p class="text-lefth mb-0">Tipo:<b> {{$autos->tipo}}</b></p>
        <p class="text-lefth mb-0">Modelo:<b> {{$autos->modelo}}</b></p>
        <p class="text-lefth mb-0">Placas:<b> {{$autos->placa}}</b></p>
        
        <p class="text-justify mt-0 mb-0">Mano de obra:</p>
        <p class="text-justify mt-0 mb-0"><strong>{{$solicitudes->servicio}}</strong> </p>
        <br>                
        <p class="text-lefth mb-0">Factura  No: <b>{{ $solicitudes->factura}}</b></p>
        <p class="text-lefth mb-0">Fecha: <b>{{date('d/m/Y', strtotime($solicitudes->fechafactura))}}</b></p>
        <br>                    
        <p class="text-lefth mb-0">Que salio del taller:______________________________________</p>
        <p class="text-lefth mb-0">El día: <strong>{{date('d/m/Y', strtotime($solicitudes->fechaservicio))}}</strong></p>
        <p class="text-lefth mb-0">Esta asignado a: <strong>{{$auto->nombre.' '.$auto->paterno.' '.$auto->materno}}</strong></p>                                         
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
                    <td  width="50%" class="text-center p-0">Nombre y firma de quien solícito<br/></td>                        
                </tr>                                       
            </tbody>
        </table>
        
    </body> 
</html>