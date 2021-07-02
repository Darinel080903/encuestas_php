@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de {{$vtabla ?? ''}}</h3>
                    </div>
    

                    <div class="card-body">
                        <form class="form-inline" action="{{url('/catalogos')}}" method="GET">
                            @csrf
                            
                            <div class="input-group mr-2 mb-2">
                                
                                <input type="text" class="form-control" id="vbusqueda" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda ?? ''}}">
                                <input type="hidden" name="vtabla" value="{{$vtabla ?? ''}}">
                                <input type="hidden" name="vdescripcion" value="{{$vdescripcion ?? ''}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/catalogos?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion)}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                                
                            </div>

                        </form>
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th class="text-center" scope="col">Descripcion</th>
                                <th class="text-center" scope="col" width="24%" colspan="2"><a class="btn btn-outline-danger" href="{{url('/catalogos/create?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catalogos as $item)
                                <tr>
                                    <td scope="row">
                                        @if ($vtabla == 'articulos')
                                            {{$item->articulo}}
                                        @elseif ($vtabla == 'marcas')
                                            {{$item->marca}}
                                        @elseif ($vtabla == 'categorias')
                                            {{$item->categoria}}
                                        @elseif ($vtabla == 'puestos')
                                            {{$item->puesto}}
                                        @endif
                                    </td>
                                    <td class="text-center" width="12%">
                                        <a class="btn btn-outline-danger" href="
                                        @if($vtabla == 'articulos')
                                            {{url('/catalogos/'.$item->idarticulo.'/edit?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)}}
                                        @elseif($vtabla == 'marcas')
                                            {{url('/catalogos/'.$item->idmarca.'/edit?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)}}
                                        @elseif($vtabla == 'categorias')
                                            {{url('/catalogos/'.$item->idcategoria.'/edit?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)}}
                                        @elseif($vtabla == 'puestos')
                                            {{url('/catalogos/'.$item->idpuesto.'/edit?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda)}}
                                        @endif"><i class="fas fa-pen"></i> Editar</a>
                                    </td>
                                    <td class="text-center" width="12%">
                                        <form action="
                                            @if($vtabla == 'articulos') 
                                                {{url('/catalogos/'.$item->idarticulo)}}
                                            @elseif($vtabla == 'marcas') 
                                                {{url('/catalogos/'.$item->idmarca)}}
                                            @elseif($vtabla == 'categorias') 
                                                {{url('/catalogos/'.$item->idcategoria)}}
                                            @elseif($vtabla == 'puestos') 
                                                {{url('/catalogos/'.$item->idpuesto)}}
                                            @endif" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="vtabla" value="{{$vtabla ?? ''}}">
                                            <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row justify-content-md-center">
                            {{$catalogos->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection