@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar rol</h3>
                    </div>

                    <div class="card-body">     
                
                        <form class="needs-validation" method="POST"  action="{{ url('/roles/'.$roles->id) }}" novalidate>
                            @method('PUT')
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $roles->name }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>nombre</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="slug">Slug:</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ $roles->slug }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>slug</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="permiso">Permisos:</label>
                                    <input type="text" class="form-control" id="permiso" name="permiso" data-role="tagsinput" maxlength="250" value="@if(count($roles->permissions) > 0) @foreach($roles->permissions as $item){{$item->name.','}}@endforeach @endif">
                                </div>
                            </div>

                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/roles?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
         $("#permiso").tagsinput({tagClass:'badge badge-danger'});

        $(document).ready(function(){
            $("#nombre").keyup(function(e){
                var str= $("#nombre").val(); 
                str = str.replace(/\W+(?!$)/g, '-').toLowerCase();
                $("#slug").val(str);
                $("#slug").attr('placeholder', str);
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