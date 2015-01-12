$(document).ready(function(){
	
	
	form = '<form onsubmit="return false" id="api-form1" method="post">';
		form += '<select name="libro" id="libro">';
		form += '<option value="" selected="selected" disabled="disabled">Seleccionar Libro</option>';
		form += '<option value="1">Génesis</option>';
		form += '<option value="2">Exodo</option>';
		form += '<option value="3">Levitico</option>';
		form += '<option value="4">Números</option>';
		form += '<option value="5">Deuteronomio</option>';
		form += '<option value="6">Josué</option>';
		form += '<option value="7">Jueces</option>';
		form += '<option value="8">Rut</option>';
		form += '<option value="9">1 Samuel</option>';
		form += '<option value="10">2 Samuel</option>';
		form += '<option value="11">1 Reyes</option>';
		form += '<option value="12">2 Reyes</option>';
		form += '<option value="13">1 Crónicas</option>';
		form += '<option value="14">2 Crónicas</option>';
		form += '<option value="15">Esdras</option>';
		form += '<option value="16">Nehemías</option>';
		form += '<option value="17">Ester</option>';
		form += '<option value="18">Job</option>';
		form += '<option value="19">Salmos</option>';
		form += '<option value="20">Proverbios</option>';
		form += '<option value="21">Eclesiastés</option>';
		form += '<option value="22">Cantares</option>';
		form += '<option value="23">Isaías</option>';
		form += '<option value="24">Jeremías</option>';
		form += '<option value="25">Lamentaciones</option>';
		form += '<option value="26">Ezequiel</option>';
		form += '<option value="27">Daniel</option>';
		form += '<option value="28">Oseas</option>';
		form += '<option value="29">Joel</option>';
		form += '<option value="30">Amós</option>';
		form += '<option value="31">Abdías</option>';
		form += '<option value="32">Jonás</option>';
		form += '<option value="33">Miqueas</option>';
		form += '<option value="34">Nahúm</option>';
		form += '<option value="35">Habacuc</option>';
		form += '<option value="36">Sofonías</option>';
		form += '<option value="37">Hageo</option>';
		form += '<option value="38">Zacarías</option>';
		form += '<option value="39">Malaquías</option>';
		form += '<option value="40">Mateo</option>';
		form += '<option value="41">Marcos</option>';
		form += '<option value="42">Lucas</option>';
		form += '<option value="43">Juan</option>';
		form += '<option value="44">Hechos</option>';
		form += '<option value="45">Romanos</option>';
		form += '<option value="46">1 Corintios</option>';
		form += '<option value="47">2 Corintios</option>';
		form += '<option value="48">Gálatas</option>';
		form += '<option value="49">Efesios</option>';
		form += '<option value="50">Filipenses</option>';
		form += '<option value="51">Colosenses</option>';
		form += '<option value="52">1 Tesalonicenses</option>';
		form += '<option value="53">2 Tesalonicenses</option>';
		form += '<option value="54">1 Timoteo</option>';
		form += '<option value="55">2 Timoteo</option>';
		form += '<option value="56">Tito</option>';
		form += '<option value="57">Filemón</option>';
		form += '<option value="58">Hebreos</option>';
		form += '<option value="59">Santiago</option>';
		form += '<option value="60">1 Pedro</option>';
		form += '<option value="61">2 Pedro</option>';
		form += '<option value="62">1 Juan</option>';
		form += '<option value="63">2 Juan</option>';
		form += '<option value="64">3 Juan</option>';
		form += '<option value="65">Judas</option>';
		form += '<option value="66">Apocalipsis</option>';
		form += '</select>';
		form += '<span id="wait_1" style="display: none;">';
		form += '<img alt="Por favor espere..." src="http://biblia.bendicion.net/img/ajax-loader.gif">';
		form += '</span>';
		form += '<span id="result_1" style="display: none;"></span>';
		form += '<span id="wait_2" style="display: none;">';
		form += '<img alt="Por favor espere..." src="http://biblia.bendicion.net/img/ajax-loader.gif">';
		form += '</span>';
		form += '<span id="result_2" style="display: none;"></span>';
	form += '</form>';
	form += '<form id="api-form" onsubmit="return false;">';
		form += '<br><span>Concordancia </span>';
		form += '<input type="text" placeholder="Buscar por palabras" autocomplete="on" name="palabras" maxlength="50" style="width:195px;">';
		form +=	'<span>&nbsp;&nbsp;&nbsp;Versión </span>';
		form += '<select name="version" size="1" style="width:184px;">';
		form += 	'<option value="biblia_1960">Reina Valera 1960 (RVR 1960)</option>';
		form += 	'<option value="biblia_1909">Reina Valera 1909 (RVR 1909)</option>';
		form += 	'<option value="biblia_1989">Reina Valera Actualizada (RVA 1989)</option>';
		form +=     '<option value="biblia_1977">Reina Valera (RV 1977)</option>';
		form +=     '<option value="biblia_2000">Reina Valera (RV 2000)</option>';	
		form += 	'<option value="biblia_rvc">Reina Valera Contemporánea (RVC 2011)</option>';
		form += 	'<option value="biblia_rvg">Reina Valera Gómez (RVG 2004)</option>';
		form += 	'<option value="biblia_1569">Sagradas Escrituras 1569</option>';
		form += 	'<option value="biblia_ntv">Nueva Traducción Viviente (NTV 2009)</option>';
		form += 	'<option value="biblia_nvi">Nueva Versi&oacute;n Internacional (NVI 1999)</option>';
		form += 	'<option value="biblia_lbla">La Biblia de las Américas (LBLA 1997)</option>';
		form += 	'<option value="biblia_pdt">Palabra de Dios para Todos (PDT 2005)</option>';
		form +=     '<option value="biblia_nblh">La Nueva Biblia de los Hispanos (NBLH 2005)</option>';
		form +=     '<option value="biblia_dhhl">Dios Habla Hoy Edici&oacute;n Latinoamericana (DHHL 1996)</option>';
		form +=     '<option value="biblia_vin">Biblia Versi&oacute;n Israelita Nazarena (VIN 2007)</option>';
		form +=     '<option value="biblia_bls">Biblia en Lenguaje Sencillo (BLS 2008)</option>';
		form +=     '<option value="biblia_vm">Biblia Versi&oacute;n Moderna de H.B. Pratt (VM 1929)</option>';
		form +=     '<option value="biblia_blph">Biblia La Palabra Versi&oacute;n Hispanoamericana (BLPH 2011)</option>';	
		form += 	'<option value="biblia_kjv">King James Version (KJV)</option>';
		form += '</select>'
		form += ' <input type="submit" name="Submit" id="submit-btn" value="Buscar">';
	form += '</form>';
	form += '<div id="api-result"></div>';
	$('#api-selector').html(form);
	

});


	$(document).on('click','#submit-btn',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$( "#api-form" ).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});
	
	$(document).on('submit','.bendicion-bible',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$(this).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});
	
	$(document).on('change','[name="version_column"] select',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$( '[name="version_column"]' ).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});
	
	$(document).on('change','[name="version_right_column"] select',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$( '[name="version_right_column"]' ).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});
	
	$(document).on('change','[name="version_left_column"] select',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$( '[name="version_left_column"]' ).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});
	
	$(document).on('change','[name="version_third_column"] select',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$( '[name="version_third_column"]' ).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});	
	
	$(document).on('click','#api-form1 [name="Submit"]',function(){
		palabras = $('[name="palabras"]').val();
		version = $('[name="version"] option:selected').val();
		
		$.post('http://biblia.bendicion.net/api-post-request.php',$( "#api-form1" ).serialize(),function(data){
			$('#api-result').html(data);
		});
	
	});
	
	$(document).ready(function() {
		$('#wait_1').hide();
		$('#libro').change(function(){
			$('#wait_1').show();
			$('#result_1').hide();
			$.get("http://biblia.bendicion.net/api-post-request.php", {
				func: "libro",
				drop_var: $('#libro').val()
			}, function(response){
				$('#wait_1').hide();
				$('#result_1').fadeIn();
				$('#result_1').html(response);
			});
			return false;
		});
		$(document).on('change','#capitulo',function(){
			$('#wait_2').show();
			$('#result_2').hide();
			$.get("http://biblia.bendicion.net/api-post-request.php", {
				func: "capitulo",
				drop_var: $('#capitulo').val()
			}, function(response){
				$('#result_2').fadeIn();
				$('#result_2').html(response);
				$('#wait_2').hide();
			});
			return false;
		});
	});