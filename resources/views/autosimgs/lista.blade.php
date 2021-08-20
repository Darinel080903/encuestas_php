@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde shadow">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-images"></i> Galeria de imagenes</h3>
                    </div>
                    <div class="card-body">
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">Guardar imagen</div>
                                    <div class="card-body">
                                        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{url('/autosimgs')}}" novalidate>
                                        @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="img"></label>
                                                    <img class="rounded mx-auto d-block mb-2" id="img" name="img" width="40%" src="{{ asset('storage/img/default.png') }}" alt="Seleccionar imagen">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" id="imagen" name="imagen" lang="es" aria-describedby="imagen" required>
                                                        <label class="custom-file-label" for="imagen">Seleccionar imagen</label>
                                                        <div class="invalid-feedback">
                                                            ¡La <strong>imagen</strong> es un campo requerido y debe ser extensión png o jpg!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="<i class='fas fa-check'></i>" data-off="<i class='fas fa-times'></i>" data-onstyle="success" data-offstyle="danger" checked>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <input type="hidden" id="fkauto" name="fkauto" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="left" title="Guardar"><i class="fas fa-save"></i> Guardar</button>
                                                    <a class="btn btn-outline-danger" data-toggle="tooltip" data-placement="left" title="Regresar" href="{{url('/autos?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            <th class="text-center" width="76%" scope="col">Imagen</th>
                                            <th class="text-center" scope="col" width="6%">Publicar</th>
                                            <th class="text-center" scope="col" width="18%">Borrar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($imgs as $item)
                                                @if (isset($item->imagen))
                                                    <tr>
                                                        <td><img class="img-thumbnail" src="{{ asset('storage/auto/'.$item->imagen) }}" alt="{{ $item->imagen }}"></td>
                                                        <td class="text-center">
                                                            <form id="frmimgpublicar{{$item->idimg}}" name="frmimgpublicar{{$item->idimg}}" method="POST" action="{{url('/autosimgs/'.$item->idimg)}}">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idimg}}')"  data-toggle="toggle" data-on="<i class='fas fa-check'></i>" data-off="<i class='fas fa-times'></i>" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                                            </form>
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="POST" action="{{url('/autosimgs/'.$item->idimg)}}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button class="btn btn-outline-danger" data-toggle="tooltip" data-placement="left" title="Eliminar" type="submit"><i class="fas fa-trash"></i> Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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

        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $("#toggle-demo").bootstrapToggle();
        });

        function funpublicar(frm)
        {
            $("#"+frm).submit();
        }

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