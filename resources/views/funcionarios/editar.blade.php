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
                                    <select class="form-control @error('adscripcion') is-invalid @enderror form-control-chosen" id="adscripcion" name="adscripcion" required>
                                        <option value="">Adscripcion</option>
                                        @foreach ($areas as $item)
                                            @if ($funcionarios->fkadscripcion == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childsactivos))
                                                @include('funcionarios.editoptionadsc',['childsactivos' => $item->childsactivos])
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>adscripción</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="area">Areas:</label>
                                    <select class="form-control @error('area') is-invalid @enderror form-control-chosen" id="area" name="area" required>
                                        <option value="">Area</option>
                                        @foreach ($areas as $item)
                                            @if ($funcionarios->fkarea == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childsactivos))
                                                @include('funcionarios.editoptionarea',['childsactivos' => $item->childsactivos])
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
                                    <select class="form-control form-control-chosen" id="categoria" name="categoria">
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
                                    <select class="form-control form-control-chosen" id="puesto" name="puesto">
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

                            @if(Auth::user()->hasRole('administrador') OR Auth::user()->hasRole('informatica'))
                                <div class="card mb-3">
                                    <div class="card-header">Permisos de informática</div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label for="firma">Firma pases de salida:</label><br>
                                                <input type="checkbox" class="form-control" id="firma" name="firma" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->firma == 1) {{'checked'}} @endif>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="otorga">Otorga resguardo:</label><br>
                                                <input type="checkbox" class="form-control" id="otorga" name="otorga" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->otorga == 1) {{'checked'}} @endif>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="responsable">Responsable UI:</label><br>
                                                <input type="checkbox" class="form-control" id="responsable" name="responsable" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->responsable == 1) {{'checked'}} @endif>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            @endif
                            
                            @if(Auth::user()->hasRole('administrador') OR Auth::user()->hasRole('recursos-materiales'))
                                <div class="card mb-3">
                                    <div class="card-header">Permisos de materiales</div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label for="elabora">Elabora:</label><br>
                                                <input type="checkbox" class="form-control" id="elabora" name="elabora" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->elabora == 1) {{'checked'}} @endif>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="solicita">Solicita:</label><br>
                                                <input type="checkbox" class="form-control" id="solicita" name="solicita" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->entrega == 1) {{'checked'}} @endif>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="autoriza">Autoriza:</label><br>
                                                <input type="checkbox" class="form-control" id="autoriza" name="autoriza" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->autoriza == 1) {{'checked'}} @endif>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="valida">Valida:</label><br>
                                                <input type="checkbox" class="form-control" id="valida" name="valida" data-toggle="toggle" data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger" @if($funcionarios->valida == 1) {{'checked'}} @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
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
        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });

        $("#adscripcion").change(function(){
            if($("#adscripcion").val() != "")
            {
                if($("#adscripcion_chosen").hasClass("is-invalid") === true)
                {
                    $("#adscripcion_chosen").removeClass("is-invalid");
                    $("#adscripcion_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#adscripcion_chosen").hasClass("is-valid") === true)
                {
                    $("#adscripcion_chosen").removeClass("is-valid");
                    $("#adscripcion_chosen").addClass("is-invalid");
                }
            }
        });

        $("#area").change(function(){
            if($("#area").val() != "")
            {
                if($("#area_chosen").hasClass("is-invalid") === true)
                {
                    $("#area_chosen").removeClass("is-invalid");
                    $("#area_chosen").addClass("is-valid");
                }
            }
            else
            {
                if($("#area_chosen").hasClass("is-valid") === true)
                {
                    $("#area_chosen").removeClass("is-valid");
                    $("#area_chosen").addClass("is-invalid");
                }
            }
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
                    if($("#adscripcion").val() == "")
                    {
                        $('#adscripcion_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#adscripcion_chosen').addClass('is-valid');
                    }
                    if($("#area").val() == "")
                    {
                        $('#area_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#area_chosen').addClass('is-valid');
                    }
                    $('#categoria_chosen').addClass('is-valid');
                    $('#puesto_chosen').addClass('is-valid');
                }
                form.classList.add('was-validated');
                if($("#adscripcion").val() != "")
                {
                    $('#adscripcion_chosen').addClass('is-valid');
                }
                if($("#area").val() != "")
                {
                    $('#area_chosen').addClass('is-valid');
                }
                $('#categoria_chosen').addClass('is-valid');
                $('#puesto_chosen').addClass('is-valid');
              }, false);
            });
          }, false);
        })(); 
    </script>
@endsection