@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de autos</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" action="{{url('/autos')}}" method="GET">
                        @csrf
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vfecha" name="vfecha" placeholder="Fecha" aria-label="Fecha" value="{{ $vfecha }}" readonly>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <select class="form-control" id="vactivo" name="vactivo">
                                    @if($vactivo == "")
                                    <option value="" selected>Todos</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                    @elseif($vactivo == 1)
                                    <option value="">Todos</option>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                    @elseif($vactivo == 0)
                                    <option value="">Todos</option>
                                    <option value="1">Activo</option>
                                    <option value="0" selected>Inactivo</option>
                                    @endif
                                </select>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vbusqueda" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/autos')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                            </div>
                        </form>
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col" width="10%">Fecha</th>
                                        <th class="text-center" scope="col">No. económico</th>
                                        <th class="text-center" scope="col">Auto</th>
                                        <th class="text-center" scope="col" width="44%" colspan="4">
                                            @can('create', \App\Models\Vauto::class)
                                                <a class="btn btn-outline-danger" href="{{url('/autos/create?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                            @endcan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($autos as $item)
                                    <tr>
                                        <td class="text-center align-middle" scope="row">{{date('d/m/Y', strtotime($item->fecha))}}</td>
                                        <td class="text-justify align-middle">{{$item->numero}}</td>
                                        <td class="text-justify align-middle">{{$item->fabrica.' - '.$item->tipo.' - '.$item->modelo}}</td>
                                        <td class="text-center" width="11%">
                                            @can('update', $item)
                                                <a class="btn btn-outline-danger" href="{{url('/autos/'.$item->idauto.'/edit?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                            @endcan
                                        </td>
                                        <td class="text-center" width="11%">
                                            @can('update', $item)
                                                <a class="btn btn-outline-danger" href="{{url('/autosimgs/'.$item->idauto.'?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-images"></i> Galeria</a>
                                            @endcan
                                        </td>
                                        <td class="text-center" width="11%">
                                            <form id="frmimgpublicar{{$item->idauto}}" name="frmimgpublicar{{$item->idauto}}" method="POST" action="{{url('/autos/'.$item->idauto.'/update2')}}">
                                                @method('PUT')
                                                @csrf
                                                <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idauto}}')"  data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif @if(!Auth::user()->hasRole('administrador')) disabled @endif>
                                            </form>
                                        </td>
                                        <td class="text-center" width="11%">
                                            @can('delete', $item)
                                                <form action="{{url('/autos/'.$item->idauto)}}" method="POST">
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
                            {{$autos->withQueryString()->links()}}
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
        
            $("#vactivo").change(function()
            {
                $("#frmbusqueda").submit();
            });
        });
        
        $("#toggle-demo").bootstrapToggle();

        function funpublicar(frm)
        {
            $("#"+frm).submit();
        }
    </script>
@endsection