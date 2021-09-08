@foreach($childsactivos as $child)
    @php($cadena='')
    @for ($i = 0; $i < $child->nivel; $i++)
        @php($cadena = $cadena.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    @endfor
    
    @if (old('area') == $child->idarea)
        <option value="{{$child->idarea}}" selected>{!! $cadena.$child->area !!}</option>
    @else
        <option value="{{$child->idarea}}">{!! $cadena.$child->area !!}</option>
    @endif
    
    @if(count($child->childsactivos))
        @include('funcionarios.crearoptionarea',['childsactivos' => $child->childsactivos])
    @endif
@endforeach