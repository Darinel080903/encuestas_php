<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Resguardo</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <img src="{{ url('/storage/escudo/secretaria-general-de-gobierno.png') }}">
    <img src="{{ url('/storage/escudo/chiapas-corazon-claro.png') }}" align="right">
      
        <p align="right">Unidad de Informática <br> Soporte Técnico</p> 
        <p><h2 align="right">Asunto:<br>Resguardo</h2></p>
        <p>
            <hr width=100%  align="right"  size=4  noshade="noshade">
        <p>      
        <p align="right"><b>Tuxtla Gutiérrez, Chiapas</b><br>Fecha:{{date('d/m/Y', strtotime("now"))}}</p> 
        


</head>
<body>
    
    <h1>{{ $funcionarios->nombre }}</h1>

     
    <h3>Suscrito/a al área de: {{$areas}}</h3>
    
    
        <table border="1" style="width: 100%;"> 
                
            <tr>
                <th BGCOLOR="gray">Articulo</th>
                <th BGCOLOR="gray">Marca</th>
                <th BGCOLOR="gray">Modelo</th>
                <th BGCOLOR="gray">Serie</th>
                <th BGCOLOR="gray">Patrimonio</th>
                {{-- <th BGCOLOR="gray">Proc</th>
                <th BGCOLOR="gray">Mem </th> 
                <th BGCOLOR="gray">Dd</th>
                <th BGCOLOR="gray">Win</th>
                <th BGCOLOR="gray">Ip</th> --}}
            </tr>

                                      
            @foreach ($bienes as $item)
            
                <tr align="center">
                    {{-- <td>{{$item->fkfuncionario}}</td> --}}
                    <td>{{$item->articulo}}</td>
                    <td>{{$item->marca}}</td>
                    <td>{{$item->modelo}}</td>
                    <td>{{$item->serie}}</td>
                    <td>{{$item->patrimonio}}</td>
                    {{-- <td>{{$item->procesador}}</td> 
                    <td>{{$item->memoria}}</td> 
                    <td>{{$item->disco}}</td>
                    <td>{{$item->operativo}}</td> 
                    <td>{{$item->ip}}</td> --}}
                                                    
                </tr>
                               
                    
            @endforeach              
                        
        </table>
        
        {{-- <table border="1" style="width: 100%;">

            <tr>
                <th BGCOLOR="gray">Proc </th>
                <th BGCOLOR="gray">Mem</th>
                <th BGCOLOR="gray">Dd</th>
                <th BGCOLOR="gray">Win</th>
                <th BGCOLOR="gray">Ip</th>
            </tr>

            @foreach ($bienes as $item)
                <tr align="center"> 
                    <td>{{$item->procesador}}</td> 
                    <td>{{$item->memoria}}</td> 
                    <td>{{$item->disco}}</td>
                    <td>{{$item->operativo}}</td> 
                    <td>{{$item->ip}}</td>
                </tr>
            @endforeach   
                   
        </table> --}}

      
    <p>Motivo por el cual hago de su pleno conocimiento que el realizar mal uso del equipo, software o movimientos del mismo dentro del edificio será sancionado.
        De igual forma para cualquier instalación del software deberá solicitar apoyo a esta Unidad de Informática.</p>
    <p>La unidad de Informática de la Secretaría General de Gobierno, con domicilio en Palacio de Gobierno 2º piso, 
        Col. Centro en Tuxtla Gutiérrez, Chiapas, es el responsable de uso y protección de sus datos personales 
        y al respecto informo lo siguiente: Los datos personales que recabamos de usted, los utilizaremos únicamente
         como control de Resguardo de equipo de cómputo, los cuales no serán compartidos con nadie.</p>


        <TABLE border="0" style="width: 100%;" >
            <TR ALIGN=CENTER><TD>ENTREGO</TD><TD>RECIBIO</TD>
            </TR>          
            
            <TR ALIGN=CENTER><TD><br><br>_______________</TD><TD><br><br>_______________</TD><br>
            <TR ALIGN=CENTER><TD>Nombre y Firma</TD><TD>Nombre y Firma</TD>
            </TR>
            
        </TABLE>    
        {{-- <footer>
            <p class="text-break">Palacio de Gobierno, 2do. Piso, colonia Centro. C.P. 29000. Tuxtla Gutiérrez,Chiapas <br>Conmutador:(961) 8-74-60 ext:20133</p>
            
        </footer> --}}
        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
</body>
 
</html>



