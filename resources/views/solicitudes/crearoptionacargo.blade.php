@foreach($childs as $child)
    {{-- @php($cadena='')
    @for ($i = 0; $i < $child->nivel; $i++)
        @php($cadena = $cadena.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    @endfor --}}
    @if ($child->activo == 1 && $child->clave)
        @if (old('areacargo') == $child->idarea)
            <option value="{{$child->idarea}}" selected>{!! $child->area !!}</option>
        @else
            <option value="{{$child->idarea}}">{!! $child->area !!}</option>
        @endif       
    @endif

    @if(count($child->childs))
        @include('solicitudes.crearoptionacargo', ['childs' => $child->childs])
    @endif  
    
@endforeach