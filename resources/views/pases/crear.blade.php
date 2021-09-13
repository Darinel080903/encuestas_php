@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nueva factura</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{url('/facturas')}}" novalidate>
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{date("d/m/Y")}}" readonly/>
                                    <div class="invalid-feedback">
                                        ¡La <strong>fecha</strong> es un campo requerido!
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="hora">Hora:</label>
                                    <input type="text" class="form-control @error('hora') is-invalid @enderror" id="hora" name="hora" aria-label="Hora" placeholder="Hora" value="{{date("d/m/Y")}}" required/>
                                    <div class="invalid-feedback">
                                        ¡La <strong>hora</strong> es un campo requerido!
                                    </div>  
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="solicita">Solicitante:</label>
                                    <input type="text" class="form-control @error('solicita') is-invalid @enderror" id="solicita" name="solicita" aria-label="Solicitante" placeholder="Solicitante" maxlength="250" value="{{old('solicita')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>solicitante</strong> es un campo requerido!
                                    </div>  
                                </div>
                            </div>

                            <div class="card mb-2">
                                <div class="card-header">
                                    Detalle
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="detalleequipo">Equipo:</label>
                                            <input type="text" class="form-control" id="detalleequipo" name="detalleequipo" placeholder="Equipo" maxlength="250"/>
                                        </div>

                                        <div class="form-group col-md-5 mb-0">
                                            <label for="detallemarca">Marca:</label>
                                            <input type="text" class="form-control" id="detallemarca" name="detallemarca" placeholder="Marca" maxlength="250"/>
                                        </div>

                                        <div class="form-group col-md-2 mb-0">
                                            <label for="detallemodelo">Modelo:</label>
                                            <input type="text" class="form-control" id="detallemodelo" name="detallemodelo" placeholder="Modelo" maxlength="250"/>
                                        </div>

                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desglosemonto">Total:</label>
                                            <input type="text" class="form-control" id="desglosemonto" name="desglosemonto" placeholder="Total" maxlength="11"/>
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
                            </div>
                           
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle">
                            
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