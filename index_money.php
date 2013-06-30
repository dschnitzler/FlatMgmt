<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
$db = ConnectDB();

echo WriteHeader("&Uuml;bersicht", "money");
echo "
	<h2>Finanzen</h2>
	<img src=\"Diagramm_money.php\"   width=\"770\" height=\"300\">
	 ";
echo WriteFooter();
?>
