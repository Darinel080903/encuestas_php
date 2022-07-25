@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar compra</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" action="{{url('/compras/'.$solicitudes->idsolicitud)}}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date('d/m/Y', strtotime($solicitudes->fecha))}}" readonly/>
                                </div>                            
                                <div class="form-group col-md-2">
                                    <label for="folio">Folio:</label>
                                    <input type="text" class="form-control" id="folio" name="folio" value="{{ $solicitudes->folio }}" maxlength="11" placeholder="folio" readonly>                                
                                </div> 

                            </div>

                            <div class="form-row">                               

                                <div class="form-group col-md-3">
                                    <label for="partida">Partidas:</label>
                                    <select class="form-control" id="partida" name="partida" required>
                                        <option value="">partida</option>
                                        @foreach ($partidas as $item)
                                            @if ($solicitudes->fkpartida == $item->idpartida)
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
                                            @if ($solicitudes->fkarea == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('solicitudes.editaroption',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="areacargo">Area cargo:</label>
                                    <select class="form-control" id="areacargo" name="areacargo">
                                        <option value="">area</option>
                                        @foreach ($areas as $item)
                                            @if ($solicitudes->fkareacargo == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('solicitudes.editaroptionacargo',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="clave">Clave:</label>
                                    <input type="text" class="form-control @error('clave') is-invalid @enderror" id="clave" name="clave" value="{{$solicitudes->clave}}" maxlength="25" placeholder="clave" required readonly>
                                    <div class="invalid-feedback">
                                        ¡La <strong>clave</strong> es un campo requerido!
                                    </div>
                                </div>
                            
                            </div>
                                                
                            <div class="form-row">

                                <div class="form-group col-md-8">
                                    <label for="proveedor">Proveedor:</label>
                                    <select class="form-control" id="proveedor" name="proveedor">
                                        <option value="">proveedor</option>
                                        @foreach ($proveedores as $item)
                                            @if ($solicitudes->fkproveedor == $item->idproveedor)
                                                <option value="{{$item->idproveedor}}" selected>{{$item->proveedor}}</option>
                                            @else
                                                <option value="{{$item->idproveedor}}">{{$item->proveedor}}</option>
                                            @endif
                                        @endforeach  
                                    </select>                                
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="factura">Facturas:</label>
                                    <input type="text" class="form-control" id="factura" name="factura" value="{{$solicitudes->factura}}" maxlength="11" placeholder="factura">                                
                                </div>
                            
                                <div class="form-group col-md-2">
                                    <label for="fechafactura">Fecha factura:</label>
                                    <input type="text" class="form-control @error('fechafactura') is-invalid @enderror" id="fechafactura" name="fechafactura" aria-label="fechafactura" placeholder="fechafactura" value="{{ date('d/m/Y', strtotime($solicitudes->fechafactura)) }}" readonly/>
                                </div>                     

                            </div> 
                            
                            <div class="card mb-2">
                                <div class="card-header">
                                    Desglose
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                    
                                        <div class="form-group col-md-1">
                                            <label for="desglosecantidad">Cantidad:</label>
                                            <input type="text" class="form-control" id="desglosecantidad" name="cantidad" maxlength="11" placeholder="cantidad" >                                            
                                        </div>                                   
                                        <div class="form-group col-md-2">
                                            <label for="desgloseunidad">Unidad:</label>
                                            <select class="form-control" id="desgloseunidad" name="desgloseunidad">
                                                <option value="">unidad</option>
                                                @foreach ($unidades as $item)
                                                    @if (old('desgloseunidad') == $item->idunidad)
                                                        <option value="{{$item->idunidad}}" selected>{{$item->unidad}}</option>
                                                    @else
                                                        <option value="{{$item->idunidad}}">{{$item->unidad}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>                                            
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="desglosedescripcion">Texto:</label>
                                            <input type="text" class="form-control" id="desglosedescripcion" name="desglosedescripcion" maxlength="25" placeholder="texto">                                           
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desgloseunitario">Costo:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="desgloseunitario" name="desgloseunitario" placeholder="costo" maxlength="11"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desglosemonto">Total:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="desglosemonto" name="desglosemonto" placeholder="total" maxlength="11"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="boton">&nbsp; Agregar</label>
                                            <a class="btn btn-outline-danger btn-block" href="javascript:DesgloseGuardar();"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="DesgloseTabla">
                                            <thead>
                                                <tr>
                                                    <th class="col-1">Cantidad</th>
                                                    <th class="col-2">Unidad</th>
                                                    <th class="col-4">Texto</th>
                                                    <th class="col-2">Costo</th>
                                                    <th class="col-2">Total</th>
                                                    <th class="col-1">Eliminar</th>
                                                </tr>
                                            </thead>                                        
                                        </table>                                       
                                    </div>                                   
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="subtotal">Subtotal:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="subtotal" name="subtotal"  value="{!! number_format((float)($solicitudes->subtotal), 2) !!}" placeholder="subtotal" maxlength="11"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="iva">Iva:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">%</span>
                                        </div>
                                        <input type="text" class="form-control" id="iva" name="iva"  value="{!! number_format((float)($solicitudes->iva), 2) !!}" placeholder="iva" maxlength="11"/>
                                    </div>
                                </div>                                
                                <div class="form-group col-md-3">
                                    <label for="total">Total:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="total" name="total"  value="{!! number_format((float)($solicitudes->total), 2) !!}" placeholder="Total" maxlength="11" readonly/>
                                    </div>
                                </div>

                            </div> 
                            
                            {{-- <div class="form-row">
                                
                                <div class="form-group col-md-12">
                                    <label for="concepto">Concepto de ajuste:</label>    
                                    <textarea class="form-control" name="concepto" id="concepto" cols="30" rows="2" placeholder="concepto de ajuste">{{$solicitudes->concepto}}</textarea>
                                </div>
                            </div> --}}

                            <div class="form-row">                               
                            
                                <div class="form-group col-md-4">
                                    <label for="elabora">Elabora:</label>
                                    <select class="form-control form-control-chosen" id="elabora" name="elabora">
                                        <option value="">Elabora</option>
                                        @foreach ($funcionarios as $itemfuncionario)
                                            @if ($solicitudes->fkelabora == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>   
                                <div class="form-group col-md-4">
                                    <label for="solicita">Solícita:</label>
                                    <select class="form-control form-control-chosen" id="solicita" name="solicita">
                                        <option value="">Solícita</option>
                                        @foreach ($funcionarios as $itemfuncionario)
                                            @if ($solicitudes->fksolicita == $itemfuncionario->idfuncionario)
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
                                        @foreach ($funcionarios as $itemfuncionario)
                                            @if ($solicitudes->fkautoriza == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>  
                                <div class="form-group col-md-12">
                                    <label for="observacion">Observación:</label>    
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="2" placeholder="observacion">{{$solicitudes->observacion}}</textarea>
                                </div>                                 

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" checked>
                                </div>
                            </div>

                            <div class="p-3 border">
                                <div class="form-group">
                                    <h3>Formatos</h3>                             
                                </div>

                                <div class="form-row" id="formatos"></div>                                 
                                <a  class="btn btn-outline-danger" href="{{url('/formatos/ordencompra/'.$solicitudes->idsolicitud)}}" target="_blank"><i class="fas fa-save"></i> Orden de compra menor</a>  
                                <a  class="btn btn-outline-danger" href="{{url('/formatos/solicitudcompra/'.$solicitudes->idsolicitud)}}" target="_blank"><i class="fas fa-save"></i> Solicitud de compra</a>  
                                <a  class="btn btn-outline-danger" href="{{url('/formatos/solicitud/'.$solicitudes->idsolicitud)}}" target="_blank"><i class="fas fa-save"></i> Solicitud de pago</a>  
                                {{-- <a  class="btn btn-outline-danger" href="{{url('/formatos/constanciaretenciones/'.$solicitudes->idsolicitud)}}" target="_blank"><i class="fas fa-save"></i> Constancia de retenciones</a>   --}}
                            </div>
                            <br>

                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle" value="{{$folios ?? ''}}"> 
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/solicitudes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var Detalle = [];

        var data = $("#vdetalle").val(); //se agrego JSON para que mostrara la informacion de la tabla.
        $.each(JSON.parse(data), function(i, item){           
            Detalle.push({numero:item.cantidad, unidad:item.fkunidad, unidadtexto:item.unidad, concepto:item.descripcion, unitario:parseFloat(item.unitario).toFixed(2), monto:parseFloat(item.total).toFixed(2)});    
        });
        $("#vdetalle").val("");
        $("#vdetalle").val(JSON.stringify(Detalle));
        MostrarDesgloseTabla();

        $(document).ready(function(){  //se agregan varios datepicker ya que son diferentes inputs
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
            bsCustomFileInput.init();
        });
        
        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });
        
        $(function(){  // funcion para validad un campo, que solo sea numerico
            $("#desglosecantidad").validCampoFranz("0123456789");	
    		$("#desgloseunitario").validCampoFranz(".0123456789");	
            $("#desglosemonto").validCampoFranz(".0123456789");
            $("#disponible").validCampoFranz(".0123456789");		
            $("#subtotal").validCampoFranz("0123456789");	
            $("#iva").validCampoFranz(".0123456789");	
            $("#ajuste").validCampoFranz(".0123456789");	
            $("#total").validCampoFranz(".0123456789");	
    	});

        $("#desglosemonto").click(function(){ //sumatoria de numero,unidad y total
            var num = $("#desglosecantidad").val();
            var uni = $("#desgloseunitario").val();
            var total = 0;
            if(num && uni)
            {
                total = num * parseFloat(uni).toFixed(2);
                $("#desglosemonto").val(parseFloat(total).toFixed(2));
            }
            else
            {
                $("#desglosemonto").val('');
            }
        });
                     
        $("#desglosecantidad").keyup(function(){
            if($("#desglosecantidad").val() != "" && $("#desglosecantidad").hasClass("is-invalid") === true)
            {
                $("#desglosecantidad").removeClass("is-invalid");
                $("#desglosecantidad").addClass("is-valid");    
            }
        }); 

        $("#desgloseunidad").click(function(){
            if($("#desgloseunidad").val() != "" && $("#desgloseunidad").hasClass("is-invalid") === true)
            {
                $("#desgloseunidad").removeClass("is-invalid");
                $("#desgloseunidad").addClass("is-valid");    
            }
        });

        $("#desglosedescripcion").keyup(function(){
            if($("#desglosedescripcion").val() != "" && $("#desglosedescripcion").hasClass("is-invalid") === true)
            {
                $("#desglosedescripcion").removeClass("is-invalid");
                $("#desglosedescripcion").addClass("is-valid");    
            }
        });

        $("#desgloseunitario").keyup(function(){
            if($("#desgloseunitario").val() != "" && $("#desgloseunitario").hasClass("is-invalid") === true)
            {
                $("#desgloseunitario").removeClass("is-invalid");
                $("#desgloseunitario").addClass("is-valid");    
            }
        });

        $("#desglosemonto").keyup(function(){
            if($("#desglosemonto").val() != "" && $("#desglosemonto").hasClass("is-invalid") === true)
            {
                $("#desglosemonto").removeClass("is-invalid");
                $("#desglosemonto").addClass("is-valid");    
            }
        });
        $("#desglosemonto").click(function(){
            if($("#desglosemonto").val() != "" && $("#desglosemonto").hasClass("is-invalid") === true)
            {
                $("#desglosemonto").removeClass("is-invalid");
                $("#desglosemonto").addClass("is-valid");    
            }
        });
        
        function DesgloseGuardar() //creacion de variables 
        {
            var valida = true;
            var vnumero = $("#desglosecantidad").val(); 
            var vunidad = $("#desgloseunidad").val();           
            var vunidadtexto = $("#desgloseunidad option:selected").text();           
            var vconcepto = $("#desglosedescripcion").val();
            var vunitario = $("#desgloseunitario").val();
            var vmonto = $("#desglosemonto").val();
            
            if(vnumero == "")
            {
                $("#desglosecantidad").addClass("is-invalid");
                valida = false;
            }
            if(vunidad == "")
            {
                $("#desgloseunidad").addClass("is-invalid");
                valida = false;
            }
            if(vconcepto == "")
            {
                $("#desglosedescripcion").addClass("is-invalid");
                valida = false;
            }
            if(vunitario == "")
            {
                $("#desgloseunitario").addClass("is-invalid");
                valida = false;
            }
            if(vmonto == "")
            {
                $("#desglosemonto").addClass("is-invalid");
                valida = false;
            }
            
            if(valida == true)
            {
                Detalle.push({numero:vnumero, unidad:vunidad, unidadtexto:vunidadtexto, concepto:vconcepto, unitario:parseFloat(vunitario).toFixed(2), monto:parseFloat(vmonto).toFixed(2)});    
                $("#vdetalle").val("");
                $("#vdetalle").val(JSON.stringify(Detalle));
                MostrarMontoTotal();
                MostrarDesgloseTabla();

                $("#desglosecantidad").val("");
                $("#desgloseunidad").val("");
                $("#desglosedescripcion").val("");
                $("#desgloseunitario").val("");
                $("#desglosemonto").val("");

                if($("#desglosecantidad").hasClass("is-valid") === true)
                {
                    $("#desglosecantidad").removeClass("is-valid");
                }
                if($("#desgloseunidad").hasClass("is-valid") === true)
                {
                    $("#desgloseunidad").removeClass("is-valid");
                }
                if($("#desglosedescripcion").hasClass("is-valid") === true)
                {
                    $("#desglosedescripcion").removeClass("is-valid");
                }
                if($("#desgloseunitario").hasClass("is-valid") === true)
                {
                    $("#desgloseunitario").removeClass("is-valid");
                }
                if($("#desglosemonto").hasClass("is-valid") === true)
                {
                    $("#desglosemonto").removeClass("is-valid");
                }
            }
        }

        function DesgloseEliminar(i)
        {
            Detalle.splice(i, 1);
            $("#vdetalle").val("");
            $("#vdetalle").val(JSON.stringify(Detalle));
            MostrarMontoTotal();
            MostrarDesgloseTabla();     
        }

        function MostrarMontoTotal()
        {   
            //var tipo = $("#clase").val();
            //if(tipo == 1)
            //{
                var total = 0;
                $.each(Detalle, function(key, value)
                {
                    total = parseFloat(total) + parseFloat(Detalle[key].monto);
                });
                $("#subtotal").val(formatCurrencyclean(total.toFixed(2)));

            //}                    
           
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

        $("#disponible").blur(function() {
            var disponible = $('#disponible').val();
            if( disponible != "")
            {
                disponible = parseFloat(disponible.replace(",", "")).toFixed(2);
                $("#disponible").val(formatCurrencyclean(disponible));
            }
            
        });

        function MostrarDesgloseTabla()
        {         
            $("#DesgloseTabla").empty();
            $("#DesgloseTabla").append("<thead><tr><th class='col-1'>Cantidad</th><th class='col-2'>Unidad</th><th class='col-4'>Descripción</th><th class='col-2'>Precio</th><th class='col-2'>Total</th><th class='col-1'>Eliminar</th></tr></thead>"); 
            $("#DesgloseTabla").append("<tbody>");
            $.each(Detalle, function(key, value)
            {
                $("#DesgloseTabla").append("<tr><td class='align-middle'>"+Detalle[key].numero+"</td><td class='align-middle'>"+Detalle[key].unidadtexto+"</td><td class='align-middle'>"+Detalle[key].concepto+"</td><td class='align-middle'>"+formatCurrency(Detalle[key].unitario)+"</td><td class='align-middle'>"+formatCurrency(Detalle[key].monto)+"</td><td><a class='btn btn-outline-danger btn-block' href='javascript:DesgloseEliminar("+key+");'><i class='fas fa-minus'></i></a></td></tr>");
            });
            $("#DesgloseTabla").append("</tbody>");
        }

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