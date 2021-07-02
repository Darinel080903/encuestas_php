@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-images"></i> Galería de Autos en Venta</h4>
                    </div>

                    <div class="card-body">
                        
                        @if ( session('mensaje') )
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif
                        
                        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{url('/autosimgs')}}" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="img">Imagen:</label>
                                <img class="rounded mx-auto d-block mb-2" id="img" name="img" width="10%" src="{{ asset('storage/img/default.png') }}" alt="Seleccionar imagen">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" id="imagen" name="imagen" lang="es" aria-describedby="imagen" required>
                                    <label class="custom-file-label" for="imagen">Seleccionar imagen</label>
                                    <div class="invalid-feedback">
                                        ¡La <strong>imagen</strong> es un campo requerido y debe ser extensión png o jpg!
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="orden">Orden:</label>
                                <input type="number" class="form-control @error('orden') is-invalid @enderror mb-2" name="orden" placeholder="Orden" max="99"/>
                                @error('orden')
                                    <div class="invalid-feedback">
                                        ¡El <strong>orden</strong> es un campo requerido!
                                    </div>
                                @enderror
                            </div> --}}
                            
                            <div class="form-group">
                                <label for="activo">Publicar:</label><br>
                                <input type="checkbox" class="form-control" id="activo" name="activo" data-toggle="toggle" data-on="Publicar" data-off="No publicar" data-onstyle="success" data-offstyle="danger" checked>
                            </div>

                            <input type="hidden" id="fkauto" name="fkauto" value="{{$id}}">

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/autos?page='.$page.'&vfecha='.$vfecha.'&vactivo='.$vactivo.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>

                        <br>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th class="text-center" width="80%" scope="col">Imagen</th>
                                {{-- <th class="text-center" scope="col">Orden</th> --}}
                                <th class="text-center" scope="col">Publicar</th>
                                <th class="text-center" width="13%" scope="col">Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($imgs as $item)
                                    @if (isset($item->imagen))
                                        <tr>
                                            <td><img class="img-thumbnail" src="{{asset('storage/auto/'.$item->imagen)}}" alt="{{$item->imagen}}"></td>
                                            {{-- <td class="text-center">{{ $item->orden }}</td> --}}
                                            <td class="text-center">
                                                <form id="frmimgpublicar{{$item->idimg}}" name="frmimgpublicar{{$item->idimg}}" method="POST" action="{{url('/autosimgs/'.$item->idimg)}}">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$item->idimg}}')"  data-toggle="toggle" data-on="Publicar" data-off="No publicar" data-onstyle="success" data-offstyle="danger" @if($item->activo == 1) {{'checked'}} @endif>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <form method="POST" action="{{url('/autosimgs/'.$item->idimg)}}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
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

        $("#toggle-demo").bootstrapToggle();

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