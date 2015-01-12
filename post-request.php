<?php

// Connect to the database server
function biblia_connect_db()
{
	$dblog = @mysql_connect("biblia.db.5886478.hostedresource.com", "biblia", "ReadBible75");
	if (!$dblog) {
		echo ("<p>No se pudo conectar al servidor de base de datos en este momento.</p>");
		exit();
	}

	mysql_set_charset('utf8', $dblog);
	mysql_select_db("biblia", $dblog);
	if (!@mysql_select_db("biblia")) {
		echo ("<p>No se pudo encontrar la base de datos en este momento.</p>");
		exit();
	}
} // end function connect to the database
echo '<script type="text/javascript" src="http://biblia.bendicion.net/scrolltopcontrol.js"></script>';
echo '<script type="text/javascript" src="http://biblia.bendicion.net/font_size_api.js"></script>';

function biblia_fonts()
{
	echo '<link rel="stylesheet" type="text/css" href="http://biblia.bendicion.net/styles.css" />';
} // end function fonts
biblia_connect_db();
include ('func_api.php');

// ###################### Determine if Bible Book, Chapter, and verse were received
if (isset($_POST['libro']) && !empty($_POST['libro']) && isset($_POST['capitulo']) && !empty($_POST['capitulo']) && isset($_POST['versiculo']) && !empty($_POST['versiculo'])) {
	$libro = $_POST['libro'];
	$capitulo = $_POST['capitulo'];
	$versiculo = $_POST['versiculo'];
	$version = $_POST['version'];
	if ($version == "") {
		$version = 'biblia_1960';
	}

	$table_name = $version;
	$bible_result1 = @mysql_query("SELECT * FROM $table_name WHERE libro='$libro' AND capitulo='$capitulo' AND versiculo='$versiculo'");
	$bible_result2 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='10' AND versiculo='$libro'");
	$bible_result3 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name

	// Get Bible Version Name
	$row3 = mysql_fetch_array($bible_result3);
	$nombre = $row3["texto"];

	// Get Bible Text
	$row1 = mysql_fetch_array($bible_result1);
	$bible_text = $row1["texto"];

	// Get Bible Book

	$row2 = mysql_fetch_array($bible_result2);
	$bible_book = $row2["texto"];
	biblia_fonts();

	// Display All along with the Bible version name
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tr><td align="left" class="txt_verse">';
	echo '</br>' . $bible_text . '&nbsp;<b></br>' . $bible_book . '&nbsp;' . $capitulo . ':' . $versiculo . '</b> ' . $nombre . '</td></tr>';
	echo '<tr><td>';

	// Input button to get a whole chapter
	echo "<form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"libro\" value=\"" . $libro . "\" />";
	echo "<input type=\"hidden\" name=\"capitulo\" value=\"" . $capitulo . "\" />";
	echo "<input type=\"hidden\" name=\"version\" value=\"" . $version . "\" />";
	echo "<input type=\"submit\" value=\"Ver " . $bible_book . ' ' . $capitulo . "\" class=\"submit_button\" />";
	echo '</form></td></tr><tr><td>';
	echo '</td></tr></table>';
}

    ########################## Determine if ONLY the Book and chapter were sent ##########################
else
if (isset($_POST['libro']) && !empty($_POST['libro']) && isset($_POST['capitulo']) && !empty($_POST['capitulo'])) {

	// If the user just sent info
	$libro = $_POST['libro'];
	$capitulo = $_POST['capitulo'];
	$version = $_POST['version'];
	if ($version == "") {
		$version = 'biblia_1960';
	}

	biblia_connect_db(); // connect to database
	$table_name = $version;
	$bible_result7 = @mysql_query("SELECT * FROM $table_name WHERE libro='$libro' AND capitulo='$capitulo' ORDER BY versiculo ASC"); // Get Text Verse
	$bible_result8 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='10' AND versiculo='$libro'"); // Get Book Name
	$bible_result9 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name

	// Get Bible Version Name
	$row9 = mysql_fetch_array($bible_result9);
	$nombre = $row9["texto"];

	// Get Bible Book Name
	$row8 = mysql_fetch_array($bible_result8);
	$bible_book = $row8["texto"];
	echo '</br>';
	$capitulo_prev = $capitulo - 1;
	$capitulo_next = $capitulo + 1;
	biblia_fonts();

	// Display Book Name and Chapter
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tr><td align="center"><h1>' . $bible_book . ' ' . $capitulo . '</h1></td></tr></table>';

	// Display the Bible version name
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tr><td class="txt_verse">' . $nombre . '</td></tr></table>';
	$libro_next = $libro + 1;
	$libro_prev = $libro - 1;

	// Input button to get previous chapter
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";

	// Display drop down menu to change versions
	echo "<td align=\"left\"><form name=\"version_column\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">";
	echo '<select name="version" size="1" class="txt_verse" style="width:100px;" onchange="version_column.submit();">';
	echo "<option value=\"\" selected=\"selected\">Versi&oacute;n</option>";
	biblia_versiones();
	echo "<input type=\"hidden\" name=\"capitulo\" value=\"" . $capitulo . "\" />";
	echo "<input type=\"hidden\" name=\"libro\" value=\"" . $libro . "\" />";
	echo "</select></form></td><td width=\"5\"></td>";

	// Display previous chapter button
	if ($capitulo > 1) {
		echo "<td><form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">
		 <input type=\"hidden\" name=\"libro\" value=\"" . $libro . "\" />
		 <input type=\"hidden\" name=\"capitulo\" value=\"" . $capitulo_prev . "\" />
		 <input type=\"hidden\" name=\"version\" value=\"" . $version . "\" />
		 <input type=\"submit\" value=\"<< Cap&iacute;tulo\" class=\"boton\" />
		 </form>
	</td>";
	}
	else {
		$empty_td = '<td>&nbsp;</td>';
	}

	// Display next chapter button
	echo "
    <td width=\"5\"></td>
    <td><form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">
    <input type=\"hidden\" name=\"libro\" value=\"" . $libro . "\" />
	<input type=\"hidden\" name=\"capitulo\" value=\"" . $capitulo_next . "\" />
	<input type=\"hidden\" name=\"version\" value=\"" . $version . "\" />
	<input type=\"submit\" value=\"Cap&iacute;tulo >>\" class=\"boton\" />
	</form></td>
	
	<td width=\"5\"></td>
	
	<td>
	<form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">
	<input type=\"hidden\" name=\"libro\" value=\"" . $libro_prev . "\" />
	<input type=\"hidden\" name=\"capitulo\" value=\"1\" />
	<input type=\"hidden\" name=\"version\" value=\"" . $version . "\" />
	<input type=\"submit\" value=\"<< Libro\" class=\"boton\" />
	</form>
	</td>	
	
	<td width=\"5\"></td>
	
	<td>
	<form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">
	<input type=\"hidden\" name=\"libro\" value=\"" . $libro_next . "\" />
	<input type=\"hidden\" name=\"capitulo\" value=\"1\" />
	<input type=\"hidden\" name=\"version\" value=\"" . $version . "\" />
	<input type=\"submit\" value=\"Libro >>\" class=\"boton\" />
	</form>
	</td>
	
	<td width=\"5\"></td>
    <td>
    <form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">
    <input type=\"hidden\" name=\"paralelo_cap\" value=\"" . $capitulo . "\" />
    <input type=\"hidden\" name=\"version_left\" value=\"biblia_1960\">
    <input type=\"hidden\" name=\"version_right\" value=\"biblia_1909\">
    <input type=\"hidden\" name=\"paralelo\" value=\"" . $libro . "\" />
    <input type=\"submit\" value=\"Paralelo\" class=\"boton\" /></form></td>";

	// Display Font Size Change /////////////////////////
	echo "
	<td width=\"5\"></td>
    <td><a href=\"javascript:decreaseFontSize();\"><img src=\"http://biblia.bendicion.net/img/disminuir.png\" width=\"30\" height=\"30\" border=\"0\" valign=\"top\" /></a></td>
    <td width=\"5\"></td>
    <td><a href=\"javascript:increaseFontSize();\"><img src=\"http://biblia.bendicion.net/img/aumentar.png\" width=\"30\" height=\"30\" border=\"0\" valign=\"top\" /></a></td>";
	echo $empty_td;
	echo "</tr></table>";
	
    ### Function: Display Audio
    function display_audio($version, $libro, $capitulo) {
		// Switch Case Audio Player	depending on what Bible version is used
		switch ($version) {
			case 'biblia_1909':
			    $version = 'biblia_1909';
				$version_desc = 'Reina Valera 1909';
				break;
			case 'biblia_1960':
			    $version = 'biblia_1960';
				$version_desc = 'Reina Valera 1960';
				break;
			case 'biblia_kjv':
			    $version = 'biblia_kjv';
				$version_desc = 'King James Version';
				break;
			default:
			    $version = 'biblia_1960';
				$version_desc = 'Reina Valera 1960';
		} // end switch
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
		echo '<td class="txt_verse">Escuchar en '.$version_desc.' ';
		echo '<script src="http://biblia.bendicion.net/build/jquery.js"></script>
		<script src="http://biblia.bendicion.net/build/mediaelement-and-player.min.js"></script>
		<link rel="stylesheet" href="http://biblia.bendicion.net/build/mediaelementplayer.min.css" />
		<audio id="player2" preload="none" src="http://bendicion.net/biblia_audio/'.$version.'/'.$libro.'/'.$libro.'_'.$capitulo.'.mp3" type="audio/mp3" controls="controls">
		</audio>
		<script>$("audio,video").mediaelementplayer();</script>';
		echo '</td></tr></table>';	
	} // end function Display Audio
	
	// Call function Display Audio
	display_audio($version, $libro, $capitulo);

	// Display Bible Text Verse
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="hovertable">';
	while ($row7 = mysql_fetch_array($bible_result7)) {
		echo '<tr><td align="left" class="txt_verse"><p1><sup class="txt_sup">'.$row7["versiculo"].'</sup> '.$row7["texto"].'</br></p1></td></tr>';
		$verso.= $row7["versiculo"].' '.$row7["texto"].' ';
	}
	echo '<tr><td><br /></td></tr></table></br>';

	// Display scroll to top button
	echo '<a href="#top"></a>';
} // end if statement

    ########################## Determine if Concordancia was received ##########################
else
if (isset($_POST['palabras']) && !empty($_POST['palabras'])) {
	$palabras = stripslashes($_POST['palabras']); // If the user just sent info
	$version = $_POST['version'];
	if ($version == "") {
		$version = 'biblia_1960';
	}

	// Save the search term in this varibale to be able to use it in the output
	biblia_connect_db(); // Connect to the database
	$table_name = $version;
	$search_text = @mysql_query("SELECT * FROM $table_name WHERE texto LIKE '%$palabras%' ORDER BY libro ASC");

	// Get Bible Version Name
	$bible_result5 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'");
	$row5 = mysql_fetch_array($bible_result5);
	$nombre = $row5["texto"];
	biblia_fonts();

	// Display drop down menu to change versions
	echo '</br><table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tr><td class="txt_verse">' .$nombre. '</td></tr></table>';
	
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="left"><form name="version_column" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
	echo "<select name=\"version\" size=\"1\" onchange=\"version_column.submit();\" class=\"txt_verse\">\n";
	echo "<option value=\"\" selected=\"selected\">Cambiar Versi&oacute;n</option>";
	biblia_versiones();
	echo "<input type=\"hidden\" name=\"palabras\" value=\"".$palabras."\" />";
	echo "</select></form></td><td width=\"30%\">&nbsp;</td>";
	echo '</tr></table><br>';

	// Loop for results
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tr><td class="txt_verse">';

	// Function to highlight results
	function highlightStr($string, $word, $highlightColorValue) {
		// return $string if there is no highlight color or strings given, nothing to do.
		if (strlen($highlightColorValue) < 1 || strlen($string) < 1 || strlen($word) < 1) {
			return $string;
			}
			preg_match_all("/$word+/i", $string, $matches);
			if (is_array($matches[0]) && count($matches[0]) >= 1) {
				foreach ($matches[0] as $match) {
					$string = str_replace($match, '<span style="background-color:'.$highlightColorValue.';">'.$match.'</span>', $string);
					}
			}
			return $string;
		}
	
	while ($row_search_text = mysql_fetch_array($search_text)) {
		$output = $row_search_text["texto"];
		$libro = $row_search_text["libro"];
		$capitulo = $row_search_text["capitulo"];
		$versiculo = $row_search_text["versiculo"];
		$highlightColorValue = '#ffff00';
		
		// Call highlightStr function
		$output = highlightStr($output, $palabras, $highlightColorValue);
		
		//$output = str_replace($palabra, "<span style=background-color:yellow>" . $palabra . "</span>", $output);

		// Find the name of the book by looking up the number
		$bible_result4 = @mysql_query("SELECT * FROM $table_name WHERE libro='0' AND capitulo='10' AND versiculo='$libro'");

		// Get Bible Book
		$row4 = mysql_fetch_array($bible_result4);
		$bible_book = $row4["texto"];

		// Display search results
		echo $output . '&nbsp;<b>' . $bible_book . '&nbsp;' . $capitulo . ':' . $versiculo . '</b></br>';

		// Input button to get a whole chapter
		echo "<form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"libro\" value=\"" . $libro . "\" />\n";
		echo "<input type=\"hidden\" name=\"capitulo\" value=\"" . $capitulo . "\" />\n";
		echo "<input type=\"hidden\" name=\"version\" value=\"" . $version . "\" />";
		echo "<input type=\"submit\" value=\"Ver " . $bible_book . ' ' . $capitulo . "\" />\n";
		echo "</form><br />";
		$count = $count + 1;
	} // end while loop
	echo '</td></tr>';
	echo '<tr><td class="txt_verse"><br /><b>Vers&iacute;culos encontrados:</b> ' . $count . '</br></br></br></td></tr></table>';
} // end else if

    ########################## Determine if Paralelo was received ##########################
else
if (isset($_POST['paralelo']) && isset($_POST['paralelo_cap']) && isset($_POST['version_left']) && isset($_POST['version_right'])) {

	// If the user just sent info
	biblia_connect_db(); // connect to database
	$libro = $_POST['paralelo'];
	$capitulo = $_POST['paralelo_cap'];
	$left_table_name = $_POST['version_left'];
	$right_table_name = $_POST['version_right'];

	// Query Results for Left Table
	$bible_result7 = @mysql_query("SELECT * FROM $left_table_name WHERE libro='$libro' AND capitulo='$capitulo' ORDER BY versiculo ASC"); // Get Text Verse
	$bible_result8 = @mysql_query("SELECT * FROM $left_table_name WHERE libro='0' AND capitulo='10' AND versiculo='$libro'"); // Get Book Name
	$bible_result9 = @mysql_query("SELECT * FROM $left_table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name

	// Query Results for Right Table
	$bible_result7b = @mysql_query("SELECT * FROM $right_table_name WHERE libro='$libro' AND capitulo='$capitulo' ORDER BY versiculo ASC"); // Get Text Verse
	$bible_result8b = @mysql_query("SELECT * FROM $right_table_name WHERE libro='0' AND capitulo='10' AND versiculo='$libro'"); // Get Book Name
	$bible_result9b = @mysql_query("SELECT * FROM $right_table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name

	// Get Bible Version Name for Left Table
	$row9 = mysql_fetch_array($bible_result9);
	$nombre_left = $row9["texto"];

	// Get Bible Version Name for Right Table
	$row9b = mysql_fetch_array($bible_result9b);
	$nombre_right = $row9b["texto"];

	// Get Bible Book Name
	echo '</br>';
	$row8 = mysql_fetch_array($bible_result8);
	$bible_book = $row8["texto"];
	biblia_fonts();

	// Display Book name
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
	echo '<td class="txt_form" align="center"><h1>' . $bible_book . ' ' . $capitulo . '</h1></td></tr></table>';
	
	// Add buttons
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
	//echo '<tr><td class="txt_form">Cap&iacute;tulo en paralelo</td></tr>';

	// Input button Remover Paralelo
	echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
	echo '<input type="hidden" name="libro" value="'.$libro.'" />';
	echo '<input type="hidden" name="capitulo" value="'.$capitulo.'" />';
	echo '<input type="hidden" name="version" value="'.$left_table_name.'">';
	echo '<input type="submit" value="- Paralelo" class="boton" /></form></td>';
	echo '<td width="5"></td>';

	// Input button Agregar Tercer Paralelo
	echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
	echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo.'" />';
	echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
	echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
	echo '<input type="hidden" name="version_third" value="biblia_lbla">';
	echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
	echo '<input type="submit" value="+ Paralelo" class="boton" /></form></td>';
	echo '<td width="5"></td>';

	// Input button Libro Anterior
	if ($libro > 1) {
	$libro_prev = $libro - 1;
	echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
	echo '<input type="hidden" name="paralelo" value="'.$libro_prev.'" />';
	echo '<input type="hidden" name="paralelo_cap" value="1" />';
	echo '<input type="hidden" name="version_right" value="'.$right_table_name.'">';
	echo '<input type="hidden" name="version_left" value="'.$left_table_name.'">';
	echo '<input type="submit" value="<< Libro" class="boton" /></form></td>';
	echo '<td width="5"></td>';
	} // end if

	// Input button Libro Siguiente
	$libro_next = $libro + 1;
	echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
	echo '<input type="hidden" name="paralelo" value="'.$libro_next.'" />';
	echo '<input type="hidden" name="paralelo_cap" value="1" />';
	echo '<input type="hidden" name="version_right" value="'.$right_table_name.'">';
	echo '<input type="hidden" name="version_left" value="'.$left_table_name.'">';
	echo '<input type="submit" value="Libro >>" class="boton" /></form></td>';
	echo '<td width="5"></td>';

	// Input button Capitulo Anterior
	$capitulo_prev = $capitulo - 1;
	$capitulo_next = $capitulo + 1;
	if ($capitulo > 1) {
		echo '<td align="left">';
		echo "<form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"paralelo\" value=\"".$libro."\" />";
		echo "<input type=\"hidden\" name=\"paralelo_cap\" value=\"" . $capitulo_prev . "\" />";
		echo "<input type=\"hidden\" name=\"version_right\" value=\"" . $right_table_name . "\">";
		echo "<input type=\"hidden\" name=\"version_left\" value=\"" . $left_table_name . "\">";
		echo "<input type=\"submit\" value=\"<< Cap&iacute;tulo\" class=\"boton\" /></form></td>";
		echo '<td width="5"></td>';
	} // end if

	// Input button Capitulo Siguiente
	$capitulo_next = $capitulo + 1;
	echo '<td align="left">';
	echo "<form class=\"bendicion-bible\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">";
	echo "<input type=\"hidden\" name=\"paralelo\" value=\"" . $libro . "\" />";
	echo "<input type=\"hidden\" name=\"paralelo_cap\" value=\"" . $capitulo_next . "\" />";
	echo "<input type=\"hidden\" name=\"version_right\" value=\"" . $right_table_name . "\">";
	echo "<input type=\"hidden\" name=\"version_left\" value=\"" . $left_table_name . "\">";
	echo '<input type="submit" value="Cap&iacute;tulo >>" class="boton" /></form></td>';
	echo '<td width="5"></td>';
	
	// Display Font Size Change /////////////////////////
	echo '</td><td><a href="javascript:decreaseFontSize();"><img src="http://biblia.bendicion.net/img/disminuir.png" width="30" height="30" border="0" valign="top" /></a></td>
    <td width="5"></td>
    <td><a href="javascript:increaseFontSize();"><img src="http://biblia.bendicion.net/img/aumentar.png" width="30" height="30" border="0" valign="top" /></a></td></tr></table>';

	// Display Table in half
	echo '<br><table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tr><td valign="top" class="txt_verse">';

	// ######### Left version here
	// Display Book Name and Chapter along with the Bible version name
	echo $nombre_left;

	// Display drop down menu to change versions on LEFT COLUMN
	echo "<form name=\"version_left_column\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">";
	echo '<select name="version_left" size="1" class="txt_verse" style="width:280px;" onchange="version_left_column.submit();">';
	echo "<option value=\"\" selected=\"selected\">Cambiar Versi&oacute;n</option>";
	biblia_versiones();
	echo "<input type=\"hidden\" name=\"paralelo_cap\" value=\"" . $capitulo . "\" />";
	echo "<input type=\"hidden\" name=\"version_right\" value=\"" . $right_table_name . "\">";
	echo "<input type=\"hidden\" name=\"paralelo\" value=\"" . $libro . "\" />";
	echo "</select></form>";

	// Display Bible Text Verse
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="hovertable">';
	while ($row7 = mysql_fetch_array($bible_result7)) {
		echo '<tr><td align="left" class="txt_verse"><p1><sup class="txt_sup">'.$row7["versiculo"].'</sup> '.$row7["texto"].'</br></p1></td></tr>';
	}
	echo '</table></td>';
	echo '<td width="10"></td>';
	echo '<td width="1" bgcolor="#cecece"></td>';
	echo '<td width="10"></td>';

	// ######### Right version here
	echo '<td valign="top" class="txt_verse">';

	// Display Book Name and Chapter along with the Bible version name
	echo $nombre_right;

	// Display drop down menu to change versions on RIGHT COLUMN
	echo "<form name=\"version_right_column\" action=\"http://bendicion.net/biblia_y_concordancia.php\" method=\"post\">";
	echo '<select name="version_right" size="1" class="txt_verse" style="width:280px;" onchange="version_right_column.submit();">';
	echo "<option value=\"\" selected=\"selected\">Cambiar Versi&oacute;n</option>";
	biblia_versiones();
	echo "<input type=\"hidden\" name=\"paralelo_cap\" value=\"" . $capitulo . "\" />";
	echo "<input type=\"hidden\" name=\"version_left\" value=\"" . $left_table_name . "\">";
	echo "<input type=\"hidden\" name=\"paralelo\" value=\"" . $libro . "\" />";
	echo "</select></form>";

	// Display Bible Text Verse
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="hovertable">';
	while ($row7b = mysql_fetch_array($bible_result7b)) {
		echo '<tr><td align="left" class="txt_verse"><p1><sup class="txt_sup">'.$row7b["versiculo"].'</sup> '.$row7b["texto"].'</br></p1></td></tr>';
	}
	echo '</table></td></tr></table></br>';
	
} // end else if

    ############################# Determine if a Third Paralelo Column was received #############################
    else if (isset($_POST['version_third']) && !empty($_POST['version_third'])) {
		
       // If the user just sent info
		biblia_connect_db(); // connect to database
		$libro    = $_POST['paralelo'];
		$capitulo = $_POST['paralelo_cap'];
		$left_table_name  = $_POST['version_izquierda'];
		$right_table_name = $_POST['version_derecha'];
		$third_table_name = $_POST['version_third'];
		//$third_table_name = 'biblia_lbla';
		
		//echo 'libro is: '.$libro.'<br>';
		//echo 'capitulo is: '.$capitulo.'<br>';
		//echo 'left table name is: '.$left_table_name.'<br>';
		//echo 'right table name is: '.$right_table_name.'<br>';
		//echo 'third table name is: '.$third_table_name.'<br>';

		// Get Bible Book Name
		$bible_result28 = @mysql_query("SELECT * FROM nombres_de_libros WHERE libro='$libro'");
		$row28 = mysql_fetch_array($bible_result28);
		$bible_book = $row28["nombre"];
		biblia_fonts();
				
		//$bible_result8 = @mysql_query("SELECT * FROM $left_table_name WHERE libro='0' AND capitulo='10' AND versiculo='$libro'"); // Get Book Name
		//$row8 = mysql_fetch_array($bible_result8); 
		//$bible_book = $row8["texto"];
		
        // Display book and chapter name at the very top
		echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
		echo '<tr><td class="txt_form" align="center"><br><h1>'.$bible_book.' - Capítulo '.$capitulo.'</h1></td></tr></table>';

		##### Display navigation menu
		echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
		
		// Input button Remover Paralelo
		echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo.'" />';
		echo '<input type="hidden" name="version_left" value="'.$left_table_name.'">';
        echo '<input type="hidden" name="version_right" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
		echo '<input type="submit" value="- Paralelo" class="boton" /></form></td>';
		echo '<td width="5"></td>';

		// Input button Libro Anterior
		if ($libro > 1) {
		$libro_prev = $libro - 1;
		echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<input type="hidden" name="paralelo" value="'.$libro_prev.'" />';
		echo '<input type="hidden" name="paralelo_cap" value="1" />';
	    echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
		echo '<input type="hidden" name="version_third" value="'.$third_table_name.'">';
		echo '<input type="submit" value="<< Libro" class="boton" /></form></td>';
		echo '<td width="5"></td>';
		} // end if

		// Input button Libro Siguiente
		$libro_next = $libro + 1;
		echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<input type="hidden" name="paralelo" value="'.$libro_next.'" />';
		echo '<input type="hidden" name="paralelo_cap" value="1" />';
	    echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
		echo '<input type="hidden" name="version_third" value="'.$third_table_name.'">';			
		echo '<input type="submit" value="Libro >>" class="boton" /></form></td>';
		echo '<td width="5"></td>';
		
		// Input button Capitulo Anterior
		if ($capitulo > 1) {
		$capitulo_prev = $capitulo - 1;
		echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
		echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo_prev.'" />';
	    echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
		echo '<input type="hidden" name="version_third" value="'.$third_table_name.'">';
		echo '<input type="submit" value="<< Cap&iacute;tulo" class="boton" /></form></td>';
		echo '<td width="5"></td>';		
		} // end if
		
		// Input button Capitulo Siguiente
		$capitulo_next = $capitulo + 1;
		echo '<td><form class="bendicion-bible" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
		echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo_next.'" />';
	    echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
		echo '<input type="hidden" name="version_third" value="'.$third_table_name.'">';
		echo '<input type="submit" value="Cap&iacute;tulo >>" class="boton" /></form></td>';		
		echo '<td width="5"></td>';
		
	// Display Font Size Change /////////////////////////
	echo '<td><a href="javascript:decreaseFontSize();"><img src="http://biblia.bendicion.net/img/disminuir.png" width="30" height="30" border="0" valign="top" /></a></td><td width="5"></td><td><a href="javascript:increaseFontSize();"><img src="http://biblia.bendicion.net/img/aumentar.png" width="30" height="30" border="0" valign="top" /></a></td></tr></table>';

		// Display the 3 tables
		echo '<br><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr>';

		##### Start Left Column Version Here
		// Get Bible Version Name for Left Column Version
		$bible_result9 = @mysql_query("SELECT * FROM $left_table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name
		$row9 = mysql_fetch_array($bible_result9); 
		$nombre_left = $row9["texto"];
		echo '<td valign="top" class="txt_verse" width="320">';
		
		echo $nombre_left; // Display version name
		
        // Display drop down menu to change Left Column Version
		echo '<form name="version_left_column" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<select name="version_izquierda" size="1" class="txt_verse" style="width:190px;" onchange="version_left_column.submit();">';
		echo '<option value="" selected="selected" disabled="disabled">Cambiar Versi&oacute;n</option>';
        biblia_versiones();
        echo '</select>';
        echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo.'" />';
        echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="version_third" value="'.$third_table_name.'">';
		echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
	    echo '</form>';
		
		// Display Bible Text Verse - Left Column Version
		$bible_result7  = @mysql_query("SELECT * FROM $left_table_name WHERE libro='$libro' AND capitulo='$capitulo' ORDER BY versiculo ASC"); // Get Text Verse
		echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="hovertable">';
		while ($row7 = mysql_fetch_array($bible_result7))  {
			echo '<tr><td class="txt_verse"><p1><sup class="txt_sup">'.$row7["versiculo"].'</sup> '.$row7["texto"].'</p1></td></tr>';
		}
		echo '</table>';		

		echo '</td>'; // End Left Column Version
	    echo '<td width="5"></td><td width="1" bgcolor="#cecece"></td><td width="5"></td>';

		##### Start Middle Column Version Here
		// Get Bible Version Name for Middle Column Version
		$bible_result9b = @mysql_query("SELECT * FROM $right_table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name
		$row9b = mysql_fetch_array($bible_result9b); 
		$nombre_right = $row9b["texto"];	    
		echo '<td valign="top" class="txt_verse" width="319">';
		
		echo $nombre_right; // Display version name

        // Display drop down menu to change Middle Column Version
		echo '<form name="version_right_column" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<select name="version_derecha" size="1" class="txt_verse" style="width:190px;" onchange="version_right_column.submit();">';
		echo '<option value="" selected="selected" disabled="disabled">Cambiar Versi&oacute;n</option>';
        biblia_versiones();
        echo '</select>';
        echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo.'" />';
        echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
		echo '<input type="hidden" name="version_third" value="'.$third_table_name.'">';
		echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
	    echo '</form>';
		
		// Display Bible Text Verse - Middle Column Version
		$bible_result10  = @mysql_query("SELECT * FROM $right_table_name WHERE libro='$libro' AND capitulo='$capitulo' ORDER BY versiculo ASC"); // Get Text Verse
		echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="hovertable">';
		while ($row10 = mysql_fetch_array($bible_result10))  {
			echo '<tr><td class="txt_verse"><p1><sup class="txt_sup">'.$row10["versiculo"].'</sup> '.$row10["texto"].'</p1></td></tr>';
		}
		echo '</table>';		

	    echo '</td>';  // End Middle Column Version
		echo '<td width="5"></td><td width="1" bgcolor="#cecece"></td><td width="5"></td>';
		
		##### Start Right Column Version Here
		// Get Bible Version Name for Right Column Version
		$bible_result9c = @mysql_query("SELECT * FROM $third_table_name WHERE libro='0' AND capitulo='0' AND versiculo='0'"); // Get Bible Version Name
		$row9c = mysql_fetch_array($bible_result9c); 
		$nombre_third = $row9c["texto"];
	    echo '<td valign="top" class="txt_verse" width="319">';
		
		echo $nombre_third; // Display version name
		
        // Display drop down menu to change versions Right Column Version
		echo '<form name="version_third_column" action="http://bendicion.net/biblia_y_concordancia.php" method="post">';
		echo '<select name="version_third" size="1" class="txt_verse" style="width:190px;" onchange="version_third_column.submit();">';
		echo '<option value="" selected="selected" disabled="disabled">Cambiar Versi&oacute;n</option>';
        biblia_versiones();
        echo '</select>';
        echo '<input type="hidden" name="paralelo_cap" value="'.$capitulo.'" />';
        echo '<input type="hidden" name="version_izquierda" value="'.$left_table_name.'">';
		echo '<input type="hidden" name="version_derecha" value="'.$right_table_name.'">';
		echo '<input type="hidden" name="paralelo" value="'.$libro.'" />';
	    echo '</form>';		

		// Display Bible Text Verse - Right Column Version
		$bible_result11  = @mysql_query("SELECT * FROM $third_table_name WHERE libro='$libro' AND capitulo='$capitulo' ORDER BY versiculo ASC"); // Get Text Verse
		echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="hovertable">';
		while ($row11 = mysql_fetch_array($bible_result11))  {
			echo '<tr><td class="txt_verse"><p1><sup class="txt_sup">'.$row11["versiculo"].'</sup> '.$row11["texto"].'</p1></td></tr>';
		}
		echo '</table>';		
		
		echo '</td>'; // End Right Column Version
        echo '</tr></table><br><br>';		
	} // end else if
	