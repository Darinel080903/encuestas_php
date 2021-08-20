@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Listado de áreas</h3>
                    </div>
                    <div class="card-body">
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>   
                                        <th class="text-center" scope="col">Estructura</th>
                                        <th class="text-center" scope="col" width="33%" colspan="3">
                                            @can('create', \App\Models\Area::class)
                                                <a class="btn btn-outline-danger" href="{{ url('/areas/create') }}"><i class="fas fa-save"></i> Nuevo</a>
                                            @endcan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($areas as $item)
                                        <tr>
                                            <td class="text-justify align-middle" scope="row">{{$item->area}}</td>
                                            <td class="text-center" width="11%">
                                                @can('update', $item)
                                                    <a class="btn btn-outline-danger" href="{{url('/areas/'.$item->idarea.'/edit')}}"><i class="fas fa-pen"></i> Editar</a>
                                                @endcan
                                            </td>
                                            <td class="text-center" width="11%">
                                                @can('update', $item)
                                                    <form id="frmimgpublicar{{$item->idarea}}" name="frmimgpublicar{{$item->idarea}}" method="POST" action="{{ url('/areas/'.$item->idarea.'/update2') }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idarea}}')" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                                    </form>
                                                @endcan
                                            </td>
                                            <td class="text-center" width="11%">
                                                @can('delete', $item)
                                                    <form method="POST" action="{{ url('/areas/'.$item->idarea) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
                                                    </form>
                                                @endcan
                                            </td>    
                                            @if(count($item->childs))
                                                @include('areas.nodo',['childs' => $item->childs])
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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