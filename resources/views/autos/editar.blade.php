@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar auto</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{url('/autos/'.$autos->idauto)}}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{date('d/m/Y', strtotime($autos->fecha))}}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="origen">Origen:</label>
                                    <select class="form-control @error('origen') is-invalid @enderror form-control-chosen" id="origen" name="origen" required>
                                        <option value="">Origen</option>
                                        @foreach ($origenes as $item)
                                            @if ($autos->fkorigen == $item->idorigen)
                                                <option value="{{$item->idorigen}}" selected>{{$item->origen}}</option>
                                            @else
                                                <option value="{{$item->idorigen}}">{{$item->origen}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>origen</strong> es un campo requerido!
                                    </div>
                                </div>            
                                <div class="form-group col-md-3">
                                    <label for="numero">Número económico:</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" placeholder="Número económico" maxlength="15" value="{{$autos->numero}}" required disabled/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>número </strong> es un campo requerido!
                                    </div>  
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="fabrica">Fabricas:</label>
                                    <select class="form-control @error('fabrica') is-invalid @enderror form-control-chosen" id="fabrica" name="fabrica" required>
                                        <option value="">Fabrica</option>
                                        @foreach ($fabricas as $item)
                                            @if ($autos->fkfabrica == $item->idfabrica)
                                                <option value="{{$item->idfabrica}}" selected>{{$item->fabrica}}</option>
                                            @else
                                                <option value="{{$item->idfabrica}}">{{$item->fabrica}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>fabrica</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tipo">Tipos:</label>
                                    <select class="form-control @error('tipo') is-invalid @enderror form-control-chosen" id="tipo" name="tipo" required>
                                        <option value="">Tipo</option>
                                        @foreach ($tipos as $itemtipo)
                                            @if ($autos->fktipo == $itemtipo->idtipo)
                                                <option value="{{$itemtipo->idtipo}}" selected>{{$itemtipo->tipo}}</option>
                                            @else
                                                <option value="{{$itemtipo->idtipo}}">{{$itemtipo->tipo}}</option>
                                            @endif
                                        @endforeach    
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>tipo</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="modelo">Modelo:</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" placeholder="modelo" maxlength="4" value="{{$autos->modelo}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>modelo</strong> es un campo requerido!
                                    </div>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placa">Número de placas:</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="placa" name="placa" placeholder="Número de placas" maxlength="10" value="{{$autos->placa}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>Numero de placa</strong> es un campo requerido!
                                    </div> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="serie">Número de serie (NIV):</label>
                                    <input type="text" class="form-control" name="serie" placeholder="Número de serie" maxlength="20" value="{{$autos->chasis}}"/>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="motor">Número de motor:</label>
                                    <input type="text" class="form-control" name="motor" placeholder="Motor" max="250" value="{{$autos->motor}}"/>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="transmision">Transmisiones:</label>
                                    <select class="form-control form-control-chosen" id="transmision" name="transmision">
                                        <option value="">Transmisión</option>
                                        @foreach ($transmisiones as $item)
                                            @if ($autos->fktransmision == $item->idtransmision)
                                                <option value="{{$item->idtransmision}}" selected>{{$item->transmision}}</option>
                                            @else
                                                <option value="{{$item->idtransmision}}">{{$item->transmision}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="combustible">Combustibles:</label>
                                    <select class="form-control form-control-chosen" id="combustible" name="combustible">
                                        <option value="">Combustible</option>
                                        @foreach ($combustibles as $item)
                                            @if ($autos->fkcombustible == $item->idcombustible)
                                                <option value="{{$item->idcombustible}}" selected>{{$item->combustible}}</option>
                                            @else
                                                <option value="{{$item->idcombustible}}">{{$item->combustible}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="descripcion">Descripción u observaciones:</label>
                                    <textarea class="form-control" name="descripcion" placeholder="Descripción" rows="2">{{$autos->descripcion}}</textarea>                                
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label for="custodia">Resguardo:</label><br>
                                    <input type="checkbox" class="form-control" id="custodia" name="custodia" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($autos->custodia == 1) {{'checked'}} @endif/>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="funcionario">Funcionario resguardo:</label>
                                    <select class="form-control form-control-chosen" id="funcionario" name="funcionario" @if($autos->custodia != 1) {{'disabled'}} @endif>
                                        <option value="">Funcionario</option>
                                        @foreach ($funcionarios as $item)
                                            @if ($custodia == $item->idfuncionario and $autos->custodia == 1)
                                                <option value="{{$item->idfuncionario}}" selected>{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</option>
                                            @else
                                                <option value="{{$item->idfuncionario}}">{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                @if(count($custodias) > 0)
                                    <div class="table-responsive mb-2">
                                        <table class="table table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center">Ejercicio</th>
                                                    <th class="text-center">Fecha resguardo</th>
                                                    <th class="text-center">Funcionario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($custodias as $item)
                                                    <tr>
                                                        <td class="text-center">{{$item->ejercicio}}</td>
                                                        <td class="text-center">{{date('d/m/Y', strtotime($item->fecha))}}</td>
                                                        <td>{{$item->nombre}} {{$item->paterno}} {{$item->materno}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($autos->activo == 1) {{'checked'}} @endif>
                                </div>
                            </div>
                            
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vactivo" value="{{$vactivo ?? ''}}">
                            <input type="hidden" name="vorigen" value="{{$vorigen ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/autos?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vorigen='.$vorigen.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                            <div class="d-none justify-content-center" id="divloading">
                                <div class="spinner-grow divloading" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="font-weight-bolder text-muted font-italic mt-1 mb-2">&nbsp;Cargando...</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#fecha').datepicker({
            uiLibrary: 'bootstrap4',
            locale: 'es-es',
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });

        $(function(){
            $("#fabrica").change(function(){
                $("#divloading").addClass("d-flex").removeClass("d-none");
                var identificador = $("#fabrica").chosen().val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/autos/fabrica/idfabrica')}}";
                    url = url.replace("idfabrica", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            $("#tipo").empty();
                            $("#tipo").append("<option value=''>Tipo</option>");
                            for(let i = 0; i< response.length; i++)
                            {
                                $("#tipo").append("<option value='"+response[i].idtipo+"'>"+response[i].tipo+"</option>"); 
                            }
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                            $("#tipo").trigger("chosen:updated");
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el tipo!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#tipo").empty();
                    $("#tipo").append("<option value=''>Tipo</option>");
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                    $("#tipo").trigger("chosen:updated");
                } 
            });
        });

        $(function(){
            $("#modelo").validCampoFranz("0123456789");		
    	});

        $("#origen").change(function(){
            if($("#origen").val() != "")
            {
                if($("#origen_chosen").hasClass("is-invalid") === true)
                {
                    $("#origen_chosen").removeClass("is-invalid");
                    $("#origen_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#origen_chosen").hasClass("is-valid") === true)
                {
                    $("#origen_chosen").removeClass("is-valid");
                    $("#origen_chosen").addClass("is-invalid");
                }
            }
        });

        $("#fabrica").change(function(){
            if($("#fabrica").val() != "")
            {
                if($("#fabrica_chosen").hasClass("is-invalid") === true)
                {
                    $("#fabrica_chosen").removeClass("is-invalid");
                    $("#fabrica_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#fabrica_chosen").hasClass("is-valid") === true)
                {
                    $("#fabrica_chosen").removeClass("is-valid");
                    $("#fabrica_chosen").addClass("is-invalid");
                }
            }
        });

        $("#tipo").change(function(){
            if($("#tipo").val() != "")
            {
                if($("#tipo_chosen").hasClass("is-invalid") === true)
                {
                    $("#tipo_chosen").removeClass("is-invalid");
                    $("#tipo_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#tipo_chosen").hasClass("is-valid") === true)
                {
                    $("#tipo_chosen").removeClass("is-valid");
                    $("#tipo_chosen").addClass("is-invalid");
                }
            }
        });

        $("#funcionario").change(function(){
            if($("#funcionario").val() != "" && $("#custodia").prop('checked') == true)
            {
                if($("#funcionario_chosen").hasClass("is-invalid") === true)
                {
                    $("#funcionario_chosen").removeClass("is-invalid");
                    $("#funcionario_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#funcionario_chosen").hasClass("is-valid") === true)
                {
                    $("#funcionario_chosen").removeClass("is-valid");
                    $("#funcionario_chosen").addClass("is-invalid");
                }
            }
        });

        $(document).ready(function(){
            if($("#origen").val() === "1")
            {
                $("#numero").prop("disabled", false); 
                $("#numero").prop("required", true);                   
            } 
            else
            {
                $("#numero").prop("disabled", true);
                $("#numero").prop("required", false);
            }
        });

        $(function(){
            $("#origen").change( function(){
                if($(this).val() === "1")
                {
                    $("#numero").val("");  
                    $("#numero").prop("disabled", false); 
                    $("#numero").prop("required", true);                   
                } 
                else
                {
                    $("#numero").val("");  
                    $("#numero").prop("disabled", true);
                    $("#numero").prop("required", false);
                }
            });
        });

        $(function(){
            $("#custodia").change(function(){
                if($(this).prop('checked') == true){
                    $("#funcionario").prop("disabled", false);
                    $("#funcionario").trigger("chosen:updated");
                    $("#funcionario").prop("required", true);
                    if($("#frm").hasClass("was-validated")){
                        $("#funcionario_chosen").removeClass("is-valid");
                        $("#funcionario_chosen").addClass("is-invalid");
                    }
                }
                else{
                    $("#funcionario").prop("disabled", true);
                    $('#funcionario').val('').trigger('chosen:updated');
                    $("#funcionario").prop("required", false);
                    if($("#frm").hasClass("was-validated")){
                        $("#funcionario_chosen").removeClass("is-invalid");
                        $("#funcionario_chosen").addClass("is-valid");
                    }                    
                }
            });
        });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();

                    if($("#origen").val() == "")
                    {
                        $('#origen_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#origen_chosen').addClass('is-valid');
                    }

                    if($("#fabrica").val() == "")
                    {
                        $('#fabrica_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#fabrica_chosen').addClass('is-valid');
                    }

                    if($("#tipo").val() == "")
                    {
                        $('#tipo_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#tipo_chosen').addClass('is-valid');
                    }

                    $('#transmision_chosen').addClass('is-valid');
                    $('#combustible_chosen').addClass('is-valid');

                    if($("#funcionario").val() == "" && $("#custodia").prop('checked') == true)
                    {
                        $('#funcionario_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#funcionario_chosen').addClass('is-valid');
                    }
                    // $('#funcionario_chosen').addClass('is-valid');
                }
                form.classList.add('was-validated');

                if($("#origen").val() != "")
                {
                    $('#origen_chosen').addClass('is-valid');
                }

                if($("#fabrica").val() != "")
                {
                    $('#fabrica_chosen').addClass('is-valid');
                }

                if($("#tipo").val() != "")
                {
                    $('#tipo_chosen').addClass('is-valid');
                }

                $('#transmision_chosen').addClass('is-valid');
                $('#combustible_chosen').addClass('is-valid');
                
                if($("#funcionario").val() != "")
                {
                    $('#funcionario_chosen').addClass('is-valid');
                }
                // $('#funcionario_chosen').addClass('is-valid');

              }, false);
            });
          }, false);
        })();
    </script>
@endsection