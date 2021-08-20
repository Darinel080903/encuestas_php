@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar usuario</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{ url('/usuarios/'.$usuarios->id) }}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $usuarios->name }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>nombre</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="correo">Correo electrónico:</label>
                                    <input type="email " class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ $usuarios->email }}" maxlength="250" required>
                                    <div class="invalid-feedback">
                                        ¡El <strong>correo electrónico</strong> es un campo requerido!
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="contraseña">Contraseña:</label>
                                    <input type="password" class="form-control @error('contraseña') is-invalid @enderror" id="contraseña" name="contraseña" maxlength="250">
                                    @error('contraseña')
                                        <div class="invalid-feedback">
                                            ¡La <strong>contraseña</strong> es un campo requerido y debe ser confirmado!
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="contraseña_confirmation">Confirma contraseña:</label>
                                    <input type="password" class="form-control" id="contraseña_confirmation" name="contraseña_confirmation" maxlength="250">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="role">Roles:</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="">Rol</option>
                                        @foreach ($roles as $item)
                                            @if ($usuariorole != null)
                                                @if ($usuariorole->id == $item->id)
                                                    <option data-role-id="{{$item->id}}" data-role-slug="{{$item->slug}}" value="{{$item->id}}" selected>{{$item->name}}</option>
                                                @else
                                                    <option data-role-id="{{$item->id}}" data-role-slug="{{$item->slug}}" value="{{$item->id}}">{{$item->name}}</option>
                                                @endif
                                            @else
                                                <option data-role-id="{{$item->id}}" data-role-slug="{{$item->slug}}" value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" id="permissions_box">
                                <div class="form-group col-md-12">
                                    <label for="role">Permisos:</label>
                                    <div id="permissions_checkbox_lista"></div>
                                </div>
                            </div>
                            @if ($usuarios->permissions->isNotEmpty())
                                @if ($rolepermisos != null)
                                    <div class="form-row"  id="user_permissions_box">
                                        <div class="form-group col-md-12">
                                            <label for="role">Permisos:</label>
                                            @foreach ($rolepermisos as $permisos)
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" name="permissions[]" id="{{$permisos->slug}}" value="{{$permisos->id}}" {{in_array($permisos->id, $usuariopermisos->pluck('id')->toArray()) ? 'checked="checked"' : ''}}>
                                                    <label class="custom-control-label" for="{{$permisos->slug}}">{{$permisos->name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{ url('/usuarios?page='.$page.'&vbusqueda='.$vbusqueda) }}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var permissions_box = $("#permissions_box");
            var permissions_checkbox_lista = $("#permissions_checkbox_lista");
            var user_permissions_box = $("#user_permissions_box");
            permissions_box.hide();

            $("#role").on("change", function(){
                var role = $(this).find(":selected");
                var role_id = role.data("role-id");
                var role_slug = role.data("role-slug");

                permissions_checkbox_lista.empty();
                user_permissions_box.empty();
                
                $.ajax({
                    url: "/usuarios/create",
                    method: "get",
                    dataType: "json",
                    data:{"role_id": role_id, "role_slug":role_slug}
                }).done(function(data){
                    //console.log(data);
                    permissions_box.show();
                    $.each(data, function(index, element){
                        $(permissions_checkbox_lista).append(
                            "<div class='custom-control custom-checkbox'>"+
                                "<input class='custom-control-input' type='checkbox' name='permissions[]' id='"+ element.slug +"' value='"+ element.id +"'>"+
                                "<label class='custom-control-label' for='"+ element.slug +"'>"+ element.name +"</label>"+
                            "</div>"
                        );
                    });
                })
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