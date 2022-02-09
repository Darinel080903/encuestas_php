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
            <img class="float-left" src="{{public_path('/storage/escudo/secretaria-general-de-gobierno.png')}}" alt="SGG">
            <img class="float-right mt-4" src="{{public_path('/storage/escudo/chiapas-corazon-claro.png')}}" alt="Chiapas de Corazón">
        </header>

        <footer>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="text-center" colspan="2"><small><strong>Autoriza</strong><br/>{{$autoriza->nombre.' '.$autoriza->paterno.' '.$autoriza->materno}}<br/>{{$autoriza->puesto}} {{$autoriza->area}}</small></td>
                    </tr>
                    <tr>
                        <td class="text-center col-6"><small><strong>Recibe</strong><br/>{{$vales->recibe}}</small></td>
                        <td class="text-center col-6"><small><strong>Entrega</strong><br/>{{$entrega->nombre.' '.$entrega->paterno.' '.$entrega->materno}}<br/>{{$entrega->puesto}} {{$entrega->area}}</small></td>
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
                    <p class="text-right mt-0 mb-0"><strong>Unidad de Apoyo Administrativo</strong></p>
                    <p class="text-right mt-0 mb-0"><strong>Area de Recursos Materiales y Servicios Generales</strong></p>
                    <h3 class="text-right mt-0 mb-0">Asunto: Vale</h3>
                    <p class="text-lefth mt-0 mb-0">Fecha: <strong>{{$fecha}}</strong></p>
                    {{-- <p class="text-lefth mt-0 mb-0">Número económico: <strong>{{$vales->numero}}</strong></p> --}}
                    <p class="text-lefth mt-0 mb-0">Marca: <strong>{{$vales->fabrica}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Tipo: <strong>{{$vales->tipo}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Modelo: <strong>{{$vales->modelo}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Número de erie: <strong>{{$vales->chasis}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Número de placas: <strong>{{$vales->placa}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Funcionario: <strong>{{$vales->nombre.' '.$vales->paterno.' '.$vales->materno}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Puesto: <strong>{{$vales->puesto}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Área: <strong>{{$vales->area}}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col"><hr style="border: 1px solid 000;"></div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table border="1" style="width: 100%;">             
                        <tr>
                            <th class="text-center" BGCOLOR="gray">Número</th>
                            <th class="text-center" BGCOLOR="gray">Concepto</th>
                            <th class="text-center" BGCOLOR="gray">Folio</th>
                            <th class="text-center" BGCOLOR="gray">Folio</th>
                            <th class="text-center" BGCOLOR="gray">Precio</th>
                            <th class="text-center" BGCOLOR="gray">Monto</th>
                        </tr>
                        @foreach ($folios as $item)
                            <tr>
                                <td class="text-center">{{$item->numero}}</td>
                                <td class="text-center">{{$item->concepto}}</td>
                                <td class="text-center">{{$item->folioini}}</td>
                                <td class="text-center">{{$item->foliofin}}</td>
                                <td class="text-center">$ {!! number_format((float)($item->unitario), 2) !!}</td>
                                <td class="text-center">$ {!! number_format((float)($item->monto), 2) !!}</td>                 
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5"></td>
                            <td class="text-center">$ {!! number_format((float)($vales->monto), 2) !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($vales->observacion)
            <div class="row">
                <div class="col">
                    <p>Observaciones: {!! nl2br(e($vales->observacion)) !!}</p>
                </div>
            </div>
            @endif
            
        </div>
    </body> 
</html>