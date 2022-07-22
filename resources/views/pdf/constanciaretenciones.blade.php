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
                margin: 100px 40px;
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
        <h5 class="text-center mb-0"><small><b>GOBIERNO DEL ESTADO DE CHIAPAS</b></small></h5> 
        <h5 class="text-center mb-1"><small><small><b>SECRETARIA DE HACIENDA</b></small></small></h5>                 
        <p class="text-center mb-1"><small><small> CONSTANCIA DE RETENCIONES <br>DE IMPUESTOS ESTATALES</small></small></p>        
               
        <table class="table table-bordered table-sm mb-1">            
            <tbody>
                <tr>
                    <th scope="row" width="35%"  class="align-middle mt-0 mb-0"><small><small><small>PERIODO QUE AMPARA LA CONSTANCIA:</small></small></small></th>
                    <td><small><small><small>MES </small></small></small></td>                
                    <td><small><small><small>AÑO </small></small></small></td>                
                    <td><small><small><small>MES </small></small></small></td>                
                    <td><small><small><small>AÑO </small></small></small></td>                
                </tr>
            </tbody>
        </table> 

         <table class="table table-bordered table-sm mb-1">            
            <tbody>
              <tr>
                <th class="text-center" scope="row" width="20%" BGCOLOR="gray"><small><small><strong> DATOS DEL CONTRIBUYENTE A QUIEN SE LE EXPIDE LA CONSTANCIA</strong></small></small></th>                
              </tr>              
            </tbody>
        </table>
        
        <table border="1" class="table table-bordered table-sm mb-0">            
            <tbody>
              <tr>
                <th class="text-center mb-0" scope="row"><small><small><strong> JOSE DOMINGO BEZARES VAZQUEZ</strong></small></small></th>                
              </tr>              
            </tbody>
        </table>
        <p class="text-center mb-1"><small><small><small> APELLIDO PATERNO, MATERNO Y NOMBRE(S), DENOMINACIÓN O RAZON SOCIAL</small></small></small></p>
        
        <table border="1" class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center" scope="row" width="50%"><small><small><strong> {{$solicitudes->rfc}}-{{$solicitudes->homoclave}}</strong></small></small></th>                
                    <th class="text-center" scope="row" width="50%"><small><small><strong> {{$solicitudes->rfc}}</strong></small></small></th>                
                </tr>                
            </tbody>
        </table>

        <table class="table table-sm mb-0">            
            <tbody>               
                <tr>
                    <td  width="50%" class="text-center p-0"><small><small><small>REGISTRO FEDERAL DE CONTRIBUYENTES<br/></small></small></small></td>
                    <td  width="50%" class="text-center p-0"><small><small><small>CLAVE UNICA DE REGISTRO DE POBLACIÓN<br/></small></small></small></td>
                </tr>        
            </tbody>
        </table>

        <table border="1" class="table table-bordered table-sm mb-1">            
            <tbody>
              <tr>
                <th class="text-left mb-0" scope="row"><small><small><strong> 6TA. AVENIDA NORTE PONIENTE No. EXT. 1205 COL. JUY JUY, TUXTLA GUTIERREZ,CHIAPAS</strong></small></small></th>                
              </tr>  
              <tr>
                <th class="text-left mb-0" scope="row"><small><small><small> DOMICILIO FISCAL</small></small></small></th>                
              </tr>              
            </tbody>
        </table>

        <table class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center" scope="row" width="100%" BGCOLOR="gray"><small><small><strong> TIPO DE RETENCION</strong></small></small></th>                
                </tr>                
            </tbody>
        </table> 
        <table class="table table-bordered table-sm mb-1">            
            <tbody>                
                <tr>
                    <th scope="row" width="50%"  class="align-middle mt-0 mb-0"><small><small>MARQUE CON UNA "X" EL RECUADRO QUE CORRESPONDA:</small></small></th>                   
                    <td ><small><small>MEDICINA  [&nbsp;&nbsp;&nbsp;] </small></small></td>                
                    <td><small><small>NOMINAS [&nbsp;&nbsp;&nbsp;] </small></small></td>                                    
                </tr>
            </tbody>
        </table> 

        <table class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center" scope="row" width="100%" BGCOLOR="gray"><small><small><strong> IMPUESTO SOBRE EL EJERCICIO PROFESIONAL DE LA MEDICINA</strong></small></small></th>                
                </tr>                
            </tbody>
        </table> 
        <table class="table table-bordered table-sm mb-1">            
            <tbody>                
                <tr>
                    <th scope="row" width="25%"  class="align-middle mb-0"><small><small>MONTO DE LOS INGRESOS: </small></small></th>                   
                    <th scope="row" width="25%"  class="align-middle mb-0"><small><small><small> </small></small></small></th>                   
                    <th scope="row" width="25%"  class="align-middle mb-0"><small><small>IMPUESTO RETENIDO: </small></small></th>                   
                    <th scope="row" width="25%"  class="align-middle mb-0"><small><small><small> </small></small></small></th>                   
                    
                </tr>
            </tbody>
        </table> 
        
        <table class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center" scope="row" width="100%" BGCOLOR="gray"><small><small><strong> IMPUESTOS SOBRE NOMINAS</strong></small></small></th>                
                </tr>                
            </tbody>
        </table> 
        <table class="table table-bordered table-sm mb-1">            
            <tbody>                
                <tr>
                    <th scope="row" width="20%"  class="align-middle mb-0"><small><small><small> MONTO DE LA MANO DE OBRA: </small></small></small></th>                   
                    <th scope="row" width="10%"  class="align-middle mb-0"><small><small><small> </small></small></small></th>                   
                    <th scope="row" width="20%"  class="align-middle mb-0"><small><small><small>REMUNERACIONES AL TRABAJO <br> PERSONAL SUBORDINADO: </small></small></small></th>                   
                    <th scope="row" width="10%"  class="align-middle mb-0"><small><small><small> </small></small></small></th>                   
                    <th scope="row" width="20%"  class="align-middle mb-0"><small><small><small>IMPUESTO RETENIDO: </small></small></small></th>                   
                    <th scope="row" width="10%"  class="align-middle mb-0"><small><small><small> </small></small></small></th>                   
                </tr>
            </tbody>
        </table> 

        <table class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center" scope="row" width="100%" BGCOLOR="gray"><small><small><strong> DATOS DEL RETENEDOR</strong></small></small></th>                
                </tr>                
            </tbody>
        </table> 
        <table border="1" class="table table-bordered table-sm mb-0">            
            <tbody>
              <tr>
                <th class="text-center mb-0" scope="row"><small><small><strong> SECRETARIA GENERAL DE GONIERNO</strong></small></small></th>                
              </tr>              
            </tbody>
        </table>
        <p class="text-center mb-1"><small><small><small> APELLIDO PATERNO, MATERNO Y NOMBRE(S), DENOMINACIÓN O RAZON SOCIAL</small></small></small></p>

        <table border="1" class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center mb-0" scope="row" width="50%"><small><small><strong> GEC-850101-3X9</strong></small></small></th>                
                    <th class="text-center mb-0" scope="row" width="50%"><small><small><strong> </strong></small></small></th>                
                </tr>                
            </tbody>
        </table>

        <table class="table table-sm mb-0">            
            <tbody>               
                <tr>
                    <td  width="50%" class="text-center p-0"><small><small><small>REGISTRO FEDERAL DE CONTRIBUYENTES<br/></small></small></small></td>
                    <td  width="50%" class="text-center p-0"><small><small><small>CLAVE UNICA DE REGISTRO DE POBLACIÓN<br/></small></small></small></td>
                </tr>        
            </tbody>
        </table>

        <table border="1" class="table table-bordered table-sm mb-1">            
            <tbody>
              <tr>
                <th class="text-left mb-0" scope="row"><small><small><strong> PALACIO DE GOBIERNO 2o PISO </strong></small></small></th>                
              </tr>  
              <tr>
                <th class="text-left mb-0" scope="row"><small><small><small> DOMICILIO FISCAL</small></small></small></th>                
              </tr>              
            </tbody>
        </table>

        <table class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center" scope="row" width="100%" BGCOLOR="gray"><small><small><strong> DATOS DEL REPRESENTANTE LEGAL</strong></small></small></th>                
                </tr>                
            </tbody>
        </table> 
        <table border="1" class="table table-bordered table-sm mb-0">            
            <tbody>
              <tr>
                <th class="text-center mb-0" scope="row"><small><small><strong> CARLOS ELÍ NARVAEZ PEÑA</strong></small></small></th>                
              </tr>              
            </tbody>
        </table>
        <p class="text-center mb-1"><small><small><small> APELLIDO PATERNO, MATERNO Y NOMBRE(S)</small></small></small></p>

        <table border="1" class="table table-bordered table-sm mb-0">            
            <tbody>
                <tr>
                    <th class="text-center mb-0" scope="row" width="50%"><small><small><strong> NAPC900521LK3</strong></small></small></th>                
                    <th class="text-center mb-0" scope="row" width="50%"><small><small><strong> NAPC900521HCSRXR06</strong></small></small></th>                
                </tr>                
            </tbody>
        </table>

        <table class="table table-sm mb-1">            
            <tbody>               
                <tr>
                    <td  width="50%" class="text-center p-0"><small><small><small>REGISTRO FEDERAL DE CONTRIBUYENTES<br/></small></small></small></td>
                    <td  width="50%" class="text-center p-0"><small><small><small>CLAVE UNICA DE REGISTRO DE POBLACIÓN<br/></small></small></small></td>
                </tr>        
            </tbody>
        </table>
        
        <table class="table table-bordered table-sm mb-0">
            <tbody >
                <tr>                    
                    <td  width="30%" HEIGHT="6%" class="text-center p-0"><small></small></td>
                    <td  width="30%" class="text-center p-0"><small></small></td>
                    <td  width="30%" class="text-center p-0"><small></small></td>
                </tr>
                <tr>
                    <td  width="30%" class="text-center p-0"><small><small><small> FIRMA DEL RETENEDOR O REPRESENTANTE LEGAL</small></small></small></td>                       
                    <td  width="30%" class="text-center p-0"><small><small><small> SELLO DEL RETENEDOR (EN CASO DE TENERLO)</small></small></small></td>                                               
                    <td  width="30%" class="text-center p-0"><small><small><small> FIRMA DE RECIBIDO DEL CONTRIBUYENTE</small></small></small></td>                       
                </tr>                                
            </tbody>
        </table>

        <p class="text-center mb-1"><small><small><small><strong> SE PRESENTAPOR TRIPLICADO</strong></small></small></small></p>
        <p class="text-justify mb-1"><small><small><small><small> LOS CONTRIBUYENTES A QUIENES SE LES EXTIENDA LA PRESENTE CONSTANCIA, PODRAN ACREDITAR LA PRESENTACIÓN DEL MISMO
            CONTRA LOS IMPORTES A CARGO QUE LES CORRESPONDA DECLARA PROVISIONALMENTE COMO SUJETOS DEL IMPUESTO.</small></small></small></small></p>
        
    </body> 
</html>