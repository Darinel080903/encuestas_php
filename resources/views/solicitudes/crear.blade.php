@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card cardborde">
                    <div class="card-header justify-content-between align-items-centr text-center encabezadoform">
                        <h3 class="headerlistatitulo"><i class="fas fa-save"></i> Nueva solicitud</h3>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{url('/solicitudes')}}" novalidate>
                        @csrf
                            
                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="fecha">Fecha:</label>
                                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" aria-label="Fecha" placeholder="Fecha" value="{{ date("d/m/Y") }}" readonly/>
                                </div>
                                <div class="invalid-feedback">
                                    ¡La <strong>fecha</strong> es un campo requerido!
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="folio">Folio:</label>
                                    <input type="text" class="form-control" id="folio" name="folio" value="{{$folio}}" maxlength="11" placeholder="folio" readonly>                                   
                                </div>  
                            </div>

                            <div class="form-row">                               

                                <div class="form-group col-md-3">
                                    <label for="partida">Partidas:</label>
                                    <select class="form-control" id="partida" name="partida" required>
                                        <option value="">partida</option>
                                        @foreach ($partidas as $item)
                                            @if (old('partida') == $item->idpartida)
                                                <option value="{{$item->idpartida}}" selected>{{$item->clave.' '.$item->partida}}</option>
                                            @else
                                                <option value="{{$item->idpartida}}">{{$item->clave.' '.$item->partida}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>partida</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="area">Area solicitante:</label>
                                    <select class="form-control" id="area" name="area">
                                        <option value="">area</option>
                                        @foreach ($areas as $item)
                                            @if (old('area') == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('solicitudes.crearoption',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="areacargo">Area cargo:</label>
                                    <select class="form-control" id="areacargo" name="areacargo">
                                        <option value="">area</option>
                                        @foreach ($areas as $item)
                                            @if (old('areacargo') == $item->idarea)
                                                <option value="{{$item->idarea}}" selected>{{$item->area}}</option>
                                            @else
                                                <option value="{{$item->idarea}}">{{$item->area}}</option>
                                            @endif
                                            @if(count($item->childs))
                                                @include('solicitudes.crearoptionacargo',['childs' => $item->childs])
                                            @endif
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="clave">Clave:</label>
                                    <input type="text" class="form-control @error('clave') is-invalid @enderror" id="clave" name="clave" value="{{old('clave')}}" maxlength="25" placeholder="clave" required readonly>
                                    <div class="invalid-feedback">
                                        ¡La <strong>clave</strong> es un campo requerido!
                                    </div>
                                </div>                               
                            </div>

                            <div class="form-row d-none">                               
                                                                
                                <div class="form-group col-md-3 mb-0">
                                    <label for="disponible">Disponible:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="disponible" name="disponible" value="{{old('disponible')}}" placeholder="disponible" maxlength="25"/>                                       
                                    </div>                                    
                                </div>
                                                                                               
                                <div class="form-group col-md-6">
                                    <label for="otorga">Otorga:</label>
                                    <select class="form-control form-control-chosen" id="otorga" name="otorga">
                                        <option value="">funcionario</option>
                                        @foreach ($otorga as $itemfuncionario)
                                            @if (old('otorga') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>   
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="clase">Clase:</label>
                                    <select class="form-control" id="clase" name="clase" required>
                                        <option value="">clase</option>
                                        @foreach ($clases as $item)
                                            @if (old('clase') == $item->idclase)
                                                <option value="{{$item->idclase}}" selected>{{$item->clase}}</option>
                                            @else
                                                <option value="{{$item->idclase}}">{{$item->clase}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡La <strong>clase</strong> es un campo requerido!
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="grupo">Grupo:</label>
                                    <select class="form-control" id="grupo" name="grupo" disabled>
                                        <option value="">grupo</option>
                                        @foreach ($grupos as $item)
                                            @if (old('grupo') == $item->idgrupo)
                                                <option value="{{$item->idgrupo}}" selected>{{$item->grupo}}</option>
                                            @else
                                                <option value="{{$item->idgrupo}}">{{$item->grupo}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>grupo</strong> es un campo requerido!
                                    </div>
                                </div>
                               
                            </div> 
                            <div class="form-row">

                                <div class="form-group col-md-8">
                                    <label for="proveedor">Proveedor:</label>
                                    <select class="form-control" id="proveedor" name="proveedor" required>
                                        <option value="">proveedor</option>
                                        @foreach ($proveedores as $item)
                                            @if (old('proveedor') == $item->idproveedor)
                                                <option value="{{$item->idproveedor}}" selected>{{$item->proveedor}}</option>
                                            @else
                                                <option value="{{$item->idproveedor}}">{{$item->proveedor}}</option>
                                            @endif
                                        @endforeach  
                                    </select>
                                    <div class="invalid-feedback">
                                        ¡El <strong>proveedor</strong> es un campo requerido!
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="factura">Facturas:</label>
                                    <input type="text" class="form-control @error('factura') is-invalid @enderror" id="factura" name="factura" value="{{old('factura')}}" maxlength="11" placeholder="factura" required>
                                    <div class="invalid-feedback">
                                        ¡La <strong>factura</strong> es un campo requerido!
                                    </div>
                                </div>
                             
                                <div class="form-group col-md-2">
                                    <label for="fechafactura">Fecha factura:</label>
                                    <input type="text" class="form-control @error('fechafactura') is-invalid @enderror" id="fechafactura" name="fechafactura" aria-label="fechafactura" placeholder="fechafactura" value="{{ old('fechafactura') }}" readonly/>
                                </div>                     

                            </div> 
                            
                            <div class="card border-success mb-2 d-none" id="desglose">
                                <div class="card-header">
                                    Desglose
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                       
                                        <div class="form-group col-md-1">
                                            <label for="desglosecantidad">Cantidad:</label>
                                            <input type="text" class="form-control" id="desglosecantidad" name="desglosecantidad" maxlength="11" placeholder="cantidad" >                                            
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="desgloseunidad">Unidad:</label>
                                            <select class="form-control" id="desgloseunidad" name="desgloseunidad">
                                                <option value="">unidad</option>
                                                @foreach ($unidades as $item)
                                                    @if (old('desgloseunidad') == $item->idunidad)
                                                        <option value="{{$item->idunidad}}" selected>{{$item->unidad}}</option>
                                                    @else
                                                        <option value="{{$item->idunidad}}">{{$item->unidad}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>                                            
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="desglosedescripcion">Descripcion:</label>
                                            <input type="text" class="form-control" id="desglosedescripcion" name="desglosedescripcion" maxlength="25" placeholder="descripcion">                                           
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desgloseunitario">Precio:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="desgloseunitario" name="desgloseunitario" placeholder="precio" maxlength="11"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2 mb-0">
                                            <label for="desglosemonto">Total:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="desglosemonto" name="desglosemonto" placeholder="total" maxlength="11"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-1 mb-0">
                                            <label for="boton">&nbsp; Agregar</label>
                                            <a class="btn btn-outline-danger btn-block" href="javascript:DesgloseGuardar();"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="DesgloseTabla">
                                            <thead>
                                                <tr>
                                                    <th class="col-1">Cantidad</th>
                                                    <th class="col-2">Unidad</th>
                                                    <th class="col-4">Texto</th> 
                                                    <th class="col-2">Precio</th>
                                                    <th class="col-2">Total</th>
                                                    <th class="col-1">Eliminar</th>
                                                </tr>
                                            </thead>
                                        </table>                                       
                                    </div>                                   
                                </div>                                
                            </div>
                                                                                    
                            <div class="card border-success mb-2 d-none" id="inmuebles">
                                <div class="card-header">
                                    Inmuebles
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                       
                                        <div class="form-group col-md-12">
                                            <label for="inmuebledescripcion">Descripción:</label>
                                            <input type="text" class="form-control @error('inmuebledescripcion') is-invalid @enderror" id="inmuebledescripcion" name="inmuebledescripcion" value="{{old('inmuebledescripcion')}}" maxlength="250" placeholder="descripcion">
                                            <div class="invalid-feedback">
                                                ¡La <strong>descripcion</strong> es un campo requerido!
                                            </div>
                                        </div>                                                                               
                                        <div class="form-group col-md-4">
                                            <label for="inmueble">Inmueble:</label>
                                            <select class="form-control @error('inmueble') is-invalid @enderror" id="inmueble" name="inmueble">
                                                <option value="">imnueble</option>
                                                @foreach ($inmuebles as $item)
                                                    @if (old('inmueble') == $item->idinmueble)
                                                        <option value="{{$item->idinmueble}}" selected>{{$item->inmueble}}</option>
                                                    @else
                                                        <option value="{{$item->idinmueble}}">{{$item->inmueble}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>  
                                            <div class="invalid-feedback">
                                                ¡El <strong>inmueble</strong> es un campo requerido!
                                            </div>                                         
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inmuebleservicio">Servicio:</label>    
                                            <textarea class="form-control" name="inmuebleservicio" id="inmuebleservicio" cols="30" rows="2" placeholder="servicio">{{old('inmuebleservicio')}}</textarea>
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label for="fechainmueble">Fecha servicio inmueble:</label>
                                            <input type="text" class="form-control @error('fechainmueble') is-invalid @enderror" id="fechainmueble" name="fechainmueble" aria-label="fechainmueble" placeholder="fechaservicio" value="{{ old('fechainmueble') }}" readonly/>
                                        </div>                                       
                                    </div>
                                </div>                     
                            </div>

                            <div class="card border-success mb-2 d-none" id="muebles">
                                <div class="card-header">
                                    Muebles
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                       
                                        <div class="form-group col-md-12">
                                            <label for="muebledescripcion">Descripción:</label>
                                            <input type="text" class="form-control @error('muebledescripcion') is-invalid @enderror" id="muebledescripcion" name="descripcion" value="{{old('muebledescripcion')}}" maxlength="250" placeholder="descripcion">
                                            <div class="invalid-feedback">
                                                ¡La <strong>descripcion</strong> es un campo requerido!
                                            </div>
                                        </div>                                       
                                        <div class="form-group col-md-4">
                                            <label for="mueble">Muebles:</label>
                                            <select class="form-control" id="mueble" name="mueble">
                                                <option value="">mueble</option>
                                                @foreach ($muebles as $item)
                                                    @if (old('muebles') == $item->idmueble)
                                                        <option value="{{$item->idmueble}}" selected>{{$item->mueble}}</option>
                                                    @else
                                                        <option value="{{$item->idmueble}}">{{$item->mueble}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>
                                            <div class="invalid-feedback">
                                                ¡El <strong>mueble</strong> es un campo requerido!
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="razon">Razones:</label>
                                            <select class="form-control" id="razon" name="razon">
                                                <option value="">razon</option>
                                                @foreach ($razones as $item)
                                                    @if (old('razones') == $item->idrazon)
                                                        <option value="{{$item->idrazon}}" selected>{{$item->razon}}</option>
                                                    @else
                                                        <option value="{{$item->idrazon}}">{{$item->razon}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>
                                            <div class="invalid-feedback">
                                                ¡La <strong>razon</strong> es un campo requerido!
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="modelo">Modelo:</label>
                                            <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{old('modelo')}}" maxlength="11" placeholder="modelo">
                                            <div class="invalid-feedback">
                                                ¡El <strong>modelo</strong> es un campo requerido!
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="muebleservicio">Servicio:</label>    
                                            <textarea class="form-control" name="muebleservicio" id="muebleservicio" cols="30" rows="2" placeholder="servicio">{{old('muebleservicio')}}</textarea>
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label for="fechaactivo">Fecha servicio Activo:</label>
                                            <input type="text" class="form-control @error('fechaactivo') is-invalid @enderror" id="fechaactivo" name="fechaactivo" aria-label="fechaactivo" placeholder="fechaservicio" value="{{ old('fechaactivo') }}" readonly/>
                                        </div>                                       
                                    </div>
                                </div>                     
                            </div>

                            <div class="card border-success mb-2 d-none" id="vehiculo">
                                <div class="card-header">
                                    Vehiculos
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                       
                                        <div class="form-group col-md-12">
                                            <label for="vehiculodescripcion">Descripción:</label>
                                            <input type="text" class="form-control @error('vehiculodescripcion') is-invalid @enderror" id="vehiculodescripcion" name="vehiculodescripcion" value="{{old('vehiculodescripcion')}}" maxlength="250" placeholder="descripcion">
                                            <div class="invalid-feedback">
                                                ¡La <strong>descripcion</strong> es un campo requerido!
                                            </div>
                                        </div>                                                                                                                       
                                        <div class="form-group col-md-3">
                                            <label for="auto">Vehiculo:</label>
                                            <select class="form-control" id="auto" name="auto">
                                                <option value="">numero</option>
                                                @foreach ($autos as $item)
                                                    @if (old('numero') == $item->idauto)
                                                        <option value="{{$item->idauto}}" selected>{{$item->numero}}</option>
                                                    @else
                                                        <option value="{{$item->idauto}}">{{$item->numero}}</option>
                                                    @endif
                                                @endforeach  
                                            </select>                                            
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="placas">Placas:</label>
                                            <input type="text" class="form-control @error('placas') is-invalid @enderror" id="placas" name="placas" value="{{old('placas')}}" maxlength="11" placeholder="placas">
                                            <div class="invalid-feedback">
                                                ¡La <strong>placa</strong> es un campo requerido!
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="modelovehiculo">Modelo:</label>
                                            <input type="text" class="form-control @error('modelovehiculo') is-invalid @enderror" id="modelovehiculo" name="modelovehiculo" value="{{old('modelovehiculo')}}" maxlength="11" placeholder="modelo">
                                            <div class="invalid-feedback">
                                                ¡El <strong>modelo</strong> es un campo requerido!
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="tipo">Tipo:</label>
                                            <input type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{old('tipo')}}" maxlength="11" placeholder="tipo">
                                            <div class="invalid-feedback">
                                                ¡El <strong>tipo</strong> es un campo requerido!
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="servicio">Servicio:</label>    
                                            <textarea class="form-control" name="servicio" id="servicio" cols="30" rows="2" placeholder="servicio">{{old('servicio')}}</textarea>
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label for="fechaservicio">Fecha servicio:</label>
                                            <input type="text" class="form-control @error('fechaservicio') is-invalid @enderror" id="fechaservicio" name="fechaservicio" aria-label="fechaservicio" placeholder="fechaservicio" value="{{ old('fechaservicio') }}" readonly/>
                                        </div>                                       
                                    </div>
                                </div>                     
                            </div>

                            <div class="form-row" id="contenido">
                               
                                <div class="form-group col-md-3">
                                    <label for="subtotal">Subtotal:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="subtotal"  name="subtotal"  placeholder="subtotal" maxlength="11" readonly/>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label for="iva">Iva:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">%</span>
                                        </div>
                                        <input type="text" class="form-control" id="iva" name="iva" placeholder="iva" maxlength="11" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ajuste">Ajuste:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="ajuste" name="ajuste" placeholder="ajuste" maxlength="11" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total">Total:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="validatedInputGroupPrepend">$</span>
                                        </div>
                                        <input type="text" class="form-control" id="total" name="total" placeholder="total" maxlength="11" readonly/>
                                    </div>
                                </div>

                            </div> 
                            
                            <div class="form-row">
                                
                                <div class="form-group col-md-12">
                                    <label for="concepto">Concepto de ajuste:</label>    
                                    <textarea class="form-control" name="concepto" id="concepto" cols="30" rows="2" placeholder="concepto de ajuste">{{old('concepto')}}</textarea>
                                </div>
                            </div>

                            <div class="form-row">                               
                               
                                <div class="form-group col-md-4">
                                    <label for="elabora">Elabora:</label>
                                    <select class="form-control form-control-chosen" id="elabora" name="elabora">
                                        <option value="">Elabora</option>
                                        @foreach ($elabora as $itemfuncionario)
                                            @if (old('elabora') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>   
                                <div class="form-group col-md-4">
                                    <label for="solicita">Solícita:</label>
                                    <select class="form-control form-control-chosen" id="solicita" name="solicita">
                                        <option value="">Solícita</option>
                                        @foreach ($solicita as $itemfuncionario)
                                            @if (old('solicita') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>   
                                <div class="form-group col-md-4">
                                    <label for="autoriza">Autoriza:</label>
                                    <select class="form-control form-control-chosen" id="autoriza" name="autoriza">
                                        <option value="">Autoriza</option>
                                        @foreach ($autoriza as $itemfuncionario)
                                            @if (old('autoriza') == $itemfuncionario->idfuncionario)
                                                <option value="{{$itemfuncionario->idfuncionario}}" selected>{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @else
                                                <option value="{{$itemfuncionario->idfuncionario}}">{{$itemfuncionario->nombre.' '.$itemfuncionario->paterno.' '.$itemfuncionario->materno}}</option>
                                            @endif
                                        @endforeach  
                                    </select> 
                                </div>  
                                <div class="form-group col-md-12">
                                    <label for="observacion">Observación:</label>    
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="2" placeholder="observacion">{{old('observacion')}}</textarea>
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
                            <input type="hidden" name="vbusqueda" value="{{$vbusqueda ?? ''}}">
                            <input type="text" id="vdetalle" name="vdetalle">
                            
                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-save"></i> Guardar</button>
                            <a class="btn btn-outline-danger" href="{{url('/solicitudes?page='.$page.'&vfecha='.$vfecha.'&vbusqueda='.$vbusqueda)}}"><i class="fas fa-sign-out-alt fa-rotate-180"></i> Regresar</a>
                            
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
            $('#fecha').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });
            $('#fechafactura').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });     
            $('#fechainmueble').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });
            $('#fechaactivo').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });       
            $('#fechaservicio').datepicker({
                uiLibrary: 'bootstrap4',
                locale: 'es-es',
                format: 'dd/mm/yyyy'
            });          
            bsCustomFileInput.init();
        });

        $(document).ready(function(){
            $(".form-control-chosen").chosen();
            //$("#elabora_chosen").addClass("chosendisable");
            $('#elabora').prop('disabled', true).trigger("chosen:updated");
        });
        
        $(function(){
            $("#desglosecantidad").validCampoFranz("0123456789");	
    		$("#desgloseunitario").validCampoFranz(".0123456789");	
            $("#desglosemonto").validCampoFranz(".0123456789");
            $("#disponible").validCampoFranz(".0123456789");		
            $("#subtotal").validCampoFranz("0123456789");	
            $("#iva").validCampoFranz(".0123456789");	
            $("#ajuste").validCampoFranz(".0123456789");	
            $("#total").validCampoFranz(".0123456789");	
    	});

        $("#desglosemonto").click(function(){
            var num = $("#desglosecantidad").val();
            var uni = $("#desgloseunitario").val();
            var total = 0;
            if(num && uni)
            {
                total = num * parseFloat(uni).toFixed(2);
                $("#desglosemonto").val(parseFloat(total).toFixed(2));
            }
            else
            {
                $("#desglosemonto").val('');
            }
        });
                     
        $("#desglosecantidad").keyup(function(){
            if($("#desglosecantidad").val() != "" && $("#desglosecantidad").hasClass("is-invalid") === true)
            {
                $("#desglosecantidad").removeClass("is-invalid");
                $("#desglosecantidad").addClass("is-valid");    
            }
        });  
        $("#desgloseunidad").click(function(){
            if($("#desgloseunidad").val() != "" && $("#desgloseunidad").hasClass("is-invalid") === true)
            {
                $("#desgloseunidad").removeClass("is-invalid");
                $("#desgloseunidad").addClass("is-valid");    
            }
        });       
        $("#desglosedescripcion").keyup(function(){
            if($("#desglosedescripcion").val() != "" && $("#desglosedescripcion").hasClass("is-invalid") === true)
            {
                $("#desglosedescripcion").removeClass("is-invalid");
                $("#desglosedescripcion").addClass("is-valid");    
            }
        });
        $("#desgloseunitario").keyup(function(){
            if($("#desgloseunitario").val() != "" && $("#desgloseunitario").hasClass("is-invalid") === true)
            {
                $("#desgloseunitario").removeClass("is-invalid");
                $("#desgloseunitario").addClass("is-valid");    
            }
        });
        $("#desglosemonto").keyup(function(){
            if($("#desglosemonto").val() != "" && $("#desglosemonto").hasClass("is-invalid") === true)
            {
                $("#desglosemonto").removeClass("is-invalid");
                $("#desglosemonto").addClass("is-valid");    
            }
        });
        $("#desglosemonto").click(function(){
            if($("#desglosemonto").val() != "" && $("#desglosemonto").hasClass("is-invalid") === true)
            {
                $("#desglosemonto").removeClass("is-invalid");
                $("#desglosemonto").addClass("is-valid");    
            }
        });
        

        var Detalle = [];
        
        function DesgloseGuardar()
        {
            var valida = true;
            var vnumero = $("#desglosecantidad").val(); 
            var vunidad = $("#desgloseunidad").val();           
            var vunidadtexto = $("#desgloseunidad option:selected").text();           
            var vconcepto = $("#desglosedescripcion").val();
            var vunitario = $("#desgloseunitario").val();
            var vmonto = $("#desglosemonto").val();
            
            if(vnumero == "")
            {
                $("#desglosecantidad").addClass("is-invalid");
                valida = false;
            }
            if(vunidad == "")
            {
                $("#desgloseunidad").addClass("is-invalid");
                valida = false;
            }
            if(vconcepto == "")
            {
                $("#desglosedescripcion").addClass("is-invalid");
                valida = false;
            }
            if(vunitario == "")
            {
                $("#desgloseunitario").addClass("is-invalid");
                valida = false;
            }
            if(vmonto == "")
            {
                $("#desglosemonto").addClass("is-invalid");
                valida = false;
            }
            
            if(valida == true)
            {
                Detalle.push({numero:vnumero, unidad:vunidad, unidadtexto:vunidadtexto, concepto:vconcepto, unitario:parseFloat(vunitario).toFixed(2), monto:parseFloat(vmonto).toFixed(2)});    
                $("#vdetalle").val("");
                $("#vdetalle").val(JSON.stringify(Detalle));
                MostrarMontoTotal();
                MostrarDesgloseTabla();

                $("#desglosecantidad").val("");
                $("#desgloseunidad").val("");
                $("#desglosedescripcion").val("");
                $("#desgloseunitario").val("");
                $("#desglosemonto").val("");

                if($("#desglosecantidad").hasClass("is-valid") === true)
                {
                    $("#desglosecantidad").removeClass("is-valid");
                }
                if($("#desgloseunidad").hasClass("is-valid") === true)
                {
                    $("#desgloseunidad").removeClass("is-valid");
                }
                if($("#desglosedescripcion").hasClass("is-valid") === true)
                {
                    $("#desglosedescripcion").removeClass("is-valid");
                }
                if($("#desgloseunitario").hasClass("is-valid") === true)
                {
                    $("#desgloseunitario").removeClass("is-valid");
                }
                if($("#desglosemonto").hasClass("is-valid") === true)
                {
                    $("#desglosemonto").removeClass("is-valid");
                }
            }
        }

        function DesgloseEliminar(i)
        {
            Detalle.splice(i, 1);
            $("#vdetalle").val("");
            $("#vdetalle").val(JSON.stringify(Detalle));
            MostrarMontoTotal();
            MostrarDesgloseTabla();     
        }

        function MostrarMontoTotal()
        {   
            var tipo = $("#clase").val();
            if(tipo == 1)
            {
                var total = 0;
                $.each(Detalle, function(key, value)
                {
                    total = parseFloat(total) + parseFloat(Detalle[key].monto);
                });
                $("#subtotal").val(formatCurrencyclean(total.toFixed(2)));

            }                    
           
            var mon = $("#subtotal").val();
            var iva = $("#iva").val();
            var aju = $("#ajuste").val(); 
        
            if(mon == "")
            {   
                mon = 0;
            }
            else
            {
                mon = parseFloat(mon.replace(",", ""));
            }
            if(iva == "")
            {   
                iva = 0;
            }
            else
            {
                iva = parseFloat(iva.replace(",", ""));
            }
            if(aju == "")
            {   
                aju = 0;
            }
            else
            {
                aju = parseFloat(aju.replace(",", ""));
            }
            
            console.log("mon " + mon)
            console.log("iva " + iva)
            console.log("aju " + aju)
                        
            $("#total").val(formatCurrencyclean((mon+iva+aju).toFixed(2)));            
        }  

        

        $("#subtotal").keyup(function(){
            MostrarMontoTotal();
        });
        $("#subtotal").blur(function() {
            var subtotal = $('#subtotal').val();
            if(subtotal != "")
            {
                subtotal = parseFloat(subtotal.replace(",", "")).toFixed(2);
                $("#subtotal").val(formatCurrencyclean(subtotal));
            }            
            
        });

        $("#iva").keyup(function(){
            MostrarMontoTotal();
        });
        $("#iva").blur(function() {
            var iva = $('#iva').val();
            if(iva != "")
            {
                iva = parseFloat(iva.replace(",", "")).toFixed(2);
                $("#iva").val(formatCurrencyclean(iva));
            }   
        });

        $("#ajuste").keyup(function(){
            MostrarMontoTotal();
        });
        $("#ajuste").blur(function() {
            var ajuste = $('#ajuste').val();
            if( ajuste != "")
            {
                ajuste = parseFloat(ajuste.replace(",", "")).toFixed(2);   //reemplaza la coma por vacio.
                $("#ajuste").val(formatCurrencyclean(ajuste));
            }
        });

        $("#disponible").blur(function() {
            var disponible = $('#disponible').val();
            if( disponible != "")
            {
                disponible = parseFloat(disponible.replace(",", "")).toFixed(2);
                $("#disponible").val(formatCurrencyclean(disponible));
            }
            
        });

        function MostrarDesgloseTabla()
        {         
            $("#DesgloseTabla").empty();
            $("#DesgloseTabla").append("<thead><tr><th class='col-1'>Cantidad</th><th class='col-2'>Unidad</th><th class='col-4'>Descripción</th><th class='col-2'>Precio</th><th class='col-2'>Total</th><th class='col-1'>Eliminar</th></tr></thead>"); 
            $("#DesgloseTabla").append("<tbody>");
            $.each(Detalle, function(key, value)
            {
                $("#DesgloseTabla").append("<tr><td class='align-middle'>"+Detalle[key].numero+"</td><td class='align-middle'>"+Detalle[key].unidadtexto+"</td><td class='align-middle'>"+Detalle[key].concepto+"</td><td class='align-middle'>"+formatCurrency(Detalle[key].unitario)+"</td><td class='align-middle'>"+formatCurrency(Detalle[key].monto)+"</td><td><a class='btn btn-outline-danger btn-block' href='javascript:DesgloseEliminar("+key+");'><i class='fas fa-minus'></i></a></td></tr>");
            });
            $("#DesgloseTabla").append("</tbody>");
        }

        $("#clase").change(function(){
            var clase = $("#clase").val();
            if(clase == 1) //compras
            {   
                $("#desglose").removeClass("d-none"); //remueve la funcion ocultar
                $("#subtotal").prop("readonly", true);                  
                $("#inmuebles").addClass("d-none");                  
                $("#muebles").addClass("d-none");                  
                $("#vehiculo").addClass("d-none");                
                limpiar();                   
            }
            else if(clase == 2) // servicio
            {                   
                $("#desglose").addClass("d-none");    //agrega la funcion ocultar
                $("#subtotal").prop("readonly", false);                 
            }
        });
        
        function limpiar()  //funcion para limpiar el contenido de los select
        {
            $("#subtotal").val("");
            $("#iva").val("");
            $("#ajuste").val("");
            $("#total").val("");            
        }
               
        $(function(){  //Funcion para desabilitar o habilitar select 
            $("#clase").change( function(){
                if ($(this).val() === "2")
                {
                    $("#grupo").val("");  
                    $("#grupo").prop("disabled", false); 
                    $("#grupo").prop("required", true);                   
                } 
                else
                {
                    $("#grupo").val("");  
                    $("#grupo").prop("disabled", true);
                    $("#grupo").prop("required", false);                    
                }
            });
        });
       
        $("#grupo").change(function(){  //funcion para mostrar u ocultar inmuebles,muebles y vehiculos
            var grupo = $("#grupo").val();                                               
            if(grupo == 1) //inmuebles
            {   
                
                $("#inmuebles").removeClass("d-none");
                $("#inmueblesdescripcion").prop("required",false); 
                $("#inmueble").prop("required",false); 
                $("#muebles").addClass("d-none"); 
                $("#vehiculo").addClass("d-none");                                                   
            }
            else if(grupo == 2) // muebles
            {      
                $("#muebles").removeClass("d-none");
                $("#muebledescripcion").prop("required",false); 
                $("#mueble").prop("required",false); 
                $("#inmuebles").addClass("d-none");             
                $("#vehiculo").addClass("d-none");                   
            }
            else if(grupo == 3) // vehiculos
            {   
                $("#vehiculo").removeClass("d-none");
                $("#inmuebles").addClass("d-none");             
                $("#muebles").addClass("d-none");                   
            }            
        });

        $(function(){
            $("#areacargo").change(function(){  //se escribe el input que utilizaremos (areacargo)
                $("#divloading").addClass("d-flex").removeClass("d-none"); // funcion para el icono de cargar 
                var identificador = $("#areacargo").val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/solicitudes/clave/idarea')}}";
                    url = url.replace("idarea", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            //console.log(response);
                            $("#clave").empty();
                            $("#clave").val(response.clave);                            
                            $("#divloading").addClass("d-none").removeClass("d-flex");                            
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar la clave!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#clave").val("");                    
                    $("#divloading").addClass("d-none").removeClass("d-flex");                    
                } 
            });
        });
        
        $(function(){
            $("#auto").change(function(){  //se escribe el input que utilizaremos (auto)
                $("#divloading").addClass("d-flex").removeClass("d-none"); // funcion para el icono de cargar 
                var identificador = $("#auto").val();
                if(identificador)
                {
                    // Ini Ajax
                    var url = "{{url('/solicitudes/auto/idauto')}}";
                    url = url.replace("idauto", identificador);
                    $.ajax({type:"get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        dataType: "json",
                        success: function(response, textStatus, xhr)
                        {
                            // console.log(response);
                            // console.log(response.modelo);
                            // console.log(response.placa);
                            // console.log(response.tipo);
                            $("#placas").empty();
                            $("#placas").val(response.placa);                             
                            $("#modelovehiculo").val(response.modelo);                                                         
                            $("#tipo").val(response.tipo);
                            $("#divloading").addClass("d-none").removeClass("d-flex");                            
                        },
                        error: function(xhr, textStatus, errorThrown)
                        {
                            alert("¡Error al cargar el vehiculo!");
                        }
                    });
                    // Fin Ajax
                }
                else
                {
                    $("#placa").val("");                    
                    $("#modelovehiculo").val("");                    
                    $("#tipo").val("");                    
                    $("#divloading").addClass("d-none").removeClass("d-flex");                    
                } 
            });
        });

        $(function(){
            $("#grupo").change( function(){
                if ($(this).val() === "1")
                {
                    $("#inmuebledescripcion").val("");  
                    $("#inmuebledescripcion").prop("required", true);                   
                    $("#inmuebles").prop("required", true);                   
                } 
                else
                {
                    $("#inmuebledescripcion").val("");  
                    $("#inmuebledescripcion").prop("required", false);
                    $("#inmuebles").prop("required", false);                   
                }
            });
        });

       
        // $(function(){
        //     $("#auto").change(function(){
        //         var Auto = event.target.value;
        //         if(Auto)
        //         {
        //             var url = "{{url('/vales/autos/idauto')}}";
        //             url = url.replace("idauto", Auto);
        //             // Ini Ajax
        //             $("#divloading").addClass("d-flex").removeClass("d-none");
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
        //                         $("#funcionario").append("<option value='"+response[i].idfuncionario+"'>"+response[i].nombre+" "+response[i].paterno+" "+response[i].materno+"</option>"); 
        //                     }
        //                     $("#divloading").addClass("d-none").removeClass("d-flex");
        //                 },
        //                 error: function(xhr, textStatus, errorThrown)
        //                 {
        //                     alert("¡Error al cargar el funcionario!");
        //                     $("#divloading").addClass("d-none").removeClass("d-flex");
        //                 }
        //             });
        //             // Fin Ajax
        //         }
        //         else
        //         {
        //             $("#funcionario").empty();
        //             $("#funcionario").append("<option value=''>Funcionario</option>");
        //         } 
        //     });
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
                  if($("#areacargo").val() == "")
                    {
                        $('#areacargo_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#areacargo_chosen').addClass('is-valid');
                    }
                    if($("#area").val() == "")
                    {
                        $('#area_chosen').addClass('is-invalid');
                    }
                    else
                    {
                        $('#area_chosen').addClass('is-valid');
                    }
                    // $('#categoria_chosen').addClass('is-valid');
                    // $('#puesto_chosen').addClass('is-valid');
                }
                form.classList.add('was-validated');
                if($("#areacargo").val() != "")
                {
                    $('#areacargo_chosen').addClass('is-valid');
                }
                if($("#area").val() != "")
                {
                    $('#area_chosen').addClass('is-valid');
                }
                // $('#categoria_chosen').addClass('is-valid');
                // $('#puesto_chosen').addClass('is-valid');
              }, false);
            });
          }, false);
        })();
    </script>
@endsection
