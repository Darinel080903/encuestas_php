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
                                
                                <div class="form-group col-md-3">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="numero">Número de factura:</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" placeholder="Número económico" maxlength="11" value="{{old('numero')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>número </strong> es un campo requerido!
                                    </div>  
                                </div>

                            </div>

                            <div class="form-row">

                                

                                

                                <div class="form-group col-md-3">
                                    <label for="modelo">Modelo:</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" placeholder="modelo" maxlength="4" value="{{old('modelo')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>modelo</strong> es un campo requerido!
                                    </div>                                
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="placa">Número de placas:</label>
                                    <input type="text" class="form-control" id="placa" name="placa" placeholder="Número de placas" maxlength="10" value="{{old('placa')}}"/>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="serie">Número de serie (NIV):</label>
                                    <input type="text" class="form-control" name="serie" placeholder="Número de serie" maxlength="20" value="{{old('serie')}}"/>                                
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="motor">Número de motor:</label>
                                    <input type="text" class="form-control" name="motor" placeholder="Motor" maxlength="20" value="{{old('motor')}}"/>                                
                                </div>
                                
                                

                            </div>
                    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="descripcion">Descripción u observaciones:</label>
                                    <textarea class="form-control" name="descripcion" placeholder="Descripción" rows="2">{{old('descripcion')}}</textarea>                                
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

        $(function(){
            $("#modelo").validCampoFranz("0123456789");	
    		// $("#precio").validCampoFranz(".,0123456789");	
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
