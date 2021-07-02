@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar {{$vdescripcion ?? ''}}</h3>
                    </div>
                    
                    <div class="card-body">     
                
                        <form class="needs-validation" method="POST" action="
                            @if($vtabla == 'articulos') 
                                {{ url('/catalogos/'.$catalogos->idarticulo) }}
                            @elseif($vtabla == 'marcas') 
                                {{ url('/catalogos/'.$catalogos->idmarca) }}
                            @elseif($vtabla == 'categorias') 
                                {{ url('/catalogos/'.$catalogos->idcategoria) }}
                            @elseif($vtabla == 'puestos') 
                                {{ url('/catalogos/'.$catalogos->idpuesto) }}
                            @endif" novalidate>
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="parte">{{ $vdescripcion ?? '' }}:</label>
                                @if($vtabla == 'articulos')
                                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" placeholder="Descripcion" max="250" value="{{ $catalogos->articulo }}" required/>
                                @elseif($vtabla == 'marcas')
                                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" placeholder="Descripcion" max="250" value="{{ $catalogos->marca }}" required/>
                                @elseif($vtabla == 'categorias')
                                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" placeholder="Descripcion" max="250" value="{{ $catalogos->categoria }}" required/>
                                @elseif($vtabla == 'puestos')
                                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" placeholder="Descripcion" max="250" value="{{ $catalogos->puesto }}" required/>
                                @endif
                                <div class="invalid-feedback">
                                    ¡La <strong>descripción</strong> es un campo requerido!
                                </div>
                            </div>

                            <input type="hidden" name="vtabla" value="{{ $vtabla ?? '' }}">
                            <input type="hidden" name="vdescripcion" value="{{ $vdescripcion ?? '' }}">
                            <input type="hidden" name="page" value="{{ $page ?? '' }}">
                            <input type="hidden" name="vbusqueda" value="{{ $vbusqueda ?? '' }}">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/catalogos?vtabla='.$vtabla.'&vdescripcion='.$vdescripcion.'&page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
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