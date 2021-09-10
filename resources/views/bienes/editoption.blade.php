@foreach($childsactivos as $child)
    @php($cadena='')
    @for ($i = 0; $i < $child->nivel; $i++)
        @php($cadena = $cadena.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    @endfor
    
    @if ($funcionarios->fkadscripcion == $child->idarea)
        <option value="{{$child->idarea}}" selected>{!! $cadena.$child->area !!}</option>
    @else
        <option value="{{$child->idarea}}">{!! $cadena.$child->area !!}</option>
    @endif
    
    @if(count($child->childsactivos))
        @include('funcionarios.editoptionadsc',['childsactivos' => $child->childsactivos])
    @endif
@endforeach