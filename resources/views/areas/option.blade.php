@foreach($childs as $child)
    @if ($area->fkarea == $child->idarea)
        <option value="{{$child->idarea}}" selected>{{$child->area}}</option>
    @else
        <option value="{{$child->idarea}}">{{$child->area}}</option>
    @endif
    @if(count($child->childs))
        @include('areas.option',['childs' => $child->childs])
    @endif
@endforeach