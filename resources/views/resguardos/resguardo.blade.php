@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Resguardos</h3>
                    </div>                   
                    <div class="card-body">                  
                        <form class="needs-validation" method="POST" action="{{url('/resguardos')}}" novalidate>
                        @csrf
                            <div class="form-row">                                
                                <div class="form-group col-md-4">
                                    <div> 
                                        <input type="radio" value="area" name="rdbuton" id="rdbarea" checked="checked" >                                                                               
                                        <label for="area">Áreas:</label>                                        
                                        <select class="form-control" id="area" name="area" >
                                            <option value="">Áreas</option>
                                            @foreach ($areas as $itemarea)
                                                @if (old('area') == $itemarea->idarea)
                                                    <option value="{{$itemarea->idarea}}" selected>{{$itemarea->area}}</option>
                                                @else
                                                    <option value="{{$itemarea->idarea}}">{{$itemarea->area}}</option>
                                                @endif
                                            @endforeach    
                                        </select>                                           
                                    </div>
                                </div>                        
                            </div>
                            <br>
                            <div class="form-row">    
                                <div class="form-group col-md-4">
                                    <div>                                        
                                        <input type="radio" value="funcionario" name="rdbuton" id="rdbfuncionario" >
                                        <label for="funcionario">Funcionarios:</label>                                    
                                        <select class="form-control" id="funcionario" name="funcionario" disabled>
                                            <option value="">Funcionario</option>
                                            @foreach ($funcionarios as $itemfuncionario)
                                                @if (old('funcionario') == $itemfuncionario->idfuncionario)
                                                    <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre}}</option>
                                                @else
                                                    <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre}}</option>
                                                @endif
                                            @endforeach                                        
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                            <br>                     
                            <a class="btn btn-outline-danger" href="{{ url('/resguardo/funcionario/1') }}"><i class="fas fa-print"></i> Imprimir</a>                            
                            <a class="btn btn-outline-danger" href="{{ url('/bienes?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>                                       
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

        $('input[name="rdbuton"]').on('click', function() 
        
        {
            if ($(this).val() === 'area') 
            {     
                           
                $('#funcionario').prop("disabled", ! $("#area").prop('disabled'));                
                $('#area').prop("disabled", ! $("#funcionario").prop('disabled'));
               
                $('#area').val(""); 
               
                                       
            }
            else if($(this).val() === 'funcionario');
            {    
                $('#area').prop("disabled",! $("#area").prop('disabled'));
                $('#funcionario').prop("disabled", ! $("#area").prop('disabled'));
                   
                $('#funcionario').val("");
                $('#area').val("");
            }
        });

    </script>     
@endsection