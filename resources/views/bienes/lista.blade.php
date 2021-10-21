@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <img id="headerlistalogo" src="{{asset('storage/escudo/secretaria-general-de-gobierno.png')}}" alt="Organismo">
                        <h3 class="headerlistatitulo">Listado de bienes</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-inline" id="frmbusqueda" method="GET" action="{{url('/bienes')}}" >
                        @csrf
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" id="vfecha" name="vfecha" placeholder="Fecha" aria-label="Fecha" value="{{$vfecha}}" readonly>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <input type="text" class="form-control" name="vbusqueda" placeholder="Búsqueda" aria-label="Búsqueda" aria-describedby="button-addon2" value="{{$vbusqueda}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-danger" id="button-addon2"><i class="fas fa-search"></i> Buscar</button>
                                    <a class="btn btn-outline-danger" href="{{url('/bienes')}}"><i class="fas fa-broom"></i> Limpiar</a>
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
                                        <th class="text-center" scope="col" width="10%">Artículo</th>    
                                        <th class="text-center" scope="col">Marca</th>
                                        <th class="text-center" scope="col">Patrimonio</th>
                                        <th class="text-center" scope="col">Estado</th>
                                        <th class="text-center" scope="col">Cédula</th>
                                        <th class="text-center" scope="col">Funcionario</th>
                                        <th class="text-center" scope="col">Fecha</th>
                                        <th class="text-center" scope="col" width="45%" colspan="4">
                                            @can('create', \App\Models\Vbien::class)
                                                <a class="btn btn-outline-danger" href="{{url('/bienes/create?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-save"></i> Nuevo</a>
                                            @endcan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bienes as $item)
                                        <tr>
                                            <td class="text-justify align-middle" scope="row">{{$item->articulo}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->marca}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->patrimonio}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->estado}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->cedula}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</td>
                                            <td class="text-center align-middle" scope="row">{{date('d/m/Y', strtotime("$item->fecha"))}}</td>                                           
                                            <td class="text-center" width="11%">
                                                @can('update', $item)
                                                    <a class="btn btn-outline-danger" href="{{url('/bienes/'.$item->idbien.'/edit?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-pen"></i> Editar</a>
                                                @endcan
                                            </td>
                                            <td class="text-center" width="11%">
                                                @can('update', $item)
                                                    <form id="frmimgpublicar{{$item->idbien}}" name="frmimgpublicar{{$item->idbien}}" method="POST" action="{{url('/bienes/'.$item->idbien.'/update2')}}">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idbien}}')" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                                    </form>
                                                @endcan
                                            </td>
                                            <td class="text-center" width="11%">
                                                @can('delete', $item)
                                                    <form id="frmeliminar{{$item->idbien}}" name="frmeliminar{{$item->idbien}}" method="POST" action="{{url('/bienes/'.$item->idbien)}}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" class="btn btn-outline-danger btneliminar" onclick="funeliminar('frmeliminar{{$item->idbien}}')"><i class="fas fa-trash"></i> Borrar</button>
                                                    </form>
                                                @endcan
                                            </td>
                                            <td class="text-center" width="12%">
                                                <a class="btn btn-outline-danger" href="{{url('/bienes/historico/'.$item->idbien.'?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-history"></i> Historial</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-md-center">
                            {{$bienes->withQueryString()->links('pagination::bootstrap-4')}}
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
	
			$("#Vbien").change(function()
			{
				$("#frmbusqueda").submit();
			});
		});

        $("#toggle-demo").bootstrapToggle();

        function funpublicar(frm)
        {
            $("#"+frm).submit();
        }

        function funeliminar(frm)
        {
            $.confirm({
                title: 'Borrar',
                content: '¡Confirmación!',
                type: 'dark',
                typeAnimated: true,
                buttons:{
                    yes:{
                        text: 'Si',
                        btnClass: 'btn-success',
                        keys: ['enter'],
                        action: function(){
                            $("#"+frm).submit();
                        }
                    },
                    no: function(){
                    },
                }
            });
        }
    </script>
@endsection