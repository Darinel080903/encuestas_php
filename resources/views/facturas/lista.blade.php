@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-file-invoice-dollar"></i> Listado de facturas</h4>
                    </div>

                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" action="{{url('/facturas')}}" method="GET">
                            @csrf

                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vfecha" name="vfecha" placeholder="Fecha" aria-label="Fecha" value="{{ $vfecha }}" readonly>
                            </div>

                            <div class="input-group mr-2 mb-2">
                                
                                <input type="text" class="form-control" id="vbusqueda" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/facturas')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                                
                            </div>

                        </form>
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif 
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th class="text-center" width="10%" scope="col">Fecha</th>
                                <th class="text-center" scope="col">Número</th>
                                <th class="text-center" scope="col">Proveedor</th>
                                <th class="text-center" scope="col">Monto</th>
                                <th class="text-center" width="48%" scope="col" colspan="4">
                                    @can('create', \App\Models\Factura::class)
                                        <a class="btn btn-outline-danger" href="{{url('/facturas/create?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                    @endcan
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facturas as $item)
                                <tr>
                                    <th class="text-center" scope="row">{{date('d/m/Y', strtotime($item->fecha))}}</th>
                                    <td>{{$item->numero}}</td>
                                    <td>{{$item->fabrica.' - '.$item->tipo.' - '.$item->modelo}}</td>
                                    <td>{{$item->fabrica.' - '.$item->tipo.' - '.$item->modelo}}</td>
                                    <td class="text-center" width="12%">
                                        @can('update', $item)
                                            <a class="btn btn-outline-danger" href="{{url('/facturas/'.$item->idfactura.'/edit?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                        @endcan
                                    </td>
                                    <td class="text-center" width="12%">
                                        @can('update', $item)
                                            <a class="btn btn-outline-danger" href="{{url('/facturasimgs/'.$item->idfactura.'?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-images"></i> Galeria</a>
                                        @endcan
                                    </td>
                                    <td class="text-center" width="12%">
                                        <form id="frmimgpublicar{{$item->idfactura}}" name="frmimgpublicar{{$item->idfactura}}" method="POST" action="{{url('/facturas/'.$item->idfactura.'/update2')}}">
                                            @method('PUT')
                                            @csrf
                                            <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idfactura}}')"  data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif @if(!Auth::user()->hasRole('administrador')) disabled @endif>
                                        </form>
                                    </td>
                                    <td class="text-center" width="12%">
                                        @can('delete', $item)
                                            <form action="{{url('/facturas/'.$item->idfactura)}}" method="POST">
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
                        <div class="row justify-content-md-center">
                            {{$facturas->withQueryString()->links()}}
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
    </script>
@endsection