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
                        
                        {{-- <form class="form-inline" id="frmbusqueda" method="GET" action="{{ url('/areas') }}">
                            @csrf
                        
                            <div class="input-group mr-2 mb-2">
                                
                                <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{ $vbusqueda }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/areas')}}"><i class="fas fa-broom"></i> Limpiar</a>
                                </div>
                                
                            </div>

                        </form> --}}
                        
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif 
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>   
                                <th class="text-center" scope="col">Estructura</th>
                                <th class="text-center" scope="col" colspan="3"><a class="btn btn-outline-danger" href="{{ url('/areas/create') }}"><i class="fas fa-save"></i> Nuevo</a></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($areas as $item)
                                    <tr>
                                        <td scope="row">{{ $item->area }}</td>
                                        <td class="text-center" width="12%"><a class="btn btn-outline-danger" href="{{ url('/areas/'.$item->idarea.'/edit') }}"><i class="fas fa-pen"></i> Editar</a></td>
                                        <td class="text-center" width="12%">
                                            <form id="frmimgpublicar{{$item->idarea}}" name="frmimgpublicar{{$item->idarea}}" method="POST" action="{{ url('/areas/'.$item->idarea.'/update2') }}">
                                                @method('PUT')
                                                @csrf
                                                <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idarea}}')" data-toggle="toggle" data-on="Publicar" data-off="No publicar" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                            </form>
                                        </td>
                                        <td class="text-center" width="12%">
                                            <form method="POST" action="{{ url('/areas/'.$item->idarea) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
                                            </form>
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
    <script>
        $("#toggle-demo").bootstrapToggle();

        function funpublicar(frm)
        {
            $("#"+frm).submit();
        }
    </script>
@endsection