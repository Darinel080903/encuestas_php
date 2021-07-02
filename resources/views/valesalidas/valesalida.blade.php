@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Vale de Salida</h3>
                    </div>                   
                    
                    <div class="card-body">
                                                
                        <form class="needs-validation" method="POST" action="{{url('/valesalidas')}}" novalidate>
                        @csrf
                        
                        {{-- <div class="input-group mr-2 mb-2">
                                
                            <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                <a class="btn btn-outline-danger" href="{{url('/articulos')}}"><i class="fas fa-broom"></i> Limpiar</a>
                            </div>
                            
                        </div> --}}

                    </form>
                    @if (session('mensaje'))
                        <div class="alert alert-success">{{session('mensaje')}}</div>
                    @endif 
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Captura</th>
                                <th class="text-center" scope="col" colspan="2" width="22%"><a class="btn btn-outline-danger" href="{{url('/valesalidas/create?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a></th>
                            </tr>
                        </thead>

                        
                        
                        <tbody>
                            @foreach ($articulos as $item)
                            <tr>{{$item->detalle}}
                                <th scope="row">{{$item->articulo}}</th>                                                            
                                
                                <td class="text-center" width="11%"><a class="btn btn-outline-danger" ><i class="fas fa-pen"></i> Editar</a></td>
                                
                                <td class="text-center" width="11%">
                                    <form method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
    
@endsection