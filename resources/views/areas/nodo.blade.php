@foreach($childs as $child)
    <tr>
        <td class="text-justify align-middle" scope="row">{{$child->area}}</td>
        <td class="text-center" width="11%">
            @can('update', $item)
                <a class="btn btn-outline-danger" href="{{url('/areas/'.$child->idarea.'/edit')}}"><i class="fas fa-pen"></i> Editar</a>
            @endcan
        </td>
        <td class="text-center" width="11%">
            @can('update', $item)
                <form id="frmimgpublicar{{$child->idarea}}" name="frmimgpublicar{{$child->idarea}}" method="POST" action="{{url('/areas/'.$child->idarea.'/update2')}}">
                    @method('PUT')
                    @csrf
                    <input type="checkbox" id="activo" name="activo" onchange="funpublicar('frmimgpublicar{{$child->idarea}}')" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" @if($child->activo == 1) {{'checked'}} @endif>
                </form>
            @endcan
        </td>
        <td class="text-center" width="11%">
            @can('delete', $item)
                <form method="POST" action="{{url('/areas/'.$child->idarea)}}">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i> Borrar</button>
                </form>
            @endcan
        </td>    
        @if(count($child->childs))
            @include('areas.nodo',['childs' => $child->childs])
        @endif
    </tr>
@endforeach