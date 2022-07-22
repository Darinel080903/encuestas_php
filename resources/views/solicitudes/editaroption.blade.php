@foreach($childs as $child)
    {{-- @php($cadena='')
    @for ($i = 0; $i < $child->nivel; $i++)
        @php($cadena = $cadena.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    @endfor --}}
    @if ($child->activo == 1)
        @if ($solicitudes->fkarea == $child->idarea)
            <option value="{{$child->idarea}}" selected>{!! $child->area !!}</option>
        @else
            <option value="{{$child->idarea}}">{!! $child->area !!}</option>
        @endif       
        
        @if(count($child->childs))
            @include('solicitudes.editaroption',['childs' => $child->childs])
        @endif    
    @endif
    
@endforeach