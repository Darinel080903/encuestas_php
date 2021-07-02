//google.load("visualization", "1", {packages:["bar"]});
google.load("visualization", "1", {packages:["corechart"]});

function CargarGrafica(problematica)
{
    if(problematica)
    {
        $.ajax({type:"get",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:"barras/problematica/"+problematica+"",
            dataType: "json",
            success: function(response, textStatus, xhr)
            {
                if(response)
				{
					var data = new google.visualization.DataTable();
					
					// Agregamos la columna año
					data.addColumn('string', 'Año', { role: 'annotation' });

					// Agregamos las columnas de las etiquetas independientemente el número.
					var arraycolumnas = [];
					for(let i=0; i<response.length; i++)
					{
						if($.inArray(response[i].etiqueta, arraycolumnas) === -1)
						{
							arraycolumnas.push(response[i].etiqueta); 
							data.addColumn('number', ""+response[i].etiqueta+"");
							data.addColumn({type:'string', role:'annotation'});
						}
					}

					// Agregamos los registros por medio de un arreglo.
					var vaño = 0;
					row = "[";
					for(let i=0; i<response.length; i++)
					{
						if(response[i].año !== vaño)
						{
							if(i !== 0)
							{
								row = row + "],";
							}
							row = row + "[" + '"'+response[i].año+'"' + "," + response[i].numero + "," + '"'+response[i].numero+'"';
						}
						else
						{
							row = row + "," + response[i].numero + "," + '"'+response[i].numero+'"';
						}
						

						vaño = response[i].año;
					}
					row = row + "]]";
					
					//console.log(row);

					// Convertimos el arreglo de string a json.
					var obj = jQuery.parseJSON(row);

					data.addRows(obj);
				

					var view = new google.visualization.DataView(data);
						
						// view.setColumns([0, 1, {calc:"stringify", sourceColumn:1, type:"string", role:"annotation"},
						// 					2, {calc:"stringify", sourceColumn:2, type:"string", role:"annotation"}]);

					var options = {
						//title: "Density of Precious Metals, in g/cm^3",
						//subtitle: "Sales, Expenses, and Profit: 2014-2017",
						bar: {groupWidth: "90%"},
						backgroundColor: '#FFFFFF',
						width: "100%"
						//legend: { position: "none" },
						// annotations: {
						// 	alwaysOutside: true,
						// 	textStyle: {
						// 		fontSize: 24,
						// 		auraColor: '#000000',
						// 		color: '#000000'
						// }}, 
					};

					// // google.visualization.events.addListener(chart, 'ready', function (){
					// // divtemasprint.innerHTML = '<a TARGET = "_blank" href="' + chart.getImageURI() + '">Imprimir</a>';
					// // console.log(divtemasprint.innerHTML);
					// // });
					  
					var chart = new google.visualization.ColumnChart(document.getElementById("divgrafica"));
      				chart.draw(view, options);
				}
				else
				{
					$('#divgrafica').html("<br><div style='text-align:center;'><strong>No hay información.</strong></div>");
				}
            },
            error: function(xhr, textStatus, errorThrown)
            {
                alert("¡Error al cargar la gráfica!");
            }
        });
    }
}