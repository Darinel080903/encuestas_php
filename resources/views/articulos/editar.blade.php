@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar artículo</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{ url('/articulos/'.$articulos->idarticulo) }}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="articulo">Artículo:</label>
                                    <input type="text" class="form-control  @error('articulo') is-invalid @enderror" id="articulo" name="articulo" value="{{$articulos->articulo}}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>artículo</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="activo">(Procesador/Memoria/Disco):</label><br>
                                    <input type="checkbox" class="form-control" id="dato" name="dato" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($articulos->dato == 1) {{ 'checked' }} @endif>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="activo">Artículo raíz:</label><br>
                                    <input type="checkbox" class="form-control" id="raiz" name="raiz" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($articulos->raiz == 1) {{ 'checked' }} @endif>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/articulos?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
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