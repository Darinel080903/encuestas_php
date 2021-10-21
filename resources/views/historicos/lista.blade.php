@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <img id="headerlistalogo" src="{{asset('storage/escudo/secretaria-general-de-gobierno.png')}}" alt="Organismo">
                        <h3 class="headerlistatitulo">Historico del bien</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="input-group mr-2 mb-2">
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <a class="btn btn-outline-danger" href="{{ url('/bienes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </div>
                        
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{session('mensaje')}}</div>
                        @endif 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col" colspan="2">Articulo</th>
                                        <th class="text-center" scope="col">Marca</th>
                                        <th class="text-center" scope="col">Patrimonio</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" scope="col" colspan="2">{{$bien->articulo}}</td>
                                        <td class="text-center" scope="col">{{$bien->marca}}</td>
                                        <td class="text-center" scope="col">{{$bien->patrimonio}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center" scope="col" width="10%">Fecha</th>    
                                        <th class="text-center" scope="col">Acción</th>
                                        <th class="text-center" scope="col">Funcionario</th>
                                        <th class="text-center" scope="col">Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center align-middle" scope="row">{{date('d/m/Y', strtotime("$item->fecha"))}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->accion}}</td>
                                            {{-- <td class="text-justify align-middle" scope="row">{{$item->articulo}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->marca}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->patrimonio}}</td> --}}
                                            <td class="text-justify align-middle" scope="row">{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</td>
                                            <td class="text-justify align-middle" scope="row">{{$item->usuario}}</td>
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
@endsection