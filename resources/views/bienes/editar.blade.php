@extends('layouts.app')

@section('content')

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="needs-validation" id="formmodal" action="javascript:tmpguardarbien();" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="origenmodal">Origen:</label>
                                <select class="form-control form-control-chosen" id="origenmodal" name="origenmodal">
                                    <option value="0">Nuevo</option>
                                    <option value="1">Inventario</option>
                                </select> 
                            </div>

                            <div class="form-group col-md-8">
                                <label for="bienmodal">Bienes:</label>
                                <select class="form-control form-control-chosen" id="bienmodal" name="bienmodal" disabled>
                                    <option value="">Bien</option>
                                    @foreach ($bienesmodal as $item)
                                        @if (old('bienmodal') == $item->idbien)
                                            <option value="{{$item->idbien}}" selected>{{$item->articulo.' - '.$item->patrimonio}}</option>
                                        @else
                                            <option value="{{$item->idbien}}">{{$item->articulo.' - '.$item->patrimonio}}</option>
                                        @endif
                                    @endforeach
                                </select> 
                            </div>
                        </div>

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

                        <input type="hidden" id="vorigen" name="vorigen">

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

                            <div class="form-row @if($raiz != 1) {{'d-none'}} @endif" id="divbienes">
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-outline-danger btn-block" id="botonaddarticulos" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fas fa-link"></i> <i class="fas fa-keyboard"></i> <i class="fas fa-mouse"></i> Asociar artículos
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="listaarticulos">    
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="col" width="10%">Artículo</th>    
                                                <th class="text-center" scope="col">Marca</th>
                                                <th class="text-center" scope="col">Modelo</th>
                                                <th class="text-center" scope="col">Serie</th>
                                                <th class="text-center" scope="col">Patrimonio</th>
                                                <th class="text-center" scope="col">Estado</th>
                                                <th class="text-center" scope="col">Observacion</th>
                                                <th class="text-center" scope="col" width='13%'>Desasociar</th>
                                            </tr>
                                        </thead>
                                
                                        @foreach ($tmpbienes as $item)                                        
                                            <tr>                                            
                                                <td scope="col" width="10%">{{$item->articulo}}</td>
                                                <td scope="col">{{$item->marca}}</td>
                                                <td scope="col">{{$item->modelo}}</td>
                                                <td scope="col">{{$item->serie}}</td>
                                                <td scope="col">{{$item->patrimonio}}</td>
                                                <td scope="col">{{$item->estado}}</td>
                                                <td scope="col">{{$item->observacion}}</td>
                                                <td scope="col" width='13%'><a class="btn btn-outline-danger" href="javascript:eliminartmpbien({{$item->idtmpbien}});"><i class='fas fa-unlink'></i> Desasociar</a></td>                                           
                                            </tr>
                                        @endforeach
                                    </table>
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

                                <div class="form-group col-md-6">
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
            $(".form-control-chosen").chosen({disable_search_threshold:5});
        });

        $("#botonaddarticulos").on("click", function(){
            limpiar(); 
        });

        $("#articulo").chosen().change(function(){
            campos($("#articulo").chosen().val());            
        });

        function campos(identificador)
        {
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
        }

        $("#botonaddarticulos").on("click", function(){
            limpiar(); 
        });

        function limpiar()
        {
            $("#formmodal").removeClass("was-validated");

            $("#origenmodal option:selected").prop("selected", false);
            $("#origenmodal").trigger("chosen:updated");
            $("#origenmodal_chosen").removeClass("is-valid");
            $("#origenmodal_chosen").removeClass("is-invalid");

            $("#bienmodal option:selected").prop("selected", false);
            $("#bienmodal").trigger("chosen:updated");
            $("#bienmodal_chosen").removeClass("is-valid");
            $("#bienmodal_chosen").removeClass("is-invalid");
            $("#bienmodal").prop("disabled", true).trigger("chosen:updated");

            $("#articulomodal option:selected").prop("selected", false);
            $("#articulomodal").trigger("chosen:updated");
            $("#articulomodal_chosen").removeClass("is-valid");
            $("#articulomodal_chosen").removeClass("is-invalid");

            $("#marcamodal option:selected").prop("selected", false);
            $("#marcamodal").trigger("chosen:updated");
            $("#marcamodal_chosen").removeClass("is-valid");
            $("#marcamodal_chosen").removeClass("is-invalid");
            
            $("#modelomodal").val("");
            $("#seriemodal").val("");
            $("#patrimoniomodal").val("");
            
            $("#estadomodal option:selected").prop("selected", false);
            $("#estadomodal").trigger("chosen:updated");
            $("#estadomodal_chosen").removeClass("is-valid");
            $("#estadomodal_chosen").removeClass("is-invalid");
            
            $("#observacionmodal").val("");
            $("#vorigen").val("n");
        }

        $("#origenmodal").chosen().change(function(){
            var origen = $("#origenmodal").chosen().val();
            if(origen == 0)
            {
                $("#bienmodal").prop("disabled", true).trigger("chosen:updated");
                limpiar();
            }
            else if(origen == 1)
            {
                $("#bienmodal").prop("disabled", false).trigger("chosen:updated");
            }
        });
        
        $("#bienmodal").chosen().change(function(){
            $("#divmodalloading").addClass("d-flex").removeClass("d-none");
            var identificador = $("#bienmodal").chosen().val();
            if(identificador)
            {
                // Ini Ajax
                var url = "{{url('/bienes/inventario/idbien')}}";
                url = url.replace("idbien", identificador);
                $.ajax({type:"get",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    dataType: "json",
                    success: function(response, textStatus, xhr)
                    {
                        $("#articulomodal").val(response.fkarticulo);
                        $("#articulomodal").trigger("chosen:updated");
                        $("#marcamodal").val(response.fkmarca);
                        $("#marcamodal").trigger("chosen:updated");
                        $("#modelomodal").val(response.modelo);
                        $("#seriemodal").val(response.serie);
                        $("#patrimoniomodal").val(response.patrimonio);
                        $("#estadomodal").val(response.fkestado);
                        $("#estadomodal").trigger("chosen:updated");
                        $("#observacionmodal").val(response.observacion);
                        $("#vorigen").val("i");
                        $("#divmodalloading").addClass("d-none").removeClass("d-flex");
                    },
                    error: function(xhr, textStatus, errorThrown)
                    {
                        alert("¡Error al cargar el bien!");
                    }
                });
                // Fin Ajax
            }
            else
            {
                limpiar();
                $("#divmodalloading").addClass("d-none").removeClass("d-flex");
            } 
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
            var vorigen = $("#vorigen").val();

            var url = "{{url('savetmp')}}";    //sirve para colocar el nombre de la pagina completa 
                 
            $.ajax({                  
                type: "get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                url: url,
                dataType: "json",
                data: {articulomodal:articulo, marcamodal:marca, modelomodal:modelo, seriemodal:serie, patrimoniomodal:patrimonio, estadomodal:estado, observacionmodal:observacion, origen:vorigen},
                success: function(response, textStatus, xhr)
                {
                    if(response == "R")
                    {
                        alert("registro existente");
                    }
                    else
                    {
                        $("#listaarticulos").empty();
                        $('#listaarticulos').append("<tr><th class='text-center'>Articulo</th><th class='text-center'>Marca</th><th class='text-center'>Modelo</th><th class='text-center'>Serie</th><th class='text-center'>Patrimonio</th><th class='text-center'>Estado</th><th class='text-center'>Observación</th><th class='text-center' width='13%'>Desasociar</th></tr>");
                        for(let i = 0; i< response.length; i++) 
                        {
                            var showmodelo = "";
                            if(response[i].modelo)
                            {
                                var showmodelo = response[i].modelo;
                            }
                            var showobservacion = "";
                            if(response[i].observacion)
                            {
                                var showobservacion = response[i].observacion;
                            }
                            $('#listaarticulos').append("<tr><td>"+response[i].articulo+"</td><td>"+response[i].marca+"</td><td>"+showmodelo+"</td><td>"+response[i].serie+"</td><td>"+response[i].patrimonio+"</td><td>"+response[i].estado+"</td><td>"+showobservacion+"</td><td class='text-center' width='13%'><a class='btn btn-outline-danger' id='message-delete' href='javascript:eliminartmpbien("+response[i].idtmpbien+");'><i class='fas fa-unlink'></i> Desasociar</a></td></tr>");
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
                    $('#listaarticulos').append("<tr><th class='text-center'>Articulo</th><th class='text-center'>Marca</th><th class='text-center'>Modelo</th><th class='text-center'>Serie</th><th class='text-center'>Patrimonio</th><th class='text-center'>Estado</th><th class='text-center'>Observación</th><th class='text-center' width='13%'>Desasociar</th></tr>");
                    for(let i = 0; i< response.length; i++) 
                    {
                        var showmodelo = "";
                        if(response[i].modelo)
                        {
                            var showmodelo = response[i].modelo;
                        }
                        var showobservacion = "";
                        if(response[i].observacion)
                        {
                            var showobservacion = response[i].observacion;
                        }
                        $('#listaarticulos').append("<tr><td>"+response[i].articulo+"</td><td>"+response[i].marca+"</td><td>"+showmodelo+"</td><td>"+response[i].serie+"</td><td>"+response[i].patrimonio+"</td><td>"+response[i].estado+"</td><td>"+showobservacion+"</td><td class='text-center' width='13%'><a class='btn btn-outline-danger' id='message-delete' href='javascript:eliminartmpbien("+response[i].idtmpbien+");'><i class='fas fa-unlink'></i> Desasociar</a></td></tr>");
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