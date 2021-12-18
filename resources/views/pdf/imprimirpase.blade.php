<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Pase de salida</title>
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
        </style>
    </head>
    <body>
        <header>
            <img class="float-left" src="{{ public_path('/storage/escudo/secretaria-general-de-gobierno.png') }}" alt="SGG">
            <img class="float-right mt-4" src="{{ public_path('/storage/escudo/chiapas-corazon-claro.png') }}" alt="Chiapas de Corazón">
        </header>

        <footer>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="text-center col-6 mb-4"><strong>Solícita</strong></td>
                        <td class="text-center col-6 mb-4"><strong>Autoriza</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center col-6"><hr><small><strong>{{$pases->solicita}}</strong></small></td>
                        <td class="text-center col-6"><hr><small><strong>{{$pases->funcionario}}<br>{{$pases->puesto}}<br>{{$pases->area}}</strong></small></td>
                    </tr>
                </tbody>
            </table>
        </footer>

        <div class="container-fluid">

            <div class="row">
                <div class="col">&nbsp;</div>
            </div>
            
            <div class="row">
                <div class="col">
                    <p class="text-right mt-0 mb-0"><strong>Unidad de Informática</strong></p>
                    <p class="text-right mt-0 mb-0"><strong>Área de Soporte Técnico</strong></p>
                    <h3 class="text-right mt-0 mb-3">Asunto: Pase de salida</h3>
                    <p class="text-lefth mt-0 mb-0">Fecha: <strong>{{$fecha}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Número económico: <strong>{{$pases->idpase}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col"><hr style="border: 1px solid 000;"></div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table border border-dark">             
                        <tr>
                            <th class="text-center" BGCOLOR="gray">Equipo</th>
                            <th class="text-center" BGCOLOR="gray">Marca</th>
                            <th class="text-center" BGCOLOR="gray">Modelo</th>
                            <th class="text-center" BGCOLOR="gray">Serie</th>
                            <th class="text-center" BGCOLOR="gray">Patrimonio</th>
                        </tr>
                        @foreach ($detalles as $item)
                            <tr>
                                <td class="text-center">{{$item->equipo}}</td>
                                <td class="text-center">{{$item->marca}}</td>
                                <td class="text-center">{{$item->modelo}}</td>
                                <td class="text-center">{{$item->serie}}</td>
                                <td class="text-center">{{$item->patrimonio}}</td>
                            </tr>
                        @endforeach
                        @if ($pases->observacion)
                            <tr>
                                <td class="text-justify" colspan="5"><small><strong>Observaciones: </strong>{!! nl2br(e($pases->observacion)) !!}</small></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            
        </div>
    </body> 
</html>