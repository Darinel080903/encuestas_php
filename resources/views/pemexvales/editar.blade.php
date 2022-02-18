@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-pen"></i> Editar dotación</h3>
                    </div>
                    <div class="card-body">     
                        <form class="needs-validation" method="POST" action="{{url('/pemexvales/'.$datos->idvale)}}" novalidate>
                        @method('PUT')
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{date('d/m/Y', strtotime($datos->fecha))}}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="auto">Autos / Activos / Resguardo:</label>
                                    <select class="form-control" id="auto" name="auto" required>
                                        <option value="">Auto</option>
                                        @foreach ($autos as $item)
                                            @if ($datos->fkauto == $item->idauto)
                                                <option value="{{$item->idauto}}" selected>{{$item->placa}}</option>
                                            @else
                                                <option value="{{$item->idauto}}">{{$item->placa}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>auto</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="funcionario">Funcionarios:</label>
                                    <select class="form-control" id="funcionario" name="funcionario" required>
                                        <option value="">Funcionario</option>
                                        @foreach ($funcionarios as $item)
                                            @if ($datos->fkfuncionario == $item->idfuncionario)
                                                <option value="{{$item->idfuncionario}}" selected>{{$item->nombre.' '.$item->peterno.' '.$item->materno}}</option>
                                            @else
                                                <option value="{{$item->idfuncionario}}">{{$item->nombre.' '.$item->peterno.' '.$item->materno}}</option>
                                            @endif
                                        @endforeach 
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>funcionario</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-2 mb-0">
                                    <label for="kmini">Km inicial:</label>
                                    <input type="text" class="form-control" id="kmini" name="kmini" placeholder="Km inicial" maxlength="11" value="{{$datos->kmini}}"/>
                                </div>
                                <div class="form-group col-md-2 mb-0">
                                    <label for="kmfin">Km final:</label>
                                    <input type="text" class="form-control" id="kmfin" name="kmfin" placeholder="Km final" maxlength="11" value="{{$datos->kmfin}}"/>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-header">
                                    Desglose de los folios
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="factura">Donaciones:</label>
                                            <select class="form-control" id="factura" name="factura">
                                                <option value="">Donación</option>
                                                @foreach ($facturas as $item)
                                                    @if (old('factura') == $item->idfactura)
                                                        <option value="{{$item->idfactura}}" selected>{{'Fecha: '.date('d/m/Y', strtotime($item->fecha)).' - Número: '.$item->numero}}</option>
                                                    @else
                                                        <option value="{{$item->idfactura}}">{{'Fecha: '.date('d/m/Y', strtotime($item->fecha)).' - Número: '.$item->numero}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="montofactura">Monto donación:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-gas-pump"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="montofactura" name="montofactura" placeholder="Monto" maxlength="11" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="saldofactura">Saldo donación:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-gas-pump"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="saldofactura" name="saldofactura" placeholder="Saldo" maxlength="11" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="disponible">Disponible:</label>
                                            <input type="text" class="form-control" id="disponible" name="disponible" placeholder="No." maxlength="11" readonly/>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="factura">Conceptos:</label>
                                            <select class="form-control" id="concepto" name="concepto">
                                                <option value="">Concepto</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="folioini">Folio inicial:</label>
                                            <input type="text" class="form-control" id="folioini" name="folioini" placeholder="Inicio" maxlength="11"/>
                                        </div>
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="foliofin">Folio final:</label>
                                            <input type="text" class="form-control" id="foliofin" name="foliofin" placeholder="Final" maxlength="11"/>
                                        </div>
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="desglosenumero">Unidades:</label>
                                            <input type="text" class="form-control" id="folionumero" name="folionumero" placeholder="No." maxlength="11"/>
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desgloseunitario">Lt vale::</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-gas-pump"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="foliounitario" name="foliounitario" placeholder="Unitario" maxlength="11" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desglosemonto">Total Lt:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-gas-pump"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="foliomonto" name="foliomonto" placeholder="Total" maxlength="11"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="boton">&nbsp; Agregar</label>
                                            <a class="btn btn-outline-danger btn-block" href="javascript:FolioGuardar();"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="DesgloseTabla">
                                            <thead>
                                                <tr>
                                                    <th class="col-3">Donación</th>
                                                    <th class="col-3">Concepto</th>
                                                    <th class="col-1">Unidades</th>
                                                    <th class="col-2">Precio</th>
                                                    <th class="col-2">Total</th>
                                                    <th class="col-1">Eliminar</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group offset-md-9 col-md-2 pl-0 mr-2">
                                    <label for="monto">Total Lt:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend"><i class="fas fa-gas-pump"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="monto" name="monto" placeholder="Gran Total" maxlength="15" value="{!! number_format((float)($datos->monto)) !!}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="recibe">Recibe:</label>    
                                    <input type="text" class="form-control" id="recibe" name="recibe" placeholder="Recibe" maxlength="250" value="{{$datos->recibe}}"/>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="observacion">Observaciones:</label>    
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="2" placeholder="Observaciones">{{$datos->observacion}}</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{$page ?? ''}}">
                            <input type="hidden" name="vfecha" value="{{$vfecha ?? ''}}">
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="hidden" id="vdetalle" name="vdetalle" value="{{$folios ?? ''}}">
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/pemexvales?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var Detalle = [];

        var data = $("#vdetalle").val();
        $.each(JSON.parse(data), function(i, item){
            var fecha = item.fecha;
            var newfecha = fecha.replace("-", "/");
            var d = new Date(newfecha);
            var datestring = ("0" + d.getDate()).slice(-2)  + "/" + ("0"+(d.getMonth()+1)).slice(-2) + "/" + d.getFullYear()

            Detalle.push({factura:item.fkfactura, facturafolio:'Fecha: '+datestring+' - Número: '+item.folio, concepto:item.fkdesglose, conceptotexto:item.concepto, folioini:item.folioini, foliofin:item.foliofin, numero:item.numero, unitario:parseFloat(item.unitario), monto:parseFloat(item.monto), tipo:"S"});
        });
        $("#vdetalle").val("");
        $("#vdetalle").val(JSON.stringify(Detalle));
        MostrarDesgloseTabla();

        $('#fecha').datepicker({
            uiLibrary: 'bootstrap4',
            locale: 'es-es',
            format: 'dd/mm/yyyy'
        });

        $(function(){
            $("#auto").change(function(){
                var Auto = event.target.value;
                if(Auto)
                {
                    var url = "{{url('/vales/autos/idauto')}}";
                    url = url.replace("idauto", Auto);
                    // Ini Ajax
                    $("#divloading").addClass("d-flex").removeClass("d-none");
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            $("#funcionario").empty();
                            $("#funcionario").append("<option value=''>Funcionario</option>");
                            for(let i = 0; i< response.length; i++)
                            {
                                $("#funcionario").append("<option value='"+response[i].idfuncionario+"'>"+response[i].nombre+" "+response[i].paterno+" "+response[i].materno+"</option>"); 
                            }
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el funcionario!");
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                        }
                    });
                    // Fin Ajax 
                }
                else
                {
                    $("#funcionario").empty();
                    $("#funcionario").append("<option value=''>Funcionario</option>");
                }
            });
        });

        $(function(){
            $("#kmini").validCampoFranz("0123456789");
            $("#kmfin").validCampoFranz("0123456789");
            $("#folioini").validCampoFranz("0123456789");
            $("#foliofin").validCampoFranz("0123456789");
    	});

        $(function(){
            $("#factura").change(function(){
                var Factura = event.target.value;
                if(Factura)
                {
                    var url = "{{url('/pemexvales/conceptos/idfactura')}}";
                    url = url.replace("idfactura", Factura);
                    // Ini Ajax
                    $("#divloading").addClass("d-flex").removeClass("d-none");
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            $("#concepto").empty();
                            $("#concepto").append("<option value=''>Concepto</option>");
                            for(let i = 0; i< response.length; i++)
                            {
                                $("#concepto").append("<option value='"+response[i].iddesglose+"'>"+response[i].concepto+"</option>"); 
                            }
                            $("#disponible").val("");
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                            CargarMonto(Factura);
                            Limpiar();
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el concepto!");
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#montofactura").val("");
                    $("#saldofactura").val(""); 
                    $("#concepto").empty();
                    $("#concepto").append("<option value=''>Concepto</option>");
                    Limpiar();
                }  
            });
        });

        function CargarMonto(IdFactura)
        {
            var url = "{{url('/pemexvales/montos/idfactura')}}";
            url = url.replace("idfactura", IdFactura);
            // Ini Ajax
            $("#divloading").addClass("d-flex").removeClass("d-none");
            $.ajax({type:"get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:url,
                dataType: "json",
                success: function(response, textStatus, xhr)
                {
                    $("#montofactura").val("");
                    $("#montofactura").val(numberWithCommas(parseFloat(response.monto)));
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                    CargarSaldo(IdFactura);
                },
                error: function(xhr, textStatus, errorThrown)
                {
                    alert("¡Error al cargar los montos de la factura!");
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                }
            });
            // Fin Ajax
        }

        function CargarSaldo(IdFactura)
        {
            var url = "{{url('/pemexvales/saldos/idfactura')}}";
            url = url.replace("idfactura", IdFactura);
            // Ini Ajax
            $("#divloading").addClass("d-flex").removeClass("d-none");
            $.ajax({type:"get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:url,
                dataType: "json",
                success: function(response, textStatus, xhr)
                {
                    $("#saldofactura").val("");
                    var vmonto = $("#montofactura").val();
                    vmonto = parseFloat(vmonto.replace(",", ""));
                    var vsaldo = parseFloat(response);
                    saldototal = vmonto - vsaldo;
                    $("#saldofactura").val(numberWithCommas(parseFloat(saldototal)));
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                },
                error: function(xhr, textStatus, errorThrown)
                {
                    alert("¡Error al cargar los montos de la factura!");
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                }
            });
            // Fin Ajax  
        }

        function Limpiar()
        {
            $("#disponible").val("");
            $("#concepto").val("");
            $("#folioini").val("");
            $("#foliofin").val("");
            $("#folionumero").val("");
            $("#foliounitario").val("");
            $("#foliomonto").val("");
        }

        $(function(){
            $("#concepto").change(function(){
                var Desglose = event.target.value;
                if(Desglose)
                {
                    var url = "{{url('/pemexvales/unidades/iddesglose')}}";
                    url = url.replace("iddesglose", Desglose);
                    // Ini Ajax
                    $("#divloading").addClass("d-flex").removeClass("d-none");
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            var disponible = 0;
                            console.log(parseInt(CalcularDisponibleLista(Desglose)));
                            disponible = parseInt(response) - parseInt(CalcularDisponibleLista(Desglose));
                            $("#disponible").val("");
                            $("#disponible").val(disponible);
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                            CargarUnitario(Desglose);
                            LimpiarFolios();
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar las unidades disponibles!");
                            $("#divloading").addClass("d-none").removeClass("d-flex");
                        }
                    });
                    // Fin Ajax    
                }
                else
                {
                    Limpiar();
                }
            });
        });

        function CalcularDisponibleLista(Concepto)
        {
            var total = 0;
            $.each(Detalle, function(key, value)
            {
                if(Concepto == Detalle[key].concepto && Detalle[key].tipo == "N")
                {
                    total = parseInt(total) + parseInt(Detalle[key].numero);
                }
            });
            return total;
        }

        function CargarUnitario(Desglose)
        {
            var url = "{{url('/pemexvales/unitarios/iddesglose')}}";
            url = url.replace("iddesglose", Desglose);
            // Ini Ajax
            $("#divloading").addClass("d-flex").removeClass("d-none");
            $.ajax({type:"get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:url,
                dataType: "json",
                success: function(response, textStatus, xhr)
                {
                    $("#foliounitario").val("");
                    $("#foliounitario").val(parseFloat(response));
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                },
                error: function(xhr, textStatus, errorThrown)
                {
                    alert("¡Error al cargar el precio unitario!");
                    $("#divloading").addClass("d-none").removeClass("d-flex");
                }
            });
            // Fin Ajax
        }

        function LimpiarFolios()
        {
            $("#folioini").val("");
            $("#foliofin").val("");
            $("#folionumero").val("");
            $("#foliomonto").val("");
        }

        $("#folionumero").click(function(){
            var ini = parseInt($("#folioini").val());
            var fin = parseInt($("#foliofin").val());
            fin = fin + 1;
            if(ini && fin)
            {
                if(fin >= ini)
                {
                    $("#folionumero").val(fin-ini);
                    $("#foliomonto").val("");
                }
                else
                {
                    $("#folionumero").val("");
                    $("#foliomonto").val("");
                }
            }
            else
            {
                $("#folionumero").val("");
            }
        });

        $("#foliomonto").click(function(){
            var num = $("#folionumero").val();
            var uni = $("#foliounitario").val();
            var total = 0;
            if(num && uni)
            {
                total = num * parseFloat(uni);
                $("#foliomonto").val(parseFloat(total));
            }
            else
            {
                $("#foliomonto").val('');
            }
        });

        $("#concepto").change(function(){
            if($("#concepto").val() != "" && $("#concepto").hasClass("is-invalid") === true)
            {
                $("#concepto").removeClass("is-invalid");
                $("#concepto").addClass("is-valid");    
            }
        });
        $("#folioini").keyup(function(){
            if($("#folioini").val() != "" && $("#folioini").hasClass("is-invalid") === true)
            {
                $("#folioini").removeClass("is-invalid");
                $("#folioini").addClass("is-valid");    
            }
        });
        $("#foliofin").keyup(function(){
            if($("#foliofin").val() != "" && $("#foliofin").hasClass("is-invalid") === true)
            {
                $("#foliofin").removeClass("is-invalid");
                $("#foliofin").addClass("is-valid");    
            }
        });
        $("#folionumero").keyup(function(){
            if($("#folionumero").val() != "" && $("#folionumero").hasClass("is-invalid") === true)
            {
                $("#folionumero").removeClass("is-invalid");
                $("#folionumero").addClass("is-valid");    
            }
        });
        $("#folionumero").click(function(){
            if($("#folionumero").val() != "" && $("#folionumero").hasClass("is-invalid") === true)
            {
                $("#folionumero").removeClass("is-invalid");
                $("#folionumero").addClass("is-valid");    
            }
        });
        $("#foliounitario").keyup(function(){
            if($("#foliounitario").val() != "" && $("#foliounitario").hasClass("is-invalid") === true)
            {
                $("#foliounitario").removeClass("is-invalid");
                $("#foliounitario").addClass("is-valid");    
            }
        });
        $("#foliounitario").click(function(){
            if($("#foliounitario").val() != "" && $("#foliounitario").hasClass("is-invalid") === true)
            {
                $("#foliounitario").removeClass("is-invalid");
                $("#foliounitario").addClass("is-valid");    
            }
        });
        $("#foliomonto").keyup(function(){
            if($("#foliomonto").val() != "" && $("#foliomonto").hasClass("is-invalid") === true)
            {
                $("#foliomonto").removeClass("is-invalid");
                $("#foliomonto").addClass("is-valid");    
            }
        });
        $("#foliomonto").click(function(){
            if($("#foliomonto").val() != "" && $("#foliomonto").hasClass("is-invalid") === true)
            {
                $("#foliomonto").removeClass("is-invalid");
                $("#foliomonto").addClass("is-valid");    
            }
        });

        function FolioGuardar()
        {
            var valida = true;
            var vfactura = $("#factura").val();
            var vfacturafolio = $("#factura option:selected").text();
            var vdisponible = $("#disponible").val();
            var vconcepto = $("#concepto").val();
            var vconceptotexto = $("#concepto option:selected").text();
            var vfolioini = $("#folioini").val();
            var vfoliofin = $("#foliofin").val();
            var vfolionumero = $("#folionumero").val();
            var vfoliounitario = $("#foliounitario").val();
            var vfoliomonto = $("#foliomonto").val();
            
            if(vconcepto == "")
            {
                $("#concepto").addClass("is-invalid");
                valida = false;
            }
            if(vfolioini == "")
            {
                $("#folioini").addClass("is-invalid");
                valida = false;
            }
            if(vfoliofin == "")
            {
                $("#foliofin").addClass("is-invalid");
                valida = false;
            }
            if(vfolionumero == "" || vfolionumero == 0 || parseInt(vfolionumero) > parseInt(vdisponible))
            {
                $("#folionumero").addClass("is-invalid");
                valida = false;
            }
            if(vfoliounitario == "")
            {
                $("#foliounitario").addClass("is-invalid");
                valida = false;
            }
            if(vfoliomonto == "")
            {
                $("#foliomonto").addClass("is-invalid");
                valida = false;
            } 
            
            if(valida == true)
            {
                Detalle.push({factura:vfactura, facturafolio:vfacturafolio, concepto:vconcepto, conceptotexto:vconceptotexto, folioini:vfolioini, foliofin:vfoliofin, numero:vfolionumero, unitario:parseFloat(vfoliounitario), monto:parseFloat(vfoliomonto), tipo:"N"});    
                $("#vdetalle").val("");
                $("#vdetalle").val(JSON.stringify(Detalle));
                MostrarDesgloseTabla();
                MostrarMontoTotal();

                $("#disponible").val("");
                $("#concepto").val("");
                $("#folioini").val("");
                $("#foliofin").val("");
                $("#folionumero").val("");
                $("#foliounitario").val("");
                $("#foliomonto").val("");

                if($("#disponible").hasClass("is-valid") === true)
                {
                    $("#disponible").removeClass("is-valid");
                }
                if($("#concepto").hasClass("is-valid") === true)
                {
                    $("#concepto").removeClass("is-valid");
                }
                if($("#folioini").hasClass("is-valid") === true)
                {
                    $("#folioini").removeClass("is-valid");
                }
                if($("#foliofin").hasClass("is-valid") === true)
                {
                    $("#foliofin").removeClass("is-valid");
                }
                if($("#folionumero").hasClass("is-valid") === true)
                {
                    $("#folionumero").removeClass("is-valid");
                }
                if($("#foliounitario").hasClass("is-valid") === true)
                {
                    $("#foliounitario").removeClass("is-valid");
                }
                if($("#foliomonto").hasClass("is-valid") === true)
                {
                    $("#foliomonto").removeClass("is-valid");
                }
            }
        }

        function MostrarDesgloseTabla()
        {         
            $("#DesgloseTabla").empty();
            $("#DesgloseTabla").append("<thead><tr><th class='col-3'>Donación</th><th class='col-3'>Concepto</th><th class='col-1'>Unidades</th><th class='col-2'>Unitario</th><th class='col-2'>Total</th><th class='col-1'>Eliminar</th></tr></thead>"); 
            $("#DesgloseTabla").append("<tbody>");
            $.each(Detalle, function(key, value)
            {
                $("#DesgloseTabla").append("<tr><td class='align-middle'>"+Detalle[key].facturafolio+"</td><td class='align-middle'>"+Detalle[key].conceptotexto+"</td><td class='align-middle text-center'>"+Detalle[key].numero+"</td><td class='align-middle'>"+numberWithCommas(Detalle[key].unitario)+"</td><td class='align-middle'>"+numberWithCommas(Detalle[key].monto)+"</td><td><a class='btn btn-outline-danger btn-block' href='javascript:DesgloseEliminar("+key+");'><i class='fas fa-minus'></i></a></td></tr>");
            });
            $("#DesgloseTabla").append("</tbody>");
        }

        function MostrarMontoTotal()
        {
            var total = 0;
            $.each(Detalle, function(key, value)
            {
                total = parseFloat(total) + parseFloat(Detalle[key].monto);
            });
            $("#monto").val(numberWithCommas(total));
        }

        function DesgloseEliminar(i)
        {
            Detalle.splice(i, 1);
            $("#vdetalle").val("");
            $("#vdetalle").val(JSON.stringify(Detalle));
            MostrarMontoTotal();
            MostrarDesgloseTabla();
            Limpiar();   
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