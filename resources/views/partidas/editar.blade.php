@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar partida</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" action="{{ url('/partidas/'.$partidas->idpartida) }}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="clave">Clave:</label>
                                    <input type="text" class="form-control @error('clave') is-invalid @enderror" id="clave" name="clave" value="{{$partidas->clave}}" maxlength="10" placeholder="clave" required>
                                    <div class="invalid-feedback">
                                        ¡La <strong>clave</strong> es un campo requerido!
                                    </div>                                   
                                </div>  
                                <div class="form-group col-md-10">
                                    <label for="partida">Partida:</label>
                                    <input type="text" class="form-control @error('partida') is-invalid @enderror" id="partida" name="partida" value="{{$partidas->partida}}" maxlength="255" placeholder="partida" required>
                                    <div class="invalid-feedback">
                                        ¡La <strong>partida</strong> es un campo requerido!
                                    </div>                                   
                                </div>  
                            </div>    
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($partidas->activo == 1) {{'checked'}} @endif>
                                </div>
                            </div>  
                            <input type="hidden" name="page" value="{{ $page ?? '' }}">
                            <input type="hidden" name="vbusqueda" value="{{ $vbusqueda ?? '' }}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/partidas?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
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