@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Devoluciones</h3>
                    </div>                   
                    <div class="card-body">
                        <form class="needs-validation" id="formmain" action="javascript:Imprimir();" novalidate>
                            
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
                                    <select class="form-control form-control-chosen" id="funcionario" name="funcionario" required>
                                        <option value="">Funcionario</option>
                                        @foreach ($funcionarios as $itemfuncionario)
                                            @if (old('funcionario') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach                                        
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>funcionario</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">    
                                    <div class="table-responsive">                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Acción</th>
                                                    <th class="text-center">Artículo</th>
                                                    <th class="text-center">Marca</th>
                                                    <th class="text-center">No. de patrimonio</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="listado"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <input type="text" name="detalle" id="detalle">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-print"></i> Imprimir</button>
        
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
        var Detalle = [];

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
                            $("#formmain").removeClass("was-validated");
                            $("#funcionario_chosen").removeClass("is-valid");
                            $("#funcionario_chosen").removeClass("is-invalid");

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

        $(function(){
            $("#funcionario").chosen().change(function(){
                $("#divloading").addClass("d-flex").removeClass("d-none");
                var identificador = $("#funcionario").chosen().val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/devoluciones/devolucion/idfuncionario')}}";
                    url = url.replace("idfuncionario", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            $("#listado").empty();
                            for(let i = 0; i< response.length; i++)
                            {
                                var fecha = new Date(response[i].fecha);
                                var dia = fecha.getDate();
                                var mes = 1 + fecha.getMonth();
                                var anio = fecha.getFullYear();
                                var fechaformat = dia+"/"+mes+"/"+anio;
                                $('#listado').append("<tr><td class='text-center'>"+fechaformat+"</td><td>"+response[i].accion+"</td><td>"+response[i].articulo+"</td><td>"+response[i].marca+"</td><td>"+response[i].patrimonio+"</td><td class='text-center'><input type='checkbox' id='activo"+i+"' name='activo"+i+"' onchange='Guardar("+i+", "+response[i].idhistorico+");' data-toggle='toggle' data-on='Activo' data-off='Inactivo' data-onstyle='success' data-offstyle='danger'></td></tr>");
                            }
                            $("#toggle-demo").bootstrapToggle();
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                            $("#detalle").val("");
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar las devoluciones!");
                            $("#detalle").val("");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#listado").empty();
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                } 
            });
        });

        function Guardar(numero, identificador)
        {
            if($("#activo"+numero).prop("checked") == true)
            {
                // console.log(identificador);
                Detalle.push({idhistorico:identificador});    
                $("#detalle").val(JSON.stringify(Detalle));
            }
            else
            {
                // console.log("false");
                Detalle.splice(numero, 1);
                $("#detalle").val(JSON.stringify(Detalle));
            }
        }

        function Imprimir()
        {
            var idfun = $("#funcionario").chosen().val();
            var url = "{{url('/resguardo/funcionario/idfuncionario')}}";
            url = url.replace("idfuncionario", idfun);
            window.open(url);
        }

        $("#funcionario").change(function(){
            if($("#funcionario").val() != "")
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
                        if($("#funcionario").val() == "")
                        {
                            $("#funcionario_chosen").addClass("is-invalid");
                        }
                        else
                        {
                            $("#funcionario_chosen").addClass("is-valid");
                        }
                    }
                    form.classList.add('was-validated');
                    if($("#funcionario").val() != "")
                    {
                        $("#funcionario_chosen").addClass("is-valid");
                    }
              }, false);
            });
          }, false);
        })();
    </script>     
@endsection