@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar proveedor</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" action="{{ url('/proveedores/'.$proveedores->idproveedor) }}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="proveedor">Proveedor:</label>
                                    <input type="text" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" name="proveedor" value="{{$proveedores->proveedor}}" maxlength="250" placeholder="proveedor" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>proveedor</strong> es un campo requerido!
                                    </div>
                                </div>                                
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="domicilio">Domicilio:</label>
                                    <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{$proveedores->domicilio}}" maxlength="250" placeholder="domicilio">                                    
                                </div>                                
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="rfc">Rfc:</label>
                                    <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{$proveedores->rfc}}" maxlength="10" placeholder="rfc" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>rfc</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="homoclave">Homoclave:</label>
                                    <input type="text" class="form-control @error('homoclave') is-invalid @enderror" id="homoclave" name="homoclave" value="{{$proveedores->homoclave}}" maxlength="3" placeholder="homoclave" required>
                                    <div class="invalid-feedback">
                                        ¡La <strong>homoclave</strong> es un campo requerido!
                                    </div>
                                </div> 
                                <div class="form-group col-md-3">
                                    <label for="curp">Curp:</label>
                                    <input type="text" class="form-control" id="curp" name="curp" value="{{$proveedores->curp}}" maxlength="18" placeholder="curp">                                    
                                </div>                                  
                            </div>
                           
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($proveedores->activo == 1) {{'checked'}} @endif>
                                </div>
                            </div>  
                            <input type="hidden" name="page" value="{{ $page ?? '' }}">
                            <input type="hidden" name="vbusqueda" value="{{ $vbusqueda ?? '' }}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/proveedores?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
       
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