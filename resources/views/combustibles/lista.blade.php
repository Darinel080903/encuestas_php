@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de combustibles</h3>
                    </div>
                
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" method="GET" action="{{url('/combustibles')}}">
                            @csrf
                            
                            <div class="input-group mr-2 mb-2">
                                
                                <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/combustibles')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                                
                            </div>

                        </form>
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        
                        <table class="table table-bordered table-responsive-xl">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">Combustible</th>
                                    <th class="text-center" scope="col" colspan="2" width="22%">
                                        @can('create', \App\Models\Combustible::class)
                                            <a class="btn btn-outline-danger" href="{{url('/combustibles/create?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                        @endcan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($combustibles as $item)
                                <tr>
                                    <th class="text-justify" scope="row">{!!nl2br($item->combustible)!!}</th>
                                    <td class="text-center" width="11%">
                                        @can('update', $item)
                                            <a class="btn btn-outline-danger" href="{{url('/combustibles/'.$item->idcombustible.'/edit?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                        @endcan 
                                    </td>
                                    <td class="text-center" width="11%">
                                        @can('delete', $item)
                                            <form method="POST" action="{{url('/combustibles/'.$item->idcombustible)}}">
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
                            {{$combustibles->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection