@foreach($childs as $child)
    <option value="{{$child->idarea}}">{{$child->area}}</option>
    @if(count($child->childs))
        @include('areas.option',['childs' => $child->childs])
    @endif
@endforeach