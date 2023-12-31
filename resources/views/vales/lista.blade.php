@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <img id="headerlistalogo" src="{{asset('storage/escudo/secretaria-general-de-gobierno.png')}}" alt="Organismo">
                        <h3 class="headerlistatitulo">Listado de vales</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" action="{{url('/vales')}}" method="GET">
                        @csrf
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vfecha" name="vfecha" placeholder="Fecha" aria-label="Fecha" value="{{ $vfecha }}" readonly>
                            </div>
                            <div class="input-group mr-2 mb-2">  
                                <select class="form-control" name="vejercicio" id="vejercicio">
                                    <option value="">Ejercicio</option>
                                    @foreach ($ejercicios as $item)
                                        @if ($vejercicio == $item->ejercicio)
                                            <option value="{{$item->ejercicio}}" selected>{{$item->ejercicio}}</option>
                                        @else
                                            <option value="{{$item->ejercicio}}">{{$item->ejercicio}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mr-2 mb-2">  
                                <select class="form-control" name="vcomprobacion" id="vcomprobacion">
                                    @if($vcomprobacion == "")
                                        <option value="" selected>Comprobación</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    @elseif($vcomprobacion == 1)
                                        <option value="">Comprobación</option>
                                        <option value="1" selected>Si</option>
                                        <option value="0">No</option>
                                    @elseif($vcomprobacion == 0)
                                        <option value="">Comprobación</option>
                                        <option value="1">Si</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vbusqueda" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/vales')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                            </div>
                        </form>
                        @if(session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif
                        @if(session('mensajeerror'))
                            <div class="alert alert-danger">{{session('mensajeerror')}}</div>
                        @endif 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th class="text-center" width="10%" scope="col">Fecha</th>
                                    <th class="text-center" scope="col">Número económico</th>
                                    <th class="text-center" scope="col">Funcionario</th>
                                    <th class="text-center" scope="col">Recibe</th>
                                    <th class="text-center" scope="col">Facturas</th>
                                    <th class="text-center" scope="col">Monto</th>
                                    <th class="text-center" scope="col">Comprobación</th>
                                    <th class="text-center" width="18%" scope="col" colspan="3">
                                        @can('create', \App\Models\Vvale::class)
                                            <a class="btn btn-outline-danger" href="{{url('/vales/create?page='.$page.'&vfecha='.$vfecha.'&vejercicio='.$vejercicio.'&vcomprobacion='.$vcomprobacion.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i></a>
                                        @endcan
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datos as $item)
                                    <tr>
                                        <th class="align-middle text-center" scope="row">{{date('d/m/Y', strtotime($item->fecha))}}</th>
                                        <td class="align-middle">{{$item->numero}}</td>
                                        <td class="align-middle">{{$item->nombrecompleto}}</td>
                                        <td class="align-middle">{{$item->recibe}}</td>
                                        <td class="align-middle">{{$item->facturas}}</td>
                                        @if ($item->monto)
                                            <td class="align-middle">${!! number_format((float)($item->monto), 2) !!}</td>
                                        @else
                                            <td class="align-middle">{{'$ 0.00'}}</td>
                                        @endif
                                        <td class="text-center" width="9%">
                                            <form id="frmimgpublicar{{$item->idvale}}" name="frmimgpublicar{{$item->idvale}}" method="POST" action="{{url('/vales/'.$item->idvale.'/update2')}}">
                                                @method('PUT')
                                                @csrf
                                                <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idvale}}')"  data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                            </form>
                                        </td>
                                        <td class="text-center" width="6%">
                                            @can('update', $item)
                                                <a class="btn btn-outline-danger" href="{{url('/vales/'.$item->idvale.'/edit?page='.$page.'&vfecha='.$vfecha.'&vejercicio='.$vejercicio.'&vcomprobacion='.$vcomprobacion.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i></a>
                                            @endcan
                                        </td>
                                        <td class="text-center" width="6%">
                                            <a class="btn btn-outline-danger" href="{{url('/imprimir/vale/'.$item->idvale)}}" target="_blank"><i class="fas fa-print"></i></a>
                                        </td>
                                        <td class="text-center" width="6%">
                                            @can('delete', $item)
                                                <form action="{{url('/vales/'.$item->idvale)}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-md-center">
                            {{$datos->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function()
		{
            $('#vfecha').datepicker({
                footer: true,
                uiLibrary: "bootstrap4",
                locale: "es-es",
                format: "dd/mm/yyyy",
                change: function(e){
                    $("#frmbusqueda").submit();
                }
            });
        });
        
        $("#toggle-demo").bootstrapToggle();

        function funpublicar(frm)
        {
            $("#"+frm).submit();
        }

        $("#vejercicio").change(function(){
            $("#frmbusqueda").submit();
        });

        $("#vcomprobacion").change(function(){
            $("#frmbusqueda").submit();
        });
    </script>
@endsection