<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Devolución</title>
        <link rel="icon" href="{{asset('storage/ico/favicon.ico')}}">
        
        <!-- Bootstrap CSS -->
        <script src="{{public_path('/js/app.js')}}"></script>
        <link href="{{public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
        
        <style>
            .sub_div{
                position: absolute;
                bottom: 0px;
            }
        
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
                        <td class="text-center col-6 mb-4"><strong>Entrega</strong></td>
                        <td class="text-center col-6 mb-4"><strong>Recibe</strong></td>
                    </tr>
                    <tr>
                        <td class="text-center col-6"><hr><small><strong>{{$funcionario->nombre.' '.$funcionario->paterno.' '.$funcionario->materno}}<br>{{$funcionario->puesto}}<br>{{$funcionario->area}}</strong></small></td>
                        <td class="text-center col-6"><hr><small><strong>Nombre y firma</strong></small></td>
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
                    <h3 class="text-right mt-0 mb-3">Asunto: Devolución de equipo</h3>
                    <p class="text-lefth mt-0 mb-0">Fecha: <strong>{{$fecha}}</strong></p>
                    <p class="text-lefth mt-0 mb-0">Departamento: <strong>{{$funcionario->area}}</strong></p>
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
                        @foreach ($devoluciones as $item)
                            <tr>
                                <td class="text-center">{{$item->articulo}}</td>
                                <td class="text-center">{{$item->marca}}</td>
                                <td class="text-center">{{$item->modelo}}</td>
                                <td class="text-center">{{$item->serie}}</td>
                                <td class="text-center">{{$item->patrimonio}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p class="text-justify mt-2"><small>La unidad de Informática de la Secretaría General de Gobierno, con domicilio en Palacio de Gobierno 2º piso, Col. Centro en Tuxtla Gutiérrez, Chiapas, es el responsable de uso y protección de sus datos personales y al respecto informa lo siguiente: Los datos personales que recabamos de usted, los utilizaremos únicamente como control de Devolución del equipo de cómputo, los cuales no serán compartidos con nadie.</small></p>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mx-auto">
                    <h2 class="text-center bg-danger text-white font-weight-normal">DESTINO</h2>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p class="text-lefth mt-0 mb-0">Departamento: <strong>Unidad de Informática</strong></p>
                    <p class="text-lefth mt-0 mb-0">Responsable: <strong>{{$responsable[0]->nombre.' '.$responsable[0]->paterno.' '.$responsable[0]->materno}}</strong></p>
                </div>
            </div>

        </div>
    </body> 
</html>