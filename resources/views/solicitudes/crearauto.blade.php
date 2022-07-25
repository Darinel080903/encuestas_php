@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nuevo auto</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{url('/servicioautos')}}" novalidate>
                        @csrf
                            
                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="folio">Folio:</label>
                                    <input type="text" class="form-control" id="folio" name="folio" value="{{$folio}}" maxlength="11" placeholder="folio" readonly>                                   
                                </div>  
                            </div>

                            <div class="form-row">                               

                                <div class="form-group col-md-3">
                                    <label for="partida">Partidas:</label>
                                    <select class="form-control @error('partida') is-invalid @enderror" id="partida" name="partida" required>
                                        <option value="">partida</option>
                                        @foreach ($partidas as $item)
                                            @if (old('partida') == $item->idpartida)
                                                <option value="{{$item->idpartida}}" selected>{{$item->clave.' '.$item->partida}}</option>
                                            @else
                                                <option value="{{$item->idpartida}}">{{$item->clave.' '.$item->partida}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>partida</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="area">Area solicitante:</label>
                                    <select class="form-control" id="area" name="area">
                                        <option value="">area</option>
                                        @foreach ($areas as $item)
                                            @if (old('area') == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('solicitudes.crearoption',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="areacargo">Area cargo:</label>
                                    <select class="form-control" id="areacargo" name="areacargo">
                                        <option value="">area</option>
                                        @foreach ($areas as $item)
                                            @if (old('areacargo') == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('solicitudes.crearoptionacargo',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="clave">Clave:</label>
                                    <input type="text" class="form-control @error('clave') is-invalid @enderror" id="clave" name="clave" value="{{old('clave')}}" maxlength="25" placeholder="clave" required readonly>
                                    <div class="invalid-feedback">
                                        ¡La <strong>clave</strong> es un campo requerido!
                                    </div>
                                </div>                               
                            </div>

                            <div class="form-row d-none">                               
                                                                
                                <div class="form-group col-md-3 mb-0">
                                    <label for="disponible">Disponible:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="disponible" name="disponible" value="{{old('disponible')}}" placeholder="disponible" maxlength="25"/>                                       
                                    </div>                                    
                                </div>
                                                                                               
                                <div class="form-group col-md-6">
                                    <label for="otorga">Otorga:</label>
                                    <select class="form-control form-control-chosen" id="otorga" name="otorga">
                                        <option value="">funcionario</option>
                                        @foreach ($otorga as $itemfuncionario)
                                            @if (old('otorga') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>   
                            </div>
                            
                            <div class="form-row">

                                <div class="form-group col-md-8">
                                    <label for="proveedor">Proveedor:</label>
                                    <select class="form-control" id="proveedor" name="proveedor">
                                        <option value="">proveedor</option>
                                        @foreach ($proveedores as $item)
                                            @if (old('proveedor') == $item->idproveedor)
                                                <option value="{{$item->idproveedor}}" selected>{{$item->proveedor}}</option>
                                            @else
                                                <option value="{{$item->idproveedor}}">{{$item->proveedor}}</option>
                                            @endif
                                        @endforeach  
                                    </select>                                   
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="factura">Facturas:</label>
                                    <input type="text" class="form-control" id="factura" name="factura" value="{{old('factura')}}" maxlength="11" placeholder="factura">                                    
                                </div>
                             
                                <div class="form-group col-md-2">
                                    <label for="fechafactura">Fecha factura:</label>
                                    <input type="text" class="form-control" id="fechafactura" name="fechafactura" aria-label="fechafactura" placeholder="fechafactura" value="{{ old('fechafactura') }}" readonly/>
                                </div>                     
                            </div> 
                           
                            <div class="card border-success mb-2" id="vehiculo">
                                <div class="card-header">
                                    Vehiculos
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                                                               
                                        <div class="form-group col-md-12">
                                            <label for="descripcion">Descripción:</label>
                                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{old('descripcion')}}" maxlength="250" placeholder="descripcion">                                            
                                        </div>                                                                                                                  
                                        <div class="form-group col-md-3">
                                            <label for="auto">Vehiculo:</label>
                                            <select class="form-control" id="auto" name="auto">
                                                <option value="">numero</option>
                                                @foreach ($autos as $item)
                                                    @if (old('numero') == $item->idauto)
                                                        <option value="{{$item->idauto}}" selected>{{$item->numero}}</option>
                                                    @else
                                                        <option value="{{$item->idauto}}">{{$item->numero}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>                                            
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="placas">Placas:</label>
                                            <input type="text" class="form-control" id="placas" name="placas" value="{{old('placas')}}" maxlength="11" placeholder="placas">                                            
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="modelovehiculo">Modelo:</label>
                                            <input type="text" class="form-control" id="modelovehiculo" name="modelovehiculo" value="{{old('modelovehiculo')}}" maxlength="11" placeholder="modelo">                                            
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="tipo">Tipo:</label>
                                            <input type="text" class="form-control" id="tipo" name="tipo" value="{{old('tipo')}}" maxlength="11" placeholder="tipo">                                            
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="servicio">Servicio:</label>    
                                            <textarea class="form-control" name="servicio" id="servicio" cols="30" rows="2" placeholder="servicio">{{old('servicio')}}</textarea>
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label for="fechaservicio">Fecha servicio:</label>
                                            <input type="text" class="form-control" id="fechaservicio" name="fechaservicio" aria-label="fechaservicio" placeholder="fechaservicio" value="{{ old('fechaservicio') }}" readonly/>
                                        </div>                                       
                                    </div>
                                </div>                     
                            </div>

                            <div class="form-row" id="contenido">
                               
                                <div class="form-group col-md-3">
                                    <label for="subtotal">Subtotal:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="subtotal"  name="subtotal"  placeholder="subtotal" maxlength="11"/>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label for="iva">Iva:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">%</span>
                                        </div>
                                        <input type="text" class="form-control" id="iva" name="iva" placeholder="iva" maxlength="11" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ajuste">Ajuste:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="ajuste" name="ajuste" placeholder="ajuste" maxlength="11" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total">Total:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="total" name="total" placeholder="total" maxlength="11" readonly/>
                                    </div>
                                </div>

                            </div> 
                            
                            <div class="form-row">
                                
                                <div class="form-group col-md-12">
                                    <label for="concepto">Concepto de ajuste:</label>    
                                    <textarea class="form-control" name="concepto" id="concepto" cols="30" rows="2" placeholder="concepto de ajuste">{{old('concepto')}}</textarea>
                                </div>
                            </div>

                            <div class="form-row">                               
                              
                                <div class="form-group col-md-4">
                                    <label for="solicita">Solícita:</label>
                                    <select class="form-control form-control-chosen" id="solicita" name="solicita">
                                        <option value="">Solícita</option>
                                        @foreach ($solicita as $itemfuncionario)
                                            @if (old('solicita') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>   
                                <div class="form-group col-md-4">
                                    <label for="autoriza">Autoriza:</label>
                                    <select class="form-control form-control-chosen" id="autoriza" name="autoriza">
                                        <option value="">Autoriza</option>
                                        @foreach ($autoriza as $itemfuncionario)
                                            @if (old('autoriza') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>  
                                <div class="form-group col-md-12">
                                    <label for="observacion">Observación:</label>    
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="2" placeholder="observacion">{{old('observacion')}}</textarea>
                                </div>                                 

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" checked>
                                </div>
                            </div>

                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle">
                            
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/solicitudes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                            
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
            $('#fecha').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });
            $('#fechafactura').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });                
            $('#fechaservicio').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });          
            bsCustomFileInput.init();
        });

        $(document).ready(function(){
            $(".form-control-chosen").chosen();            
        });
        
        $(function(){                        
            $("#subtotal").validCampoFranz("0123456789");	
            $("#iva").validCampoFranz(".0123456789");	
            $("#ajuste").validCampoFranz(".0123456789");	
            $("#total").validCampoFranz(".0123456789");	
    	});

        function MostrarMontoTotal()
        {               
            var mon = $("#subtotal").val();
            var iva = $("#iva").val();
            var aju = $("#ajuste").val(); 
        
            if(mon == "")
            {   
                mon = 0;
            }
            else
            {
                mon = parseFloat(mon.replace(",", ""));
            }
            if(iva == "")
            {   
                iva = 0;
            }
            else
            {
                iva = parseFloat(iva.replace(",", ""));
            }
            if(aju == "")
            {   
                aju = 0;
            }
            else
            {
                aju = parseFloat(aju.replace(",", ""));
            }
            
            console.log("mon " + mon)
            console.log("iva " + iva)
            console.log("aju " + aju)
                        
            $("#total").val(formatCurrencyclean((mon+iva+aju).toFixed(2)));            
        }  

        $("#subtotal").keyup(function(){
            MostrarMontoTotal();
        });
        $("#subtotal").blur(function() {
            var subtotal = $('#subtotal').val();
            if(subtotal != "")
            {
                subtotal = parseFloat(subtotal.replace(",", "")).toFixed(2);
                $("#subtotal").val(formatCurrencyclean(subtotal));
            } 
        });

        $("#iva").keyup(function(){
            MostrarMontoTotal();
        });
        $("#iva").blur(function() {
            var iva = $('#iva').val();
            if(iva != "")
            {
                iva = parseFloat(iva.replace(",", "")).toFixed(2);
                $("#iva").val(formatCurrencyclean(iva));
            }   
        });

        $("#ajuste").keyup(function(){
            MostrarMontoTotal();
        });
        $("#ajuste").blur(function() {
            var ajuste = $('#ajuste').val();
            if( ajuste != "")
            {
                ajuste = parseFloat(ajuste.replace(",", "")).toFixed(2);   //reemplaza la coma por vacio.
                $("#ajuste").val(formatCurrencyclean(ajuste));
            }
        });
        
        $(function(){
            $("#areacargo").change(function(){  //se escribe el input que utilizaremos (areacargo)
                $("#divloading").addClass("d-flex").removeClass("d-none"); // funcion para el icono de cargar 
                var identificador = $("#areacargo").val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/solicitudes/clave/idarea')}}";
                    url = url.replace("idarea", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            //console.log(response);
                            $("#clave").empty();
                            $("#clave").val(response.clave);                            
                            $("#divloading").addClass("d-none").removeClass("d-flex");                            
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar la clave!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#clave").val("");                    
                    $("#divloading").addClass("d-none").removeClass("d-flex");                    
                } 
            });
        });

        $(function(){
            $("#auto").change(function(){  //se escribe el input que utilizaremos (auto)
                $("#divloading").addClass("d-flex").removeClass("d-none"); // funcion para el icono de cargar 
                var identificador = $("#auto").val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/solicitudes/auto/idauto')}}";
                    url = url.replace("idauto", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            // console.log(response);
                            // console.log(response.modelo);
                            // console.log(response.placa);
                            // console.log(response.tipo);
                            $("#placas").empty();
                            $("#placas").val(response.placa);                             
                            $("#modelovehiculo").val(response.modelo);                                                         
                            $("#tipo").val(response.tipo);
                            $("#divloading").addClass("d-none").removeClass("d-flex");                            
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el vehiculo!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#placa").val("");                    
                    $("#modelovehiculo").val("");                    
                    $("#tipo").val("");                    
                    $("#divloading").addClass("d-none").removeClass("d-flex");                    
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
                }
                form.classList.add('was-validated');                
              }, false);
            });
          }, false);
        })();
    </script>
@endsection
