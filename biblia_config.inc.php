<?
// Connect to the database server
$dblog =  @mysql_connect("biblia.db.5886478.hostedresource.com", "biblia", "ReadBible75");
if (!$dblog) {
  echo( "<p>No se pudo conectar al servidor " .
        "de base de datos en este momento.</p>" );
  exit();
}

mysql_select_db("biblia", $dblog);
if (! @mysql_select_db("biblia") ) {
  echo( "<p>No se pudo encontrar la base de datos en este momento.</p>" );
  exit();
}

?>