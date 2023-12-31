@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar área</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" action="{{ url('/areas/'.$area->idarea) }}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="fkarea">Areas:</label>
                                    <select class="form-control" id="fkarea" name="fkarea">
                                        <option value="">Area</option>
                                        @foreach ($areas as $item)
                                            @if ($area->fkarea == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('areas.editaroption',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="area">Area:</label>
                                    <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $area->area }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>área</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="clave">Clave presupuestal:</label>
                                    <input type="text" class="form-control" id="clave" name="clave" value="{{ $area->clave}}" maxlength="22">                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($area->activo == 1) {{ 'checked' }} @endif>
                                </div>
                            </div>  
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/areas') }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#fkarea").chosen();
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