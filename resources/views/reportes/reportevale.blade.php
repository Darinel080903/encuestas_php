@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-list"></i> Impresión de vales</h3>
                    </div>                   
                    <div class="card-body">
                        <form class="needs-validation" id="formmain" method="GET" action="{{url('/reportes/imprimir/pdf')}}" target="_blank" novalidate>
                        @csrf
                            
                            <div class="form-row">                                
                                
                                <div class="form-group col-md-6"> 
                                    <label for="ejercicio">Ejercicios:</label>                                        
                                    <select class="form-control form-control-chosen" id="ejercicio" name="ejercicio">
                                        <option value="">ejercicio</option>
                                        @foreach ($ejercicios as $itemejercicio)
                                            @if (old('ejercicio') == $itemejercicio->ejercicio)
                                                <option value="{{$itemejercicio->ejercicio}}" selected>{{$itemejercicio->ejercicio}}</option>
                                            @else
                                                <option value="{{$itemejercicio->ejercicio}}">{{$itemejercicio->ejercicio}}</option>
                                            @endif                                           
                                        @endforeach    
                                    </select>                                           
                                </div>

                                <div class="form-group col-md-6"> 
                                    <label for="factura">Facturas:</label>                                        
                                    <select class="form-control form-control-chosen" id="factura" name="factura">
                                        <option value="">factura</option>
                                        @foreach ($facturas as $itemnumero)
                                            @if (old('numero') == $itemnumero->numero)
                                                <option value="{{$itemnumero->numero}}" selected>{{$itemnumero->numero}}</option>
                                            @else
                                                <option value="{{$itemnumero->numero}}">{{$itemnumero->numero}}</option>
                                            @endif                                           
                                        @endforeach    
                                    </select>                                           
                                </div>
                                                                
                            </div>

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-print"></i> Imprimir</button>
                            
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
        $(document).ready(function(){
            $(".form-control-chosen").chosen();
        });

        // $(function(){
        //     $("#area").chosen().change(function(){
        //         $("#divloading").addClass("d-flex").removeClass("d-none");
        //         var identificador = $("#area").chosen().val();
        //         if(identificador)
        //         {
        //             // Ini Ajax
        //             var url = "{{url('/bienes/funcionarios/idarea')}}";
        //             url = url.replace("idarea", identificador);
        //             $.ajax({type:"get",
        //                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //                 url:url,
        //                 dataType: "json",
        //                 success: function(response, textStatus, xhr)
        //                 {
        //                     $("#funcionario").empty();
        //                     $("#funcionario").append("<option value=''>Funcionario</option>");
        //                     for(let i = 0; i< response.length; i++)
        //                     {
        //                         $("#funcionario").append("<option value='"+response[i].idfuncionario+"'>"+response[i].nombre+' '+response[i].paterno+' '+response[i].materno+"</option>"); 
        //                     }
        //                     $("#divloading").addClass("d-none").removeClass("d-flex");
        //                     $("#funcionario").trigger("chosen:updated");
        //                     $("#formmain").removeClass("was-validated");
        //                     $("#funcionario_chosen").removeClass("is-valid");
        //                     $("#funcionario_chosen").removeClass("is-invalid");

        //                 },
        //                 error: function(xhr, textStatus, errorThrown)
        //                 {
        //                     alert("¡Error al cargar el funcionario!");
        //                 }
        //             });
        //             // Fin Ajax
        //         }
        //         else
        //         {
        //             $("#funcionario").empty();
        //             $("#funcionario").append("<option value=''>Funcionario</option>");
        //             $("#divloading").addClass("d-none").removeClass("d-flex");
        //             $("#funcionario").trigger("chosen:updated");
        //         } 
        //     });
        // });

        // $("#funcionario").change(function(){
        //     if($("#funcionario").val() != "")
        //     {
        //         if($("#funcionario_chosen").hasClass("is-invalid") === true)
        //         {
        //             $("#funcionario_chosen").removeClass("is-invalid");
        //             $("#funcionario_chosen").addClass("is-valid");
        //         }
        //     }
        //     else
        //     {
        //         if($("#funcionario_chosen").hasClass("is-valid") === true)
        //         {
        //             $("#funcionario_chosen").removeClass("is-valid");
        //             $("#funcionario_chosen").addClass("is-invalid");
        //         }
        //     }
        // });

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