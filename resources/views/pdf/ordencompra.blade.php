<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Orden de compra</title>
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
        <h5 class="text-center mb-0"><small><b>ORDEN DE COMPRA MENOR</b></small></h5> 
        <p class="text-right mt-0 mb-0"><small>COMPRA No. <strong>{{ $solicitudes->folio}}</strong></small></p>
        <br>
                      
        <table class="table table-bordered table-sm">            
            <tbody>
              <tr>
                <th scope="row" width="20%" class="align-middle mt-0 mb-0"><small>Dependencia:</small></th>
                <td><small> Secretaría General de Gobierno</small></td>                
              </tr>
              <tr>
                <th scope="row" class="align-middle"><small>Administrativo:</small></th>
                <td><small>{{$solicitudes->area}}</small></td>                
              </tr>
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Presupuestal:</small></th>
                <td><small>{{ $solicitudes->clavepresupuestal}}</small></td> 
              </tr>
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Presupuestal:</small></th>
                <td><small>{{ $solicitudes->clavepartida.'-'.$solicitudes->partida}}</small></td> 
              </tr>              
              <tr>
                <th scope="row" width="20%" class="align-middle"><small>Proveedor:</small></th>
                <td><small>{{ $solicitudes->proveedor}}</small></td> 
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
                        <th class="text-center" BGCOLOR="gray">Lote</th>
                        <th class="text-center" BGCOLOR="gray">Cantidad</th>
                        <th class="text-center" BGCOLOR="gray">Unidad</th>
                        <th class="text-center" BGCOLOR="gray">Especificación de los articulos</th>
                        <th class="text-center" BGCOLOR="gray">Precio unitario</th>                       
                        <th class="text-center" BGCOLOR="gray">Precio total</th>                       
                    </tr><br>  
                    @foreach ($desgloses as $key => $item)                  
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td class="text-center">{{$item->cantidad}}</td> 
                            <td class="text-center">{{$item->unidad}}</td>
                            <td class="text-center">{{$item->descripcion}}</td>
                            <td class="text-center">$ {!! number_format((float)($item->unitario), 2) !!}</td>                                                       
                            <td class="text-center">$ {!! number_format((float)($item->total), 2) !!}</td>                                                       
                        </tr> 
                    @endforeach                       
                    <tr>
                        <td colspan="4"></td>                        
                        <td class="text-center">Sub-total</td>
                        <td class="text-center">$ {!! number_format((float)($solicitudes->subtotal), 2) !!}</td>                                                                                                   --}}
                    </tr>
                    <tr>
                        <td colspan="4"></td> 
                        <td class="text-center">Iva</td>
                        <td class="text-center">$ {!! number_format((float)($solicitudes->iva), 2) !!}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>      
                        <td class="text-center">Total</td>                                          
                        <td class="text-center">$ {!! number_format((float)($solicitudes->total), 2) !!}</td>                                                                               
                    </tr>
                </table>
            </div>
        </div>
        
            <table class="table table-borderless">
                <tbody >
                    <tr>
                        <td  width="30%" class="text-center p-0"><small> ELABORA </small><br><br><br></td>
                        <td  width="30%" class="text-center p-0"><small> V.B. </small> </td>
                        <td  width="30%" class="text-center p-0"><small> AUTORIZA </small></td>
                    </tr>
                    <tr>
                        <td  width="30%" class="text-center p-0"><small><small><b></b></small></small></td>                       
                        <td  width="30%" class="text-center p-0"><small><small><b>{{$entrega->nombre.' '.$entrega->paterno.' '.$entrega->materno}}</b></small></small></td>                                               
                        <td  width="30%" class="text-center p-0"><small><small><b>{{$autoriza->nombre.' '.$autoriza->paterno.' '.$autoriza->materno}}</b></small></small></td>                       
                    </tr>
                    <tr>
                        <td  width="30%" class="text-center p-0"><small><small><strong>_______________________________________</strong><br/></small></small></td>
                        <td  width="30%" class="text-center p-0"><small><small><strong>_______________________________________</strong><br/></small></small></td>
                        <td  width="30%" class="text-center p-0"><small><small><strong>_______________________________________</strong><br/></small></small></td>
                    </tr>
                    <tr>
                        <td  width="30%" class="text-center p-0"><small><small><strong>PERSONAL OPERATIVO DE <br>COMPRAS</strong><br/></small></small></td>
                        <td  width="30%" class="text-center p-0"><small><small><strong>JEFE DE RECURSOS MATERIALES Y <br>SERVICIOS GENERALES</strong><br/></small></small></td>
                        
                        <td  width="30%" class="text-center p-0"><small><small><strong>JEFE DE LA UNIDAD DE APOYO <br>ADMINISTRATIVO</strong><br/></small></small></td>
                    </tr>
                    
                </tbody>
            </table>
        
    </body> 
</html>