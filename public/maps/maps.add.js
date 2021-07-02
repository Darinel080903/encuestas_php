var mapadd;
var markeradd;
var vcentroadd;
var vzoomadd;

vcentroadd = new google.maps.LatLng(16.35882908759366,-92.48498929687503);
vzoomadd = 13;

function inamapadd()
{
	var lat = $("#latitud").val();
	var lng = $("#longitud").val();

	if(lat == '' || lng == '')
	{
		vcentroadd = new google.maps.LatLng(16.75899451611046,-93.11018003173828);	
	}
	else
	{
		vcentroadd = new google.maps.LatLng(lat,lng);
	}

	var mapOptions = {zoom: vzoomadd, 
					  center: vcentroadd,
		              mapTypeId: google.maps.MapTypeId.SATELLITE};
					  
	mapadd = new google.maps.Map(document.getElementById('divaddmap'),mapOptions);
	
	markeradd = new google.maps.Marker({map: mapadd,
									draggable: true,
									animation: google.maps.Animation.DROP,
									position: vcentroadd});

	google.maps.event.addListener(markeradd, 'dragend', function(){openInfoWindow(markeradd);});
}

function openInfoWindow(markeradd)
{
	var markerLatLng = markeradd.getPosition();
	$("#latitud").val(markerLatLng.lat());
	$("#longitud").val(markerLatLng.lng());
}