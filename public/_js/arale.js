/**
 * Funciones genericas de la aplicacion
 */

function autoCompletaProvinciaPoblacion(){		
		if($("#codigoPostal").val()!="" & $("#countryCode").val()!=""){
			$.getJSON(
			"http://api.geonames.org/postalCodeSearchJSON?",
			{
			postalcode:$("#codigoPostal").val(),
			country:$("#codigoPais").val(),
			countryBias:"ES",
			maxRows:"1",
			username:"sbarrat"
			},
			function( data ){
				if(data['postalCodes'].length ==1){
				 $("#provincia").val(data['postalCodes'][0]['adminName2']);
				 $("#poblacion").val(data['postalCodes'][0]['placeName']);
				}
				else
					alert("Error:Compruebe el Codigo Postal");
			});
	}
	else
		alert("Debe especificar el Codigo Postal y el Pais");
}

function autoCompletaPais(){
	$("#pais").autocomplete({
		source: function(request, response) {
			$.ajax({
				url: "http://ws.geonames.org/searchJSON",
				dataType: "jsonp",
				data: {
					featureClass: "A",
					style:"full",
					lang: "es",
					featureCode: "PCLI",
					maxRows: 12,
					name_startsWith: request.term
				},
				success: function(data) {
					response($.map(data.geonames, function(item) {
						
						return {
							label: item.countryName,
							value: item.countryName,
							code: item.countryCode
						};
					}));
				}
			});
		},
		minLength: 2,
		select: function(event, ui) {
			console.log(ui.item ? ("Selected: " + ui.item.label) : "Nothing selected, input was " + this.value);
		
			$("#codigoPais").val(ui.item.code);
		},
		open: function() {
			$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
		},
		close: function() {
			$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
		}
	});
}
function autoCompletaEmpresa(){
	$("#empresa").autocomplete({
	source: function(request, response){
		$.ajax({
			url: "_inc/_helpers/listadoEmpresas.php",
			dataType:"json",
			data:{
				maxRows:10,
				name_startsWidth: request.term
			},
			success: function(data){
				response($.map(data.empresa, function(item) {
					return {
						label: item.nombre,
						value: item.nombre,
						code: item.id
						};
				}));
			}
		});
	},
	minLength: 2,
	select: function(event, ui) {
		console.log(ui.item ? ("Selected: " + ui.item.label) : "Nothing selected, input was " + this.value);
		$("#idEmpresa").val(ui.item.code);
	},
	open: function() {
		$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
	},
	close: function() {
		$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
	}
	});
}


function fechaNacimiento(){
	$("#fechaNacimiento").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd-mm-yy",
		minDate:"-100y",
		maxDate:"+0d",
		firstDay: 1,
		dayNames:['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		dayNamesShort:['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		yearRange:"1911:2011"
		});
}


