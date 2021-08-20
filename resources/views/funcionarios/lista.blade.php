@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de funcionarios</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" method="GET" action="{{url('/funcionarios')}}">
                        @csrf
                            <div class="input-group mr-2 mb-2">    
                                <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/funcionarios')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                            </div>
                        </form>
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>   
                                        <th class="text-center" scope="col">Funcionario</th>
                                        <th class="text-center" scope="col" width="33%" colspan="3">
                                            @can('create', \App\Models\Funcionario::class)
                                                <a class="btn btn-outline-danger" href="{{url('/funcionarios/create?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                            @endcan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($funcionarios as $item)
                                    <tr>
                                        <td class="text-justify align-middle" scope="row">{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</td>
                                        <td class="text-center" scope="row" width="11%">
                                            @can('update', $item)
                                                <a class="btn btn-outline-danger" href="{{url('/funcionarios/'.$item->idfuncionario.'/edit?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                            @endcan
                                        </td>
                                        <td class="text-center" width="11%">
                                            @can('update', $item)
                                                <form id="frmimgpublicar{{$item->idfuncionario}}" name="frmimgpublicar{{$item->idfuncionario}}" method="POST" action="{{url('/funcionarios/'.$item->idfuncionario.'/update2')}}">
                                                @method('PUT')
                                                @csrf
                                                    <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idfuncionario}}')" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="text-center" width="11%">
                                            @can('delete', $item)
                                                <form method="POST" action="{{url('/funcionarios/'.$item->idfuncionario)}}">
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
                            {{$funcionarios->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#toggle-demo").bootstrapToggle();

        function funpublicar(frm)
        {
            $("#"+frm).submit();
        }
    </script>
@endsection