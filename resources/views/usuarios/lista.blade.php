@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de usuarios</h3>
                    </div>
                    
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" method="GET" action="{{url('/usuarios')}}">
                            @csrf
                        
                            <div class="input-group mr-2 mb-2">
                                
                                <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/usuarios')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                                
                            </div>

                        </form>
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>   
                                <th class="text-center" scope="col">Nombre</th>
                                <th class="text-center" scope="col">Correo electrónico</th>
                                <th class="text-center" scope="col">Rol</th>
                                <th class="text-center" scope="col">Permisos</th>
                                <th class="text-center" scope="col" colspan="2">
                                    @can('create', \App\Models\User::class)
                                        <a class="btn btn-outline-danger" href="{{url('/usuarios/create?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                    @endcan
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $item)
                                @if(!\Auth::user()->hasRole('administrador') && $item->hasRole('administrador')) @continue; @endif
                                <tr>
                                    <th class="text-center" scope="row">{{$item->name}}</th>
                                    <th class="text-center" scope="row">{{$item->email}}</th>
                                    <th class="text-center" scope="row">
                                        @if ($item->roles->isNotEmpty())
                                            @foreach ($item->roles as $role)
                                                <span class="badge badge-danger">
                                                    {{$role->name}}
                                                </span>                                     
                                            @endforeach    
                                        @endif
                                    </th>
                                    <th class="text-center" scope="row">
                                        @if ($item->permissions->isNotEmpty())
                                            @foreach ($item->permissions as $permission)
                                                <span class="badge badge-danger">
                                                    {{$permission->name}}
                                                </span>                                     
                                            @endforeach    
                                        @endif
                                    </th>
                                    <td class="text-center" width="12%">
                                        @can('update', $item)
                                            <a class="btn btn-outline-danger" href="{{url('/usuarios/'.$item->id.'/edit?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                        @endcan
                                    </td>
                                    
                                    <td class="text-center" width="12%">
                                        @can('delete', $item)
                                            <form method="POST" action="{{url('/usuarios/'.$item->id)}}">
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
                            {{$usuarios->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection