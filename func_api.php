<link rel="stylesheet" type="text/css" href="http://biblia.bendicion.net/styles.css" />
<?php
### Function: Biblia Versiones
function biblia_versiones() {
    echo '<option value="biblia_1960">Reina Valera 1960 (RVR 1960)</option>';
    echo '<option value="biblia_1909">Reina Valera 1909 (RVR 1909)</option>';
	echo '<option value="biblia_1989">Reina Valera Actualizada (RVA 1989)</option>';
	echo '<option value="biblia_1977">Reina Valera (RV 1977)</option>';
	echo '<option value="biblia_2000">Reina Valera (RV 2000)</option>';
	echo '<option value="biblia_rvc">Reina Valera Contempor&aacute;nea (RVC 2011)</option>';
	echo '<option value="biblia_rvg">Reina Valera G&oacute;mez (RVG 2004)</option>';
	echo '<option value="biblia_1569">Sagradas Escrituras 1569</option>';	
	echo '<option value="biblia_ntv">Nueva Traducci&oacute;n Viviente (NTV 2009)</option>';
	echo '<option value="biblia_nvi">Nueva Versi&oacute;n Internacional (NVI 1999)</option>';
	echo '<option value="biblia_lbla">La Biblia de las Am&eacute;ricas (LBLA 1997)</option>';
	echo '<option value="biblia_pdt">Palabra de Dios para Todos (PDT 2005)</option>';
	echo '<option value="biblia_nblh">La Nueva Biblia de los Hispanos (NBLH 2005)</option>';
	echo '<option value="biblia_dhhl">Dios Habla Hoy Edici&oacute;n Latinoamericana (DHHL 1996)</option>';
	echo '<option value="biblia_vin">Biblia Versi&oacute;n Israelita Nazarena (VIN 2007)</option>';
	echo '<option value="biblia_bls">Biblia en Lenguaje Sencillo (BLS 2008)</option>';
	echo '<option value="biblia_vm">Biblia Versi&oacute;n Moderna de H.B. Pratt (VM 1929)</option>';
	echo '<option value="biblia_blph">Biblia La Palabra Versi&oacute;n Hispanoamericana (BLPH 2011)</option>';
	echo '<option value="biblia_kjv">King James Version (KJV)</option>';
}

function getTierOne()
{
	$table_name    = 'biblia_1909';
	$bible_result2 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='10'")
	or die(mysql_error());
	  while($row2 = mysql_fetch_array($bible_result2)) 
  
		{
		   echo '<option value="'.$row2["versiculo"].'">'.$row2["texto"].'</option>';
		}		

}

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "libro" && isset($_GET['func'])) { 
   libro($_GET['drop_var']); 
}

function libro($drop_var)
{  
    include_once('biblia_config.inc.php');
	$result = mysql_query("SELECT DISTINCT capitulos FROM capitulos WHERE libro='$drop_var'") 
	or die(mysql_error());
	
	echo '<select name="capitulo" id="capitulo">
	      <option value=" " disabled="disabled" selected="selected">Cap&iacute;tulo</option>';

		   while($capitulo = mysql_fetch_array( $result )) 
			{
			  echo '<option value="'.$capitulo['capitulos'].'">'.$capitulo['capitulos'].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_2').hide();
	$('#capitulo').change(function(){
	  $('#wait_2').show();
	  $('#result_2').hide();
      $.get(\"func_api.php\", {
		func: \"capitulo\",
		drop_var: $('#capitulo').val()
      }, function(response){
        $('#result_2').fadeOut();
        setTimeout(\"finishAjax_tier_three('result_2', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************
if($_GET['func'] == "capitulo" && isset($_GET['func'])) { 
   capitulo($_GET['drop_var']); 
}

function capitulo($drop_var)
{  
    include_once('biblia_config.inc.php');
	$result = mysql_query("SELECT * FROM capitulos WHERE capitulos='$drop_var' LIMIT 1") 
	or die(mysql_error());
	
	echo '<select name="versiculo" id="versiculo">
	      <option value=" " disabled="disabled" selected="selected">Vers&iacute;culo</option>';
		   while($versiculo = mysql_fetch_array( $result )) 
			{
			  $c = $versiculo['versiculos'];
			  $i = 1;
			  while ($i <= $c) {
			  echo '<option value="'.$i.'">'.$i.'</option>';
			  $i++;
			  }
			}
	echo '</select> ';
	
    echo '&nbsp;&nbsp;&nbsp;Versi&oacute;n ';
	echo '<select name="version" size="1" style="width:180px;">';
    biblia_versiones();
	echo '</select>';
     
    echo '<td> <input type="submit" name="Submit" value="Buscar" /></td>';

}
?>