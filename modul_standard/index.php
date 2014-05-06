<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');

echo WriteHeader("&Uuml;bersicht", "general");
echo "	<h2>Strom</h2>
	<img src=\"../modul_energy/Diagramm_energy.php?item=strom\" width=\"770\" height=\"300\">
	<h2>Gas</h2>
	<img src=\"../modul_energy/Diagramm_energy.php?item=gas\"   width=\"770\" height=\"300\">
	<h2>Finanzen</h2>
	<img src=\"../modul_finance/Diagramm_money.php\"   width=\"770\" height=\"300\">";
echo WriteFooter();
?>
