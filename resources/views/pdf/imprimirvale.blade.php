<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Vale</title>
        <link rel="icon" href="{{asset('storage/ico/favicon.ico')}}">
        
        <!-- Bootstrap CSS -->
        <script src="{{public_path('/js/app.js')}}"></script>
        <link href="{{public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
        
        <style>
            .sub_div{
                position: absolute;
                bottom: 0px;
            }
        </style>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: -85px;
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
                height: 100px; 

                /** Extra personal styles **/
                /* background-color: #03a9f4; */
                color: white;
                text-align: center;
                /* line-height: 35px; */
            }
        </style>
    </head>
    <body>
        <header>
            <img class="float-left" src="{{ public_path('/storage/escudo/secretaria-general-de-gobierno.png') }}" alt="SGG">
            <img class="float-right mt-4" src="{{ public_path('/storage/escudo/chiapas-corazon-claro.png') }}" alt="Chiapas de Corazón">
        </header>
        
        <div class="container-fluid">

            <div class="row">
                <div class="col">&nbsp;</div>
            </div>
            
            <div class="row">
                <div class="col">
                    <p class="text-right mt-0 mb-0"><strong>Unidad de Apoyo Administrativo</strong></p>
                    <p class="text-right mt-0 mb-0"><strong>Area de Recursos Materiales y Servicios Generales</strong></p>                    
                </div>
            </div>
            
            <div class="row">
                <div class="col"><hr style="border: 1px solid 000;"></div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table border="1" style="width: 100%;">             
                        <tr>
                            <th class="text-center" BGCOLOR="gray" width="11%">Fecha</th>
                            <th class="text-center" BGCOLOR="gray" width="15%">No. económico</th>
                            <th class="text-center" BGCOLOR="gray">Funcionario</th>
                            <th class="text-center" BGCOLOR="gray" width="15%">Facturas</th>
                            <th class="text-center" BGCOLOR="gray" width="15%">Monto</th>
                        </tr>                    
                        @foreach ($vales as $item)
                            <tr>
                                <td class="text-center"><small>{{date('d/m/Y', strtotime($item->fecha))}}</small></td>
                                <td class="text-center"><small>{{$item->numero}}</small></td>
                                <td class="text-center"><small>{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</small></td>
                                <td class="text-center"><small>{{$item->facturas}}</small></td>
                                <td class="text-right"><small>${!! number_format((float)($item->monto), 2) !!}</small></td>                 
                            </tr>
                        @endforeach                        
                        <tr>
                            <td colspan="4"></td>                            
                            <td class="text-right"><small>${!! number_format((float)($vale), 2) !!}</small></td>                          
                        </tr>
                                              
                       
                    </table>
                </div>
            </div>                       
        </div>
    </body> 
</html>