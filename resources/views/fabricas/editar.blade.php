@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar fabrica</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" action="{{url('/fabricas/'.$fabricas->idfabrica)}}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="marca">Fabrica:</label>
                                    <input class="form-control form-rounded @error('fabrica') is-invalid @enderror" id="fabrica" name="fabrica" placeholder="Fabrica" value="{{$fabricas->fabrica}}" required/>
                                    <div class="invalid-feedback">
                                        ¡La <strong>fabrica</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger @if(Auth::user()->hasRole('supervisor')) noaccion @endif"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/fabricas?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(window).keydown(function(event){
                if(event.keyCode == 13)
                {
                    event.preventDefault();
                    return false;
                }
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