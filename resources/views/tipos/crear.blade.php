@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nuevo tipo</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{url('/tipos')}}" novalidate>
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fabrica">Fabricas:</label>
                                    <select class="form-control @error('fabrica') is-invalid @enderror" id="fabrica" name="fabrica" required>
                                        <option value="">Fabrica</option>
                                        @foreach ($fabricas as $item)
                                            @if (old('fabrica') == $item->idfabrica)
                                                <option value="{{$item->idfabrica}}" selected>{{$item->fabrica}}</option>
                                            @else
                                                <option value="{{$item->idfabrica}}">{{$item->fabrica}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>fabrica</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tipo">Tipo:</label>
                                    <input class="form-control form-rounded @error('tipo') is-invalid @enderror" id="tipo" name="tipo" placeholder="Tipo" value="{{old('tipo')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>tipo</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/tipos?page='.$page.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
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