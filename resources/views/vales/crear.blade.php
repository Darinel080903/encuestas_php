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
                       
                        <form class="needs-validation" method="POST" action="{{url('/vales')}}" novalidate>
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="auto">Autos:</label>
                                    <select class="form-control" id="auto" name="auto">
                                        <option value="">Auto</option>
                                        @foreach ($autos as $item)
                                            @if (old('auto') == $item->idauto)
                                                <option value="{{$item->idauto}}" selected>{{$item->numero}}</option>
                                            @else
                                                <option value="{{$item->idauto}}">{{$item->numero}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="funcionario">Funcionarios:</label>
                                    <select class="form-control" id="funcionario" name="funcionario">
                                        <option value="">Funcionario</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2 mb-0">
                                    <label for="kmini">Km inicial:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">Km.</span>
                                        </div>
                                        <input type="text" class="form-control" id="kmini" name="kmini" placeholder="Km inicial" maxlength="11"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-2 mb-0">
                                    <label for="kmfin">Km final:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">Km.</span>
                                        </div>
                                        <input type="text" class="form-control" id="kmfin" name="kmfin" placeholder="Km final" maxlength="11"/>
                                    </div>
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
                                {{-- <div class="form-group col-md-2">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" checked>
                                </div> --}}

                                {{-- <div class="form-group col-md-2">
                                    <label for="saldo">Saldo:</label>
                                    <input type="text" class="form-control" id="saldo" name="saldo" placeholder="Saldo" maxlength="15" value="{{old('saldo')}}" readonly/>
                                </div> --}}

                                <div class="form-group offset-md-9 col-md-2 pl-0 mr-2">
                                    <label for="monto">Monto:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto" maxlength="15" value="{{old('monto')}}" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="recibe">Recibe:</label>    
                                    <input type="text" class="form-control" id="recibe" name="recibe" placeholder="Recibe" maxlength="250"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="observacion">Observaciones:</label>    
                                    <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Recibe" maxlength="250"/>
                                    <textarea name="" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/vales?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>

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

        $(function(){
            $("#auto").change(function(){
                
                // Ini Ajax
                var url = "{{url('/vales/autos/idauto')}}";
                url = url.replace("idauto", event.target.value);
                $("#divloading").addClass("d-flex").removeClass("d-none");
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
                            $("#funcionario").append("<option value='"+response[i].idfuncionario+"'>"+response[i].nombre+" "+response[i].paterno+" "+response[i].materno+"</option>"); 
                        }
                        $("#divloading").addClass("d-none").removeClass("d-flex");
                    },
                    error: function(xhr, textStatus, errorThrown)
                    {
                        alert("¡Error al cargar el funcionario!");
                        $("#divloading").addClass("d-none").removeClass("d-flex");
                    }
                });
                // Fin Ajax 
   
            });
        });

        $(function(){
            $("#kmini").validCampoFranz("0123456789");
            $("#kmfin").validCampoFranz("0123456789");
    	});


        $('#pago').datepicker({
            uiLibrary: 'bootstrap4',
            locale: 'es-es',
            format: 'dd/mm/yyyy'
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
