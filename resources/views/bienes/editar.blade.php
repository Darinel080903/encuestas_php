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
                                <input type="text" class="form-control @error('seriemodal') is-invalid @enderror" id="seriemodal" name="seriemodal" placeholder="Número de serie" max="250" value="{{old('seriemodal')}}" required/>
                                <div class="invalid-feedback">
                                    ¡El <strong>número de serie</strong> es un campo requerido!
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="patrimoniomodal">Patrimonio:</label>
                                <input type="text" class="form-control @error('patrimoniomodal') is-invalid @enderror" id="patrimoniomodal" name="patrimoniomodal" placeholder="Número de patrimonio" max="250" value="{{old('patrimoniomodal')}}" required/>
                                <div class="invalid-feedback">
                                    ¡El <strong>número de patrimonio</strong> es un campo requerido!
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="estadomodal">Estados:</label>
                                <select class="form-control @error('estadomodal') is-invalid @enderror form-control-chosen" id="estadomodal" name="estadomodal" required>
                                    <option value="">Estado</option>
                                    @foreach ($estados as $itemestado)
                                        @if (old('estadomodal') == $itemestado->idestado)
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
                                <textarea class="form-control" id="observacionmodal" name="observacionmodal" cols="30" rows="2">{{old('observacionmodal')}}</textarea>
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
                                            @if ($bienes->fkoperativo == $itemoperativo->idoperativo)
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
                                            @if ($bienes->fkcedula == $itemcedula->idcedula)
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
                                <div class="form-group col-md-6">
                                    <label for="area">Áreas:</label>
                                    <select class="form-control form-control-chosen" id="area" name="area">
                                        <option value="">Area</option>
                                        @foreach ($areas as $itemarea)
                                            @if (old('area') == $itemarea->idarea)
                                                <option value="{{$itemarea->idarea}}" selected>{{$itemarea->area}}</option>
                                                @else
                                                <option value="{{$itemarea->idarea}}">{{$itemarea->area}}</option>
                                            @endif
                                            @if(count($itemarea->childsactivos))
                                                @include('bienes.crearoption',['childsactivos' => $itemarea->childsactivos])
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="funcionario">Funcionarios:</label>
                                    <select class="form-control form-control-chosen" id="funcionario" name="funcionario">
                                        <option value="">Funcionario</option>
                                        @foreach ($funcionarios as $itemfuncionario)
                                            @if ($bienes->fkfuncionario == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                                @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>

                                <div class="form-group col-md-2">
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
                                                <td class="text-center" width="10%" scope="col">{{$item->articulo}}</td>
                                                <td class="text-center" scope="col">{{$item->marca}}</td>
                                                <td class="text-center" scope="col">{{$item->modelo}}</td>
                                                <td class="text-center" scope="col">{{$item->serie}}</td>
                                                <td class="text-center" scope="col">{{$item->patrimonio}}</td>
                                                <td class="text-center" scope="col">{{$item->estado}}</td>
                                                <td class="text-center" scope="col">{{$item->observacion}}</td>
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
            $("#articulo").chosen().change(function(){
                var url = "{{url('bienes/campos/idarticulo')}}";    //sirve para colocar el nombre de la pagina completa 
                var identificador = $("#articulo").chosen().val();
                url = url.replace("idarticulo", identificador);                   
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
                            var showobservacion = "";
                            if(response[i].observacion)
                            {
                                var showobservacion = response[i].observacion;
                            }
                            var showmodelo = "";
                            if(response[i].modelo)
                            {
                                var showmodelo = response[i].modelo;
                            }
                            $('#listaarticulos').append("<tr><td>"+response[i].articulo+"</td><td>"+response[i].marca+"</td><td>"+showmodelo+"</td><td>"+response[i].serie+"</td><td>"+response[i].patrimonio+"</td><td>"+response[i].estado+"</td><td>"+showobservacion+"</td><td><a class='btn btn-primary id='message-delete' href='javascript:eliminartmpbien("+response[i].idtmpbien+");'>Eliminar</a></td></tr>");
                        }
                        limpiar();   
                    }
                },
                error: function(xhr, textStatus, errorThrown)
                {
                    alert("¡Error al guardar la dependencia!");                 
                }                
            });              
        }

        function limpiar()
        {
            $("#formmodal").removeClass("was-validated");

            $("#articulomodal option:selected").prop("selected", false);
            $("#articulomodal").trigger("chosen:updated");
            $("#articulomodal_chosen").removeClass("is-valid");

            $("#marcamodal option:selected").prop("selected", false);
            $("#marcamodal").trigger("chosen:updated");
            $("#marcamodal_chosen").removeClass("is-valid");
            
            $("#modelomodal").val("");
            $("#seriemodal").val("");
            $("#patrimoniomodal").val("");
            
            $("#estadomodal option:selected").prop("selected", false);
            $("#estadomodal").trigger("chosen:updated");
            $("#estadomodal_chosen").removeClass("is-valid");
            
            $("#observacionmodal").val("");
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

        $("#articulomodal").change(function(){
            if($("#articulomodal").val() != "")
            {
                if($("#articulomodal_chosen").hasClass("is-invalid") === true)
                {
                    $("#articulomodal_chosen").removeClass("is-invalid");
                    $("#articulomodal_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#articulomodal_chosen").hasClass("is-valid") === true)
                {
                    $("#articulomodal_chosen").removeClass("is-valid");
                    $("#articulomodal_chosen").addClass("is-invalid");
                }
            }
        });

        $("#marcamodal").change(function(){
            if($("#marcamodal").val() != "")
            {
                if($("#marcamodal_chosen").hasClass("is-invalid") === true)
                {
                    $("#marcamodal_chosen").removeClass("is-invalid");
                    $("#marcamodal_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#marcamodal_chosen").hasClass("is-valid") === true)
                {
                    $("#marcamodal_chosen").removeClass("is-valid");
                    $("#marcamodal_chosen").addClass("is-invalid");
                }
            }
        });
        
        $("#estadomodal").change(function(){
            if($("#estadomodal").val() != "")
            {
                if($("#estadomodal_chosen").hasClass("is-invalid") === true)
                {
                    $("#estadomodal_chosen").removeClass("is-invalid");
                    $("#estadomodal_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#estadomodal_chosen").hasClass("is-valid") === true)
                {
                    $("#estadomodal_chosen").removeClass("is-valid");
                    $("#estadomodal_chosen").addClass("is-invalid");
                }
            }
        });

        $("#articulo").change(function(){
            if($("#articulo").val() != "")
            {
                if($("#articulo_chosen").hasClass("is-invalid") === true)
                {
                    $("#articulo_chosen").removeClass("is-invalid");
                    $("#articulo_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#articulo_chosen").hasClass("is-valid") === true)
                {
                    $("#articulo_chosen").removeClass("is-valid");
                    $("#articulo_chosen").addClass("is-invalid");
                }
            }
        });

        $("#marca").change(function(){
            if($("#marca").val() != "")
            {
                if($("#marca_chosen").hasClass("is-invalid") === true)
                {
                    $("#marca_chosen").removeClass("is-invalid");
                    $("#marca_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#marca_chosen").hasClass("is-valid") === true)
                {
                    $("#marca_chosen").removeClass("is-valid");
                    $("#marca_chosen").addClass("is-invalid");
                }
            }
        });

        $("#estado").change(function(){
            if($("#estado").val() != "")
            {
                if($("#estado_chosen").hasClass("is-invalid") === true)
                {
                    $("#estado_chosen").removeClass("is-invalid");
                    $("#estado_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#estado_chosen").hasClass("is-valid") === true)
                {
                    $("#estado_chosen").removeClass("is-valid");
                    $("#estado_chosen").addClass("is-invalid");
                }
            }
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

                            if(form.id == "formmodal")
                            {
                                if($("#articulomodal").val() == "")
                                {
                                    $("#articulomodal_chosen").addClass("is-invalid");
                                }
                                else
                                {
                                    $("#articulomodal_chosen").addClass("is-valid");
                                }

                                if($("#marcamodal").val() == "")
                                {
                                    $("#marcamodal_chosen").addClass("is-invalid");
                                }
                                else
                                {
                                    $("#marcamodal_chosen").addClass("is-valid");
                                }
                                
                                if($("#estadomodal").val() == "")
                                {
                                    $("#estadomodal_chosen").addClass("is-invalid");
                                }
                                else
                                {
                                    $("#estadomodal_chosen").addClass("is-valid");
                                }    
                            }

                            if(form.id == "formmain")
                            {
                                if($("#articulo").val() == "")
                                {
                                    $("#articulo_chosen").addClass("is-invalid");
                                }
                                else
                                {
                                    $("#articulo_chosen").addClass("is-valid");
                                }

                                if($("#marca").val() == "")
                                {
                                    $("#marca_chosen").addClass("is-invalid");
                                }
                                else
                                {
                                    $("#marca_chosen").addClass("is-valid");
                                }
                                
                                $("#operativo_chosen").addClass("is-valid");
                                $("#cedula_chosen").addClass("is-valid");
                                
                                if($("#estado").val() == "")
                                {
                                    $("#estado_chosen").addClass("is-invalid");
                                }
                                else
                                {
                                    $("#estado_chosen").addClass("is-valid");
                                }

                                $("#area_chosen").addClass("is-valid");
                                $("#funcionario_chosen").addClass("is-valid");
                            }
                        }
                        form.classList.add('was-validated');

                        if(form.id == "formmodal")
                        {
                            if($("#articulomodal").val() != "")
                            {
                                $("#articulomodal_chosen").addClass("is-valid");
                            }
                            
                            if($("#marcamodal").val() != "")
                            {
                                $("#marcamodal_chosen").addClass("is-valid");
                            }
                            
                            if($("#estadomodal").val() != "")
                            {
                                $("#estadomodal_chosen").addClass("is-valid");
                            }
                        }

                        if(form.id == "formmain")
                        {
                            if($("#articulo").val() != "")
                            {
                                $("#articulo_chosen").addClass("is-valid");
                            }

                            if($("#marca").val() != "")
                            {
                                $("#marca_chosen").addClass("is-valid");
                            }

                            $("#operativo_chosen").addClass("is-valid");
                            $("#cedula_chosen").addClass("is-valid");
                            
                            if($("#estado").val() != "")
                            {
                                $("#estado_chosen").addClass("is-valid");
                            }

                            $("#area_chosen").addClass("is-valid");
                            $("#funcionario_chosen").addClass("is-valid");
                        }

                    }, false);
                });
            }, false);
        })(); 
    </script>
@endsection