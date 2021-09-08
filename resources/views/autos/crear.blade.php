@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nuevo auto</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{url('/autos')}}" novalidate>
                        @csrf
                            <div class="form-row">   
                                <div class="form-group col-md-3">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="numero">Número económico:</label>
                                    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" placeholder="Número económico" maxlength="11" value="{{old('numero')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>número </strong> es un campo requerido!
                                    </div>  
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="fabrica">Fabricas:</label>
                                    <select class="form-control @error('fabrica') is-invalid @enderror form-control-chosen" id="fabrica" name="fabrica" required>
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
                                <div class="form-group col-md-3">
                                    <label for="tipo">Tipos:</label>
                                    <select class="form-control @error('tipo') is-invalid @enderror form-control-chosen" id="tipo" name="tipo" required>
                                        <option value="">Tipo</option>  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>tipo</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="modelo">Modelo:</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" placeholder="modelo" maxlength="4" value="{{old('modelo')}}" required/>
                                    <div class="invalid-feedback">
                                        ¡El <strong>modelo</strong> es un campo requerido!
                                    </div>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="placa">Número de placas:</label>
                                    <input type="text" class="form-control" id="placa" name="placa" placeholder="Número de placas" maxlength="10" value="{{old('placa')}}"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="serie">Número de serie (NIV):</label>
                                    <input type="text" class="form-control" name="serie" placeholder="Número de serie" maxlength="20" value="{{old('serie')}}"/>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="motor">Número de motor:</label>
                                    <input type="text" class="form-control" name="motor" placeholder="Motor" maxlength="20" value="{{old('motor')}}"/>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="transmision">Transmisiones:</label>
                                    <select class="form-control" id="transmision" name="transmision">
                                        <option value="">Transmisión</option>
                                        @foreach ($transmisiones as $item)
                                            @if (old('transmision') == $item->idtransmision)
                                                <option value="{{$item->idtransmision}}" selected>{{$item->transmision}}</option>
                                            @else
                                                <option value="{{$item->idtransmision}}">{{$item->transmision}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="combustible">Combustibles:</label>
                                    <select class="form-control" id="combustible" name="combustible">
                                        <option value="">Combustible</option>
                                        @foreach ($combustibles as $item)
                                            @if (old('combustible') == $item->idcombustible)
                                                <option value="{{$item->idcombustible}}" selected>{{$item->combustible}}</option>
                                            @else
                                                <option value="{{$item->idcombustible}}">{{$item->combustible}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="descripcion">Descripción u observaciones:</label>
                                    <textarea class="form-control" name="descripcion" placeholder="Descripción" rows="2">{{old('descripcion')}}</textarea>                                
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="funcionario">Funcionario resguardo:</label>
                                    <select class="form-control" id="funcionario" name="funcionario">
                                        <option value="">Funcionario</option>
                                        @foreach ($funcionarios as $item)
                                            @if (old('funcionario') == $item->idfuncionario)
                                                <option value="{{$item->idfuncionario}}" selected>{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</option>
                                            @else
                                                <option value="{{$item->idfuncionario}}">{{$item->nombre.' '.$item->paterno.' '.$item->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="activo">Activo:</label><br>
                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" checked>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vactivo" value="{{$vactivo ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/autos?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                            <div class="d-none justify-content-center" id="divloading">
                                <div class="spinner-grow divloading" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="font-weight-bolder text-muted font-italic mt-1 mb-2">&nbsp;Cargando...</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#fecha').datepicker({
            uiLibrary: 'bootstrap4',
            locale: 'es-es',
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });

        $(function(){
            $("#fabrica").change(function(){
                $("#divloading").addClass("d-flex").removeClass("d-none");
                if(event.target.value)
                {
                    // Ini Ajax
                    var url = "{{url('/autos/fabrica/idfabrica')}}";
                    url = url.replace("idfabrica", event.target.value);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            $("#tipo").empty();
                            $("#tipo").append("<option value=''>Tipo</option>");
                            for(let i = 0; i< response.length; i++)
                            {
                                $("#tipo").append("<option value='"+response[i].idtipo+"'>"+response[i].tipo+"</option>"); 
                            }
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el tipo!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#tipo").empty();
                    $("#tipo").append("<option value=''>Tipo</option>");
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                } 
            });
        });

        $(function(){
            $("#modelo").validCampoFranz("0123456789");	
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