@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nueva cédula</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{ url('/cedulas') }}" novalidate>
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                    <div class="invalid-feedback">
                                        ¡La <strong>fecha</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="cedula">Cédula:</label>
                                    <input type="text" class="form-control  @error('cedula') is-invalid @enderror" id="cedula" name="cedula" value="{{old('cedula')}}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡La <strong>cédula</strong> es un campo requerido!
                                    </div>
                                </div> 
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/cedulas?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
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