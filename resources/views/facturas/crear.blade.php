@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-file-invoice-dollar"></i> Nueva factura</h4>
                    </div>
                    <div class="card-body">
                       
                        <form class="needs-validation" method="POST" action="{{url('/facturas')}}" novalidate>
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="numero">Número de factura:</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" placeholder="Número económico" maxlength="50" value="{{old('numero')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>número</strong> es un campo requerido!
                                    </div>  
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="proveedor">Proveedor:</label>
                                    <input type="text" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" name="proveedor" placeholder="Proveedor" maxlength="250" value="{{old('proveedor')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>proveedor</strong> es un campo requerido!
                                    </div>  
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label for="desglosenumero">Número:</label>
                                    <input type="text" class="form-control" id="desglosenumero" name="desglosenumero" placeholder="Número" maxlength="11"/>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="desgloseconcepto">Concepto:</label>
                                    <input type="text" class="form-control" id="desgloseconcepto" name="desgloseconcepto" placeholder="Concepto" maxlength="250"/>
                                </div>

                                <div class="form-group col-md-1">
                                    <label for="desgloseunitario">Precio:</label>
                                    <input type="text" class="form-control" id="desgloseunitario" name="desgloseunitario" placeholder="Unitario" maxlength="11"/>
                                </div>

                                <div class="form-group col-md-1">
                                    <label for="desglosemonto">Total:</label>
                                    <input type="text" class="form-control" id="desglosemonto" name="desglosemonto" placeholder="Total" maxlength="11"/>
                                </div>

                                <div class="form-group col-md-1">
                                    <label for="boton">&nbsp; Agregar</label>
                                    <a class="btn btn-outline-danger" href=""><i class="fas fa-plus"></i></a>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="monto">Monto:</label>
                                    <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto" maxlength="15" value="{{old('monto')}}" readonly/>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="saldo">Saldo:</label>
                                    <input type="text" class="form-control" id="saldo" name="saldo" placeholder="Saldo" maxlength="15" value="{{old('saldo')}}" readonly/>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="monto">Fecha:</label>
                                    <input type="text" class="form-control" id="pago" name="pago" aria-label="Fecha de pago" placeholder="Fecha de pago" readonly/>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" checked>
                                </div>
                            </div>

                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="text" name="vdetalle" value="{{$vdetalle ?? ''}}">

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
            var total=0;
            if(num && uni)
            {
                total = num * uni;
                $("#desglosemonto").val(total);
            }
            else
            {
                $("#desglosemonto").val('');
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
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>
@endsection
