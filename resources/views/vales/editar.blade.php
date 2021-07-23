@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-file-invoice-dollar"></i> Editar factura</h4>
                    </div>
                    <div class="card-body">     
                        
                        <form class="needs-validation" method="POST" action="{{url('/facturas/'.$datos->idfactura)}}" novalidate>
                            @method('PUT')
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{date('d/m/Y', strtotime($datos->fecha))}}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="numero">No. factura:</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" placeholder="Número de factura" maxlength="50" value="{{$datos->numero}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>número</strong> es un campo requerido!
                                    </div>  
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="proveedor">Proveedor:</label>
                                    <input type="text" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" name="proveedor" placeholder="Proveedor" maxlength="250" value="{{$datos->proveedor}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>proveedor</strong> es un campo requerido!
                                    </div>  
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="monto">Fecha:</label>
                                    <input type="text" class="form-control" id="pago" name="pago" aria-label="Fecha de pago" placeholder="Fecha de pago" value="@if($datos->pago) {{date('d/m/Y', strtotime($datos->pago))}} @endif" readonly/>
                                </div>
                            </div>

                            <div class="card mb-2">
                                <div class="card-header">
                                    Desglose de la factura
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desglosenumero">Unidades:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">No.</span>
                                                </div>
                                                <input type="text" class="form-control" id="desglosenumero" name="desglosenumero" placeholder="Unidades" maxlength="11"/>
                                            </div>
                                        </div>
        
                                        <div class="form-group col-md-5 mb-0">
                                            <label for="desgloseconcepto">Concepto:</label>
                                            <input type="text" class="form-control" id="desgloseconcepto" name="desgloseconcepto" placeholder="Concepto" maxlength="250"/>
                                        </div>
        
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desgloseunitario">Precio:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="desgloseunitario" name="desgloseunitario" placeholder="Unitario" maxlength="11"/>
                                            </div>
                                        </div>
        
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desglosemonto">Total:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="desglosemonto" name="desglosemonto" placeholder="Total" maxlength="11"/>
                                            </div>
                                        </div>
        
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="boton">&nbsp; Agregar</label>
                                            <a class="btn btn-outline-danger btn-block" href="javascript:DesgloseGuardar();"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <table class="table table-bordered" id="DesgloseTabla">
                                        <thead>
                                            <tr>
                                                <th class="col-2">Unidades</th>
                                                <th class="col-5">Concepto</th>
                                                <th class="col-2">Precio</th>
                                                <th class="col-2">Total</th>
                                                <th class="col-1">Eliminar</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group offset-md-9 col-md-2 pl-0 mr-2">
                                    <label for="monto">Monto:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto" maxlength="15" value="{!! number_format((float)($datos->monto), 2) !!}" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($datos->activo == 1) {{'checked'}} @endif>
                                </div>
                                
                                <div class="form-group offset-md-7 col-md-2 pl-0 mr-2">
                                    <label for="saldo">Saldo:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="saldo" name="saldo" placeholder="Saldo" maxlength="15" value="{{$datos->saldo}}" readonly/>
                                    </div>
                                </div>
                            </div> 

                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle" value="{{$desgloses ?? ''}}">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/facturas?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>

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

        $('#pago').datepicker({
            uiLibrary: 'bootstrap4',
            locale: 'es-es',
            format: 'dd/mm/yyyy'
        });

        $(function(){
            $("#desglosenumero").validCampoFranz("0123456789");	
    		$("#desgloseunitario").validCampoFranz(".0123456789");	
            $("#desglosemonto").validCampoFranz(".0123456789");	
    	});

        $("#desglosemonto").click(function(){
            var num = $("#desglosenumero").val();
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

        $("#desglosenumero").keyup(function(){
            if($("#desglosenumero").val() != "" && $("#desglosenumero").hasClass("is-invalid") === true)
            {
                $("#desglosenumero").removeClass("is-invalid");
                $("#desglosenumero").addClass("is-valid");    
            }
        });
        $("#desgloseconcepto").keyup(function(){
            if($("#desgloseconcepto").val() != "" && $("#desgloseconcepto").hasClass("is-invalid") === true)
            {
                $("#desgloseconcepto").removeClass("is-invalid");
                $("#desgloseconcepto").addClass("is-valid");    
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

        var Detalle = [];

        var data = $("#vdetalle").val();
        $.each(JSON.parse(data), function(i, item){
            Detalle.push({numero:item.numero, concepto:item.concepto, unitario:parseFloat(item.unitario).toFixed(2), monto:parseFloat(item.monto).toFixed(2)});    
        });
        MostrarDesgloseTabla();
        
        function DesgloseGuardar()
        {
            var valida = true;
            var vnumero = $("#desglosenumero").val();
            var vconcepto = $("#desgloseconcepto").val();
            var vunitario = $("#desgloseunitario").val();
            var vmonto = $("#desglosemonto").val();
            
            if(vnumero == "")
            {
                $("#desglosenumero").addClass("is-invalid");
                valida = false;
            }
            if(vconcepto == "")
            {
                $("#desgloseconcepto").addClass("is-invalid");
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
                Detalle.push({numero:vnumero, concepto:vconcepto, unitario:parseFloat(vunitario).toFixed(2), monto:parseFloat(vmonto).toFixed(2)});    
                $("#vdetalle").val("");
                $("#vdetalle").val(JSON.stringify(Detalle));
                MostrarMontoTotal();
                MostrarDesgloseTabla();

                $("#desglosenumero").val("");
                $("#desgloseconcepto").val("");
                $("#desgloseunitario").val("");
                $("#desglosemonto").val("");

                if($("#desglosenumero").hasClass("is-valid") === true)
                {
                    $("#desglosenumero").removeClass("is-valid");
                }
                if($("#desgloseconcepto").hasClass("is-valid") === true)
                {
                    $("#desgloseconcepto").removeClass("is-valid");
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
            var total = 0;
            $.each(Detalle, function(key, value)
            {
                total = parseFloat(total) + parseFloat(Detalle[key].monto);
            });
            $("#monto").val(formatCurrencyclean(total.toFixed(2)));
        }  

        function MostrarDesgloseTabla()
        {         
            $("#DesgloseTabla").empty();
            $("#DesgloseTabla").append("<thead><tr><th class='col-2'>Unidades</th><th class='col-5'>Concepto</th><th class='col-2'>Precio</th><th class='col-2'>Total</th><th class='col-1'>Eliminar</th></tr></thead>"); 
            $("#DesgloseTabla").append("<tbody>");
            $.each(Detalle, function(key, value)
            {
                $("#DesgloseTabla").append("<tr><td class='align-middle'>"+Detalle[key].numero+"</td><td class='align-middle'>"+Detalle[key].concepto+"</td><td class='align-middle'>"+formatCurrency(Detalle[key].unitario)+"</td><td class='align-middle'>"+formatCurrency(Detalle[key].monto)+"</td><td><a class='btn btn-outline-danger btn-block' href='javascript:DesgloseEliminar("+key+");'><i class='fas fa-minus'></i></a></td></tr>");
            });
            $("#DesgloseTabla").append("</tbody>");
        }

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