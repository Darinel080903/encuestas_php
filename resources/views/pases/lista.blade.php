@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <img id="headerlistalogo" src="{{asset('storage/escudo/secretaria-general-de-gobierno.png')}}" alt="Organismo">
                        <h3 class="headerlistatitulo">Listado de pases</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" action="{{url('/pases')}}" method="GET">
                        @csrf
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vfecha" name="vfecha" placeholder="Fecha" aria-label="Fecha" value="{{ $vfecha }}" readonly>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vbusqueda" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/pases')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                            </div>
                        </form>
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col" width="10%">Fecha</th>
                                        <th class="text-center" scope="col">Hora</th>
                                        <th class="text-center" scope="col">Solicita</th>
                                        <th class="text-center" scope="col">Funcionario</th>
                                        <th class="text-center" scope="col">Observación</th>
                                        <th class="text-center" scope="col" width="33%" colspan="2">
                                            @can('create', \App\Models\Vpase::class)
                                                <a class="btn btn-outline-danger" href="{{url('/pases/create?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                            @endcan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datos as $item)
                                    <tr>
                                        <td class="text-center align-middle" scope="row">{{date('d/m/Y', strtotime($item->fecha))}}</td>
                                        <td class="text-justify align-middle">{{$item->hora}}</td>
                                        <td class="text-justify align-middle">{{$item->solicita}}</td>
                                        <td class="text-justify align-middle">{{$item->funcionario}}</td>
                                        <td class="text-justify align-middle">{{$item->observacion}}</td>
                                        <td class="text-center" width="11%">
                                            @can('update', $item)
                                                <a class="btn btn-outline-danger" href="{{url('/pases/'.$item->idpase.'/edit?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                            @endcan
                                        </td>
                                        <td class="text-center" width="11%">
                                            @can('delete', $item)
                                                <form action="{{url('/pases/'.$item->idpase)}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
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
    </script>
@endsection