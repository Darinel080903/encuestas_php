@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de roles</h3>
                    </div>
                    
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" method="GET" action="{{url('/roles')}}">
                            @csrf
                        
                            <div class="input-group mr-2 mb-2">
                                
                                <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/roles')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                                
                            </div>

                        </form>
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>   
                                <th class="text-center" scope="col">Rol</th>
                                <th class="text-center" scope="col">Slug</th>
                                <th class="text-center" scope="col">Permisos</th>
                                <th class="text-center" scope="col" colspan="2"><a class="btn btn-outline-danger" href="{{url('/roles/create?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $item)
                                <tr>
                                    <th class="text-center" scope="row">{{$item->name}}</th>
                                    <th class="text-center" scope="row">{{$item->slug}}</th>
                                    <th class="text-center" scope="row">
                                        @if($item->permissions != null)
                                            @foreach($item->permissions as $permisos)
                                                <span class="badge badge-danger">
                                                    {{$permisos->name}}
                                                </span>                                
                                            @endforeach
                                        @endif
                                    </th>
                                    <td class="text-center" width="12%"><a class="btn btn-outline-danger" href="{{url('/roles/'.$item->id.'/edit?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a></td>
                                    
                                    <td class="text-center" width="12%">
                                        <form method="POST" action="{{url('/roles/'.$item->id)}}">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row justify-content-md-center">
                            {{$roles->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection