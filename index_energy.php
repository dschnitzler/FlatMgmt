<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
$db = ConnectDB();

echo WriteHeader("Energie", "energy");
echo "	<h2>Strom</h2>
	<img src=\"Diagramm_energy.php?item=strom\" width=\"770\" height=\"300\">
	<h2>Gas</h2>
	<img src=\"Diagramm_energy.php?item=gas\"   width=\"770\" height=\"300\">";

echo WriteFooter();
?>
