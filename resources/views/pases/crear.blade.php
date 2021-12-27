@extends('layouts.app')

@section('content')

    <div class="modal fade" id="ModalScanSerie" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="readerSerie"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalScanPatrimonio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="readerPatrimonio"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nuevo pase de salida</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" id="formmain" method="POST" action="{{url('/pases')}}" novalidate>
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{date("d/m/Y")}}" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        ¡La <strong>fecha</strong> es un campo requerido!
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="hora">Hora:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('hora') is-invalid @enderror" id="hora" name="hora" aria-label="Hora" placeholder="Hora" value="{{date("h:i A")}}" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                    </div>
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
                                        <div class="form-group col-md-3 mb-0">
                                            <label for="detalleequipo">Equipo:</label>
                                            <input type="text" class="form-control" id="detalleequipo" name="detalleequipo" placeholder="Equipo" maxlength="250"/>
                                        </div>

                                        <div class="form-group col-md-2 mb-0">
                                            <label for="detallemarca">Marca:</label>
                                            <input type="text" class="form-control" id="detallemarca" name="detallemarca" placeholder="Marca" maxlength="250"/>
                                        </div>

                                        <div class="form-group col-md-2 mb-0">
                                            <label for="detallemodelo">Modelo:</label>
                                            <input type="text" class="form-control" id="detallemodelo" name="detallemodelo" placeholder="Modelo" maxlength="250"/>
                                        </div>

                                        <div class="form-group col-md-2 mb-0">
                                            <label for="detalleserie">Serie:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="detalleserie" name="detalleserie" placeholder="Serie" maxlength="250"/>
                                                <div class="input-group-append">
                                                    <a class="btn btn-outline-secondary mb-0" href="javascript:ScanSerie();"><i class="fas fa-barcode"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2 mb-0">
                                            <label for="detallepatrimonio">Patrimonio:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="detallepatrimonio" name="detallepatrimonio" placeholder="Patrimonio" maxlength="250"/>
                                                <div class="input-group-append">
                                                    <a class="btn btn-outline-secondary mb-0" href="javascript:ScanPatrimonio();"><i class="fas fa-barcode"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-1 mb-0">
                                            <label for="boton">&nbsp; Agregar</label>
                                            <a class="btn btn-outline-danger btn-block" href="javascript:DetalleGuardar();"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="detalle">
                                            <thead>
                                                <tr>
                                                    <th class="col-3">Equipo</th>
                                                    <th class="col-2">Marca</th>
                                                    <th class="col-2">Modelo</th>
                                                    <th class="col-2">Serie</th>
                                                    <th class="col-2">Patrimonio</th>
                                                    <th class="col-1">Eliminar</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="observacion">Observaciones:</label>
                                    <textarea class="form-control" name="observacion" id="observacion" aria-label="Observaciones" placeholder="Observaciones" cols="30" rows="4">{{old('observacion')}}</textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="funcionario">Funcionarios:</label>
                                    <select class="form-control @error('funcionario') is-invalid @enderror" id="funcionario" name="funcionario" required>
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
                           
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle">
                            
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/pases?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#detalleequipo").keyup(function(){
            if($("#detalleequipo").val() != "" && $("#detalleequipo").hasClass("is-invalid") === true)
            {
                $("#detalleequipo").removeClass("is-invalid");
                $("#detalleequipo").addClass("is-valid");    
            }
        });
        $("#detallemarca").keyup(function(){
            if($("#detallemarca").val() != "" && $("#detallemarca").hasClass("is-invalid") === true)
            {
                $("#detallemarca").removeClass("is-invalid");
                $("#detallemarca").addClass("is-valid");    
            }
        });
        $("#detallemodelo").keyup(function(){
            if($("#detallemodelo").val() != "" && $("#detallemodelo").hasClass("is-invalid") === true)
            {
                $("#detallemodelo").removeClass("is-invalid");
                $("#detallemodelo").addClass("is-valid");    
            }
        });
        $("#detalleserie").keyup(function(){
            if($("#detalleserie").val() != "" && $("#detalleserie").hasClass("is-invalid") === true)
            {
                $("#detalleserie").removeClass("is-invalid");
                $("#detalleserie").addClass("is-valid");    
            }
        });
        $("#detallepatrimonio").keyup(function(){
            if($("#detallepatrimonio").val() != "" && $("#detallepatrimonio").hasClass("is-invalid") === true)
            {
                $("#detallepatrimonio").removeClass("is-invalid");
                $("#detallepatrimonio").addClass("is-valid");    
            }
        });
        
        var Detalle = [];
        
        function DetalleGuardar()
        {
            var valida = true;
            var vequipo = $("#detalleequipo").val();
            var vmarca = $("#detallemarca").val();
            var vmodelo = $("#detallemodelo").val();
            var vserie = $("#detalleserie").val();
            var vpatrimonio = $("#detallepatrimonio").val();
            
            if(vequipo == "")
            {
                $("#detalleequipo").addClass("is-invalid");
                valida = false;
            }
            if(vmarca == "")
            {
                $("#detallemarca").addClass("is-invalid");
                valida = false;
            }
            if(vmodelo == "")
            {
                $("#detallemodelo").addClass("is-invalid");
                valida = false;
            }
            if(vserie == "")
            {
                $("#detalleserie").addClass("is-invalid");
                valida = false;
            }
            if(vpatrimonio == "")
            {
                $("#detallepatrimonio").addClass("is-invalid");
                valida = false;
            }
            
            if(valida == true)
            {
                Detalle.push({equipo:vequipo, marca:vmarca, modelo:vmodelo, serie:vserie, patrimonio:vpatrimonio});    
                $("#vdetalle").val("");
                $("#vdetalle").val(JSON.stringify(Detalle));
                MostrarDetalle();

                $("#detalleequipo").val("");
                $("#detallemarca").val("");
                $("#detallemodelo").val("");
                $("#detalleserie").val("");
                $("#detallepatrimonio").val("");

                if($("#detalleequipo").hasClass("is-valid") === true)
                {
                    $("#detalleequipo").removeClass("is-valid");
                }
                if($("#detallemarca").hasClass("is-valid") === true)
                {
                    $("#detallemarca").removeClass("is-valid");
                }
                if($("#detallemodelo").hasClass("is-valid") === true)
                {
                    $("#detallemodelo").removeClass("is-valid");
                }
                if($("#detalleserie").hasClass("is-valid") === true)
                {
                    $("#detalleserie").removeClass("is-valid");
                }
                if($("#detallepatrimonio").hasClass("is-valid") === true)
                {
                    $("#detallepatrimonio").removeClass("is-valid");
                }
            }
        }

        function DesgloseEliminar(i)
        {
            $("#formmain").removeClass("was-validated");
            Detalle.splice(i, 1);
            $("#vdetalle").val("");
            $("#vdetalle").val(JSON.stringify(Detalle));
            MostrarDetalle();     
        }

        function MostrarDetalle()
        {         
            $("#detalle").empty();
            $("#detalle").append("<thead><tr><th class='col-3'>Equipo</th><th class='col-2'>Marca</th><th class='col-2'>Modelo</th><th class='col-2'>Serie</th><th class='col-2'>Patrimonio</th><th class='col-1'>Eliminar</th></tr></thead>"); 
            $("#detalle").append("<tbody>");
            $.each(Detalle, function(key, value)
            {
                $("#detalle").append("<tr><td class='align-middle'>"+Detalle[key].equipo+"</td><td class='align-middle'>"+Detalle[key].marca+"</td><td class='align-middle'>"+Detalle[key].modelo+"</td><td class='align-middle'>"+Detalle[key].serie+"</td><td class='align-middle'>"+Detalle[key].patrimonio+"</td><td><a class='btn btn-outline-danger btn-block' href='javascript:DesgloseEliminar("+key+");'><i class='fas fa-minus'></i></a></td></tr>");
            });
            $("#detalle").append("</tbody>");
        }

        

        function onScanSuccessSerie(decodedText, decodedResult)
        {
            // Handle on success condition with the decoded text or result.
            // console.log(`Scan result: ${decodedText}`, decodedResult);
            if(decodedText)
            {
                $("#detalleserie").val("");
                $("#detalleserie").val(decodedText);
                console.log(decodedText);
                $("#ModalScanSerie").modal("hide");
                html5QrcodeScanner.clear();
            }
            // $("#detalleserie").val("");
            // $("#detalleserie").val(decodedText);
            // console.log(decodedText);
            // html5QrcodeScanner.clear();
        }
        
        function ScanSerie()
        {
            var html5QrcodeScanner = new Html5QrcodeScanner("readerSerie", {fps:10, qrbox:250});
            html5QrcodeScanner.render(onScanSuccessSerie);
            $("#ModalScanSerie").modal("show");
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