@extends('layouts.app')

@section('content')

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="needs-validation" id="formmodal" action="javascript:tmpguardarbien();" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="articulomodal">Artículos:</label>
                                <select class="form-control @error('articulomodal') is-invalid @enderror form-control-chosen" id="articulomodal" name="articulomodal" required>
                                    <option value="">Artículo</option>
                                    @foreach ($articulosmodal as $itemarticulomodal)
                                        @if (old('articulomodal') == $itemarticulomodal->idarticulo)
                                            <option value="{{$itemarticulomodal->idarticulo}}" selected>{{$itemarticulomodal->articulo}}</option>
                                        @else
                                            <option value="{{$itemarticulomodal->idarticulo}}">{{$itemarticulomodal->articulo}}</option>
                                        @endif
                                    @endforeach  
                                </select>
                                <div class="invalid-feedback">
                                    ¡El <strong>artículo</strong> es un campo requerido!
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="marcamodal">Marcas:</label>
                                <select class="form-control @error('marcamodal') is-invalid @enderror form-control-chosen" id="marcamodal" name="marcamodal" required>
                                    <option value="">Marca</option>
                                    @foreach ($marcas as $itemmarca)
                                        @if (old('articulo') == $itemmarca->idmarca)
                                            <option value="{{$itemmarca->idmarca}}" selected>{{$itemmarca->marca}}</option>
                                        @else
                                            <option value="{{$itemmarca->idmarca}}">{{$itemmarca->marca}}</option>
                                        @endif
                                    @endforeach  
                                </select>
                                <div class="invalid-feedback">
                                    ¡La <strong>marca</strong> es un campo requerido!
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="modelomodal">Modelo:</label>
                                <input type="text" class="form-control" id="modelomodal" name="modelomodal" placeholder="Modelo" max="250" value="{{$bienes->modelomodal}}"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="seriemodal">Serie:</label>
                                <input type="text" class="form-control" id="seriemodal" name="seriemodal" placeholder="Número de serie" max="250" value="{{$bienes->seriemodal}}" />                                     
                            </div>

                            <div class="form-group col-md-4">
                                <label for="patrimoniomodal">Patrimonio:</label>
                                <input type="text" class="form-control" id="patrimoniomodal" name="patrimoniomodal" placeholder="Número de patrimonio" max="250" value="{{$bienes->patrimoniomodal}}"/>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="estadomodal">Estados:</label>
                                <select class="form-control @error('estadomodal') is-invalid @enderror form-control-chosen" id="estadomodal" name="estadomodal" required>
                                    <option value="">Estado</option>
                                    @foreach ($estados as $itemestado)
                                        @if ($bienes->fkestado == $itemestado->idestado)
                                            <option value="{{$itemestado->idestado}}" selected>{{$itemestado->estado}}</option>
                                        @else
                                            <option value="{{$itemestado->idestado}}">{{$itemestado->estado}}</option>
                                        @endif
                                    @endforeach  
                                </select>
                                <div class="invalid-feedback">
                                    ¡El <strong>estado</strong> es un campo requerido!
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="observacionmodal">Observaciones:</label>
                                <textarea class="form-control" id="observacionmodal" name="observacionmodal" cols="30" rows="2">{{$bienes->observacionmodal}}</textarea>
                            </div> 
                        </div>
                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar bien</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" id="formmain" action="{{url('/bienes/'.$bienes->idbien)}}" method="POST" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="articulo">Artículos:</label>
                                    <select class="form-control @error('articulo') is-invalid @enderror form-control-chosen" id="articulo" name="articulo" required>
                                        <option value="">Artículo</option>
                                        @foreach ($articulos as $itemarticulo)
                                            @if ($bienes->fkarticulo == $itemarticulo->idarticulo)
                                                <option value="{{$itemarticulo->idarticulo}}" selected>{{$itemarticulo->articulo}}</option>
                                            @else
                                                <option value="{{$itemarticulo->idarticulo}}">{{$itemarticulo->articulo}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                    <div class="invalid-feedback">
                                        ¡El <strong>artículo</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="marca">Marcas:</label>
                                    <select class="form-control @error('marca') is-invalid @enderror form-control-chosen" id="marca" name="marca">
                                        <option value="">Marca</option>
                                        @foreach ($marcas as $itemmarca)
                                            @if ($bienes->fkmarca == $itemmarca->idmarca)
                                                <option value="{{$itemmarca->idmarca}}" selected>{{$itemmarca->marca}}</option>
                                            @else
                                                <option value="{{$itemmarca->idmarca}}">{{$itemmarca->marca}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>marca</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="modelo">Modelo:</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo" max="250" value="{{$bienes->modelo}}"/>
                                </div>
                            </div>
                            <div class="form-row @if($raiz != 1) {{'d-none'}} @endif" id="divcampos">   
                                <div class="form-group col-md-3">
                                    <label for="procesador">Procesador:</label>
                                    <input type="text" class="form-control" id="procesador" name="procesador" placeholder="Procesador" max="250" value="{{$bienes->procesador}}"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="memoria">Memoria:</label>
                                    <input type="text" class="form-control" id="memoria" name="memoria" placeholder="Memoria" max="250" value="{{$bienes->memoria}}"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="disco">Disco:</label>
                                    <input type="text" class="form-control" id="disco" name="disco" placeholder="Disco" max="250" value="{{$bienes->disco}}"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="serie">Ip:</label>
                                    <input type="text" class="form-control" id="ip" name="ip" placeholder="Ip" max="250" value="{{$bienes->ip}}"/>                                    
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="operativo">Sistemas operativos:</label>
                                    <select class="form-control form-control-chosen" id="operativo" name="operativo">
                                        <option value="">Sistema operativo</option>
                                        @foreach ($operativos as $itemoperativo)
                                            @if ($bienes -> fkoperativo == $itemoperativo->idoperativo)
                                                <option value="{{$itemoperativo->idoperativo}}" selected>{{$itemoperativo->operativo}}</option>
                                                @else
                                                <option value="{{$itemoperativo->idoperativo}}">{{$itemoperativo->operativo}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>                      
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="serie">Número de serie:</label>
                                    <input type="text" class="form-control" id="serie" name="serie" placeholder="Número de serie" max="250" value="{{$bienes->serie}}" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="patrimonio">Número de patrimonio:</label>
                                    <input type="text" class="form-control " id="patrimonio" name="patrimonio" placeholder="Número de patrimonio" max="250" value="{{$bienes->patrimonio}}" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cedula">Cédulas:</label>
                                    <select class="form-control form-control-chosen" id="cedula" name="cedula">
                                        <option value="">Cédula</option>
                                        @foreach ($cedulas as $itemcedula)
                                            @if ($bienes -> fkcedula == $itemcedula->idcedula)
                                                <option value="{{$itemcedula->idcedula}}" selected>{{$itemcedula->cedula}}</option>
                                                @else
                                                <option value="{{$itemcedula->idcedula}}">{{$itemcedula->cedula}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="estado">Estados:</label>
                                    <select class="form-control @error('estado') is-invalid @enderror form-control-chosen" id="estado" name="estado" required>
                                        <option value="">Estado</option>
                                        @foreach ($estados as $itemestado)
                                            @if ($bienes->fkestado == $itemestado->idestado)
                                                <option value="{{$itemestado->idestado}}" selected>{{$itemestado->estado}}</option>
                                            @else
                                                <option value="{{$itemestado->idestado}}">{{$itemestado->estado}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>estado</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>    
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="observacion">Observaciones:</label>
                                    <textarea class="form-control" id="observacion" name="observacion" cols="30" rows="4">{{$bienes->observacion}}</textarea>
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="area">Áreas:</label>
                                    <select class="form-control form-control-chosen" id="area" name="area">
                                        <option value="">Area</option>
                                        @foreach ($areas as $itemarea)
                                            @if ($bienes->fkarea == $itemarea->idarea)
                                                <option value="{{$itemarea->idarea}}" selected>{{$itemarea->area}}</option>
                                                @else
                                                <option value="{{$itemarea->idarea}}">{{$itemarea->area}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="funcionario">Funcionarios:</label>
                                    <select class="form-control form-control-chosen" id="funcionario" name="funcionario">
                                        <option value="">Funcionario</option>
                                        @foreach ($funcionarios as $itemfuncionario)
                                            @if ($bienes ->fkfuncionario == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                                @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date('d/m/Y') }}" readonly/>
                                </div>
                            </div>
                            <div class="form-row @if($raiz != 1) {{'d-none'}} @endif" id="divbienes">
                                <div class="form-group col-md-12">
                                    {{-- <label for="area">Áreas:</label> --}}
                                    <button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fas fa-plus"></i> <i class="fas fa-keyboard"></i> <i class="fas fa-mouse"></i> Agregar artículos dependientes...
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="listaarticulos">
                                    
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="10%" scope="col">Artículo</th>    
                                                <th class="text-center" scope="col">Marca</th>
                                                <th class="text-center" scope="col">Modelo</th>
                                                <th class="text-center" scope="col">Serie</th>
                                                <th class="text-center" scope="col">Patrimonio</th>
                                                <th class="text-center" scope="col">Estado</th>
                                                <th class="text-center" scope="col">Observacion</th>
                                                <th class="text-center" scope="col"></th>
                                            </tr>
                                        </thead>
                                    
                                        @foreach ($tmpbienes as $item)
                                                                        
                                            <tr>                                            
                                                <th class="text-center" width="10%" scope="col">{{$item->articulo}}</th>
                                                <th class="text-center" scope="col">{{$item->marca}}</th>
                                                <th class="text-center" scope="col">{{$item->modelo}}</th>
                                                <th class="text-center" scope="col">{{$item->serie}}</th>
                                                <th class="text-center" scope="col">{{$item->patrimonio}}</th>
                                                <th class="text-center" scope="col">{{$item->estado}}</th>
                                                <th class="text-center" scope="col">{{$item->observacion}}</th>
                                                <td><a class="btn btn-primary" href="javascript:eliminartmpbien({{$item->idtmpbien}});">Eliminar</a></td>                                           
                                            </tr>

                                        @endforeach
                                    
                                    </table>
                                </div>   
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($bienes->activo == 1) {{'checked'}} @endif>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/bienes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });

        $(document).ready(function()
        {
            $("#fecha").datepicker({
                uiLibrary: "bootstrap4",
                locale: "es-es",
                format: "dd/mm/yyyy"
            });
        });
        
        $(function(){
            $("#articulo").change(function(){
                var url = "{{url('bienes/campos/idarticulo')}}";    //sirve para colocar el nombre de la pagina completa 
                url = url.replace("idarticulo", event.target.value);                   
                $.get(url, function(response, state){
                    if(response.dato == 1)
                    {
                        $("#procesador").val("");
                        $("#memoria").val("");
                        $("#disco").val("");
                        $("#ip").val("");
                        $("#divcampos").removeClass("d-none");
                    }
                    else
                    {
                        $("#procesador").val("");
                        $("#memoria").val("");
                        $("#disco").val("");
                        $("#ip").val("");
                        $("#divcampos").addClass("d-none");
                    }
                    if(response.raiz == 1)
                    {
                        $("#divbienes").removeClass("d-none");
                    }
                    else
                    {
                        $("#divbienes").addClass("d-none");
                    }
                }); 
            });
        });
       
        function tmpguardarbien()
        {       
            var articulo = $("#articulomodal").val();
            var marca = $("#marcamodal").val();
            var modelo = $("#modelomodal").val();
            var serie = $("#seriemodal").val();
            var patrimonio = $("#patrimoniomodal").val();
            var estado = $("#estadomodal").val();
            var observacion = $("#observacionmodal").val();

            var url = "{{url('savetmp')}}";    //sirve para colocar el nombre de la pagina completa 
                 
            $.ajax({                  
                type: "get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                url: url,
                dataType: "json",
                data: {articulomodal:articulo, marcamodal:marca, modelomodal:modelo, seriemodal:serie, patrimoniomodal:patrimonio, estadomodal:estado, observacionmodal:observacion},
                success: function(response, textStatus, xhr)
                {
                    if(response == "R")
                    {
                        alert("registro existente");
                    }
                    else
                    {
                        $("#listaarticulos").empty();
                        $('#listaarticulos').append("<tr><th>Articulo</th><th>Marca</th><th>Modelo</th><th>Serie</th><th>Patrimonio</th><th>Estado</th><th>Observacion</th><th>Eliminar</th></tr>");

                        for(let i = 0; i< response.length; i++) 
                        {   
                            // $("#listaarticulos").append("<li class='list-group-item d-flex justify-content-between align-items-center'>"+response[i].fkarticulo+"</li>");                        
                            $('#listaarticulos').append("<tr><td>"+response[i].articulo+"</td><td>"+response[i].marca+"</td><td>"+response[i].modelo+"</td><td>"+response[i].serie+"</td><td>"+response[i].patrimonio+"</td><td>"+response[i].estado+"</td><td>"+response[i].observacion+"</td><td><a class='btn btn-primary id='message-delete' href='javascript:eliminartmpbien("+response[i].idtmpbien+");'>Eliminar</a></td></tr>");
                                                
                        }   
                    }
                },
                error: function(xhr, textStatus, errorThrown)
                {
                    alert("¡Error al guardar la dependencia!");                 
                }                
            });              
        }

        function eliminartmpbien(id)
        {
            var url = "{{url('eliminatmpbien/id')}}";
            url = url.replace("id", id); 
            var token = $("#token").val();
            $.ajax
            ({
                url: url,
                type: 'get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                
                success: function(response, textStatus, xhr) 
                {
                    $("#listaarticulos").empty();
                    $('#listaarticulos').append("<tr><th>Articulo</th><th>Marca</th><th>Modelo</th><th>Serie</th><th>Patrimonio</th><th>Estado</th><th>Observacion</th><th>Eliminar</th></tr>");

                    for(let i = 0; i< response.length; i++) 
                    {                               
                        $('#listaarticulos').append("<tr><td>"+response[i].articulo+"</td><td>"+response[i].marca+"</td><td>"+response[i].modelo+"</td><td>"+response[i].serie+"</td><td>"+response[i].patrimonio+"</td><td>"+response[i].estado+"</td><td>"+response[i].observacion+"</td><td><a class='btn btn-primary id='message-delete' href='javascript:eliminartmpbien("+response[i].idtmpbien+");'>Eliminar</a></td></tr>");
                                                
                    }   
                }
            });
        }

        //Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() 
        {
          'use strict';
          window.addEventListener('load', function() 
           {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) 
                {
                    form.addEventListener('submit', function(event) 
                    {
                        if (form.checkValidity() === false) 
                        {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })(); 
    </script>
@endsection