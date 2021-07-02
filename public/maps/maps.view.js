//Autor: Ing. Cristian Iván Reyes González Fecha: 14/01/2020

//Declaramos las variables.
var map;
var vcentro;
var vzoom;

//Definimos la georeferencia para el Estado de Chiapas.
vcentro = new google.maps.LatLng(16.35882908759366,-92.48498929687503);

//Definimos el zoom.
vzoom = 8;

function initialize(municipio)
{
    var opciones = {
        zoom : vzoom,
        center: vcentro,				
    }

    var styledMapType = new google.maps.StyledMapType(
        [
          {elementType: "geometry", stylers: [{color: "#FFFFFF"}]},
          
          {
            featureType: "administrative.locality",
            elementType: "labels.text",
            stylers: [{color: "#400040"},{weight: 0.5}]
          },
          {
            featureType: "landscape.natural",
            elementType: "geometry",
            stylers: [{color: "#FFFFFF"}]
          },
          {
            featureType: "poi",
            elementType: "all",
            stylers: [{visibility: "off"}]
          },
          {
            featureType: "road",
            elementType: "all",
            stylers: [{visibility: "off"}]
          },
          {
            featureType: "water",
            elementType: "geometry.fill",
            stylers: [{color: "#d3d3d3"}]
          },
          {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [{color: "#d3d3d3"}]
          }
        ],
        {name: "Styled Map"});
    
    var div = document.getElementById("tablerodivmapa");
    map = new google.maps.Map(div, opciones);
    
    map.mapTypes.set("styled_map", styledMapType);
    map.setMapTypeId("styled_map");
    
    loadData(municipio);
    
}

function loadData(municipio)
{
    if(municipio == "undefined")
    {
        municipio = 0;
    }

    $.ajax({type:"get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"mapas/"+municipio+"",
        dataType: "json",
        //data: {'municipio':municipio},
        success: function(response, textStatus, xhr)
        {
            handleData(response);    
        },
        error: function(xhr, textStatus, errorThrown)
        {
            alert("¡Error al cargar los datos!");
        }
    });
}

function loadZoom(municipio)
{
    if(municipio)
    {
        $.ajax({type:"get",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"mapas/"+municipio+"",
            dataType: "json",
            //data: {'municipio':municipio},
            success: function(response, textStatus, xhr)
            {
                for(let i=0; i<response.length; i++)
                {
                    vcentro = new google.maps.LatLng(parseFloat(response[i].latitudpol),parseFloat(response[i].longitudpol));
                    vzoom = parseInt(response[i].zoom);
                    initialize(municipio);
                }
            },
            error: function(xhr, textStatus, errorThrown)
            {
                alert("¡Error al hacer zoom!");
            }
        });
    }
}

function handleData(response)
{
    var numero = response.length;
    var n;

    for(let n = 0; n < response.length; n++)
    {   
        var vnivel = 0;
        var color = "";

        if(response[n].nalto > 0)
        {
            vnivel = 3;
        }
        else
        {
            if(response[n].nmedio > response[n].nbajo)
            {
                vnivel = 2
            }
            else
            {
                vnivel = 1
            }
        }

        var muni = {
            type: "Feature",
            properties: {
            nivel: vnivel,
            nombre: response[n].municipio,
            idmunicipio: response[n].idmunicipio
            },
            geometry: {
                type: "Polygon",
                coordinates: JSON.parse(response[n].poligono)
            }
        };    
        
        map.data.addGeoJson(muni);

        if(numero == 1)
        {
            map.data.setStyle(function(feature)
            {
                var vnivel = feature.getProperty("nivel");
                
                if(vnivel == 1) 
                {
                color = "#3b9082";
                }
                else if(vnivel == 2)
                {
                    color = "orange";
                }
                else if(vnivel == 3)
                {
                    color = "red";
                }
                else if(vnivel == 0)
                {
                    color = "white";
                }
                return{fillColor:"transparent",strokeColor: color, strokeWeight:2, strokeOpacity:1.0};
            });
        }
        else
        {
            map.data.setStyle(function(feature)
            {
                var vnivel = feature.getProperty("nivel");
                
                if(vnivel == 1) 
                {
                color = "#3b9082";
                }
                else if(vnivel == 2)
                {
                    color = "orange";
                }
                else if(vnivel == 3)
                {
                    color = "red";
                }
                else if(vnivel == 0)
                {
                    color = "white";
                }
                return{fillColor:color, fillOpacity:0.50, strokeColor: "#FFFFFF", strokeWeight:2, strokeOpacity:1.0};
            });
        }

        //Esta función creea la acción al dar click en el marker.
        eventopoligono();
    }
}

var llamarFuncion;

function eventopoligono()
{
    llamarFuncion= true;
    map.data.addListener("click", function(event){
        if(llamarFuncion)
        {
            miFuncion();
            loadZoom(event.feature.getProperty("idmunicipio"));
            cargardetalle(event.feature.getProperty("idmunicipio"))
            //CargarPagina("../", nomdiv)
            // $("#tablerodivmapa").removeClass("col-md-10");
            // $("#tablerodivmapa").addClass("col-md-6");
            // $("#divmarcodetalle").removeClass("sr-only");
            //CargarPagina("", nomdiv)
            //cargardetalle(event.feature.getProperty("idmunicipio"));
            //cargardetalle("../tablero/tablero_ver_detalle.php",event.feature.getProperty("idmunicipio"));
            //cargarresumen(event.feature.getProperty("idmunicipio"));
            //CargarEventos(event.feature.getProperty("idmunicipio"));
        }
    });
}

function miFuncion()
{
    llamarFuncion= false;
}