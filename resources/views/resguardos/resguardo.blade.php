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

                        <div class="form-row">                                
                            <div class="form-group col-md-6"> 
                                <label for="area">Áreas:</label>                                        
                                <select class="form-control form-control-chosen" id="area" name="area">
                                    <option value="">Área</option>
                                    @foreach ($areas as $itemarea)
                                        @if (old('area') == $itemarea->idarea)
                                            <option value="{{$itemarea->idarea}}" selected>{{$itemarea->area}}</option>
                                        @else
                                            <option value="{{$itemarea->idarea}}">{{$itemarea->area}}</option>
                                        @endif
                                        @if(count($itemarea->childsactivos))
                                            @include('resguardos.crearoption',['childsactivos' => $itemarea->childsactivos])
                                        @endif
                                    @endforeach    
                                </select>                                           
                            </div>
                            
                            <div class="form-group col-md-6">    
                                <label for="funcionario">Funcionarios:</label>                                    
                                <select class="form-control form-control-chosen" id="funcionario" name="funcionario">
                                    <option value="">Funcionario</option>
                                    @foreach ($funcionarios as $itemfuncionario)
                                        @if (old('funcionario') == $itemfuncionario->idfuncionario)
                                            <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                        @else
                                            <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                        @endif
                                    @endforeach                                        
                                </select>                                        
                            </div>
                        </div>

                        <a class="btn btn-outline-danger" href="javascript:Imprimir();">
                            <i class="fas fa-print"></i> Imprimir
                        </a>
                        
                        <div class="d-none justify-content-center" id="divloading">
                            <div class="spinner-grow divloading" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="font-weight-bolder text-muted font-italic mt-1 mb-2">&nbsp;Cargando...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });

        $(function(){
            $("#area").chosen().change(function(){
                $("#divloading").addClass("d-flex").removeClass("d-none");
                var identificador = $("#area").chosen().val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/bienes/funcionarios/idarea')}}";
                    url = url.replace("idarea", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            $("#funcionario").empty();
                            $("#funcionario").append("<option value=''>Funcionario</option>");
                            for(let i = 0; i< response.length; i++)
                            {
                                $("#funcionario").append("<option value='"+response[i].idfuncionario+"'>"+response[i].nombre+' '+response[i].paterno+' '+response[i].materno+"</option>"); 
                            }
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                            $("#funcionario").trigger("chosen:updated");
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el funcionario!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#funcionario").empty();
                    $("#funcionario").append("<option value=''>Funcionario</option>");
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                    $("#funcionario").trigger("chosen:updated");
                } 
            });
        });

        function Imprimir()
        {
            var idfun = $("#funcionario").chosen().val();
            var url = "{{url('/resguardo/funcionario/idfuncionario')}}";
            url = url.replace("idfuncionario", idfun);
            // $(location).href(url);
            // window.location.href = url;
            window.open(url);
        }
        // $('input[name="rdbuton"]').on('click', function() 
        // {
        //     if ($(this).val() === 'area') 
        //     {     
        //         $('#funcionario').prop("disabled", ! $("#area").prop('disabled'));                
        //         $('#area').prop("disabled", ! $("#funcionario").prop('disabled'));
        //         $('#area').val("");                            
        //     }
        //     else if($(this).val() === 'funcionario');
        //     {    
        //         $('#area').prop("disabled",! $("#area").prop('disabled'));
        //         $('#funcionario').prop("disabled", ! $("#area").prop('disabled'));
                   
        //         $('#funcionario').val("");
        //         $('#area').val("");
        //     }
        // });
    </script>     
@endsection