@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar funcionario</h3>
                    </div>

                    <div class="card-body">     
                
                        <form class="needs-validation" method="POST" action="{{ url('/funcionarios/'.$funcionarios->idfuncionario) }}" novalidate>
                            @method('PUT')
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="adscripcion">Área de adscripción:</label>
                                    <select class="form-control @error('adscripcion') is-invalid @enderror" id="adscripcion" name="adscripcion" required>
                                        <option value="">Adscripcion</option>
                                        @foreach ($areas as $item)
                                            @if ($funcionarios->fkadscripcion == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>adscripción</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="area">Areas:</label>
                                    <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" required>
                                        <option value="">Area</option>
                                        @foreach ($areas as $item)
                                            @if ($funcionarios->fkarea == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>área</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $funcionarios->nombre }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>nombre</strong> es un campo requerido!
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="paterno">Apellido paterno:</label>
                                    <input type="text" class="form-control @error('paterno') is-invalid @enderror" id="paterno" name="paterno" value="{{ $funcionarios->paterno }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>apellido paterno</strong> es un campo requerido!
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="materno">Apellido materno:</label>
                                    <input type="text" class="form-control @error('materno') is-invalid @enderror" id="materno" name="materno" value="{{ $funcionarios->materno }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>apellido materno</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="categoria">Categorías:</label>
                                    <select class="form-control" id="categoria" name="categoria">
                                        <option value="">Categoría</option>
                                        @foreach ($categorias as $item)
                                            @if ($funcionarios->fkcategoria == $item->idcategoria)
                                                <option value="{{$item->idcategoria}}" selected>{{$item->categoria}}</option>
                                            @else
                                                <option value="{{$item->idcategoria}}">{{$item->categoria}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="puesto">Puestos:</label>
                                    <select class="form-control" id="puesto" name="puesto">
                                        <option value="">Puesto</option>
                                        @foreach ($puestos as $item)
                                            @if ($funcionarios->fkpuesto == $item->idpuesto)
                                                <option value="{{$item->idpuesto}}" selected>{{$item->puesto}}</option>
                                            @else
                                                <option value="{{$item->idpuesto}}">{{$item->puesto}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="firma">Firma:</label><br>
                                    <input type="checkbox" class="form-control" id="firma" name="firma" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->firma == 1) {{'checked'}} @endif>
                                </div>
                            </div> 

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($funcionarios->activo == 1) {{'checked'}} @endif>
                                </div>
                            </div>  

                            <input type="hidden" name="page" value="{{ $page ?? '' }}">
                            <input type="hidden" name="vbusqueda" value="{{ $vbusqueda ?? '' }}">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/funcionarios?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#imagen').change(function(){
                    var input = this;
                    var url = $(this).val();
                    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                    {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                        $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else
                {
                    $('#img').attr('src', '/storage/img/default.png');
                }
            });
        });

        $(document).ready(function(){
            bsCustomFileInput.init();
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