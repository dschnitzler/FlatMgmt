<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');

$avg_strom 	= CalculateCostStrom();
$avg_gas	= CalculateCostGas();

echo WriteHeader("Energie", "energy");
echo "	<h2>Strom</h2>
	<img src=\"Diagramm_energy.php?item=strom\" width=\"770\" height=\"300\">
	Durchschnittliche Stromkosten pro Monat: ".$avg_strom."&euro;<br>
	Aktueller Abschlag 35.00&euro;<br>
	<h2>Gas</h2>
	<img src=\"Diagramm_energy.php?item=gas\"   width=\"770\" height=\"300\">
	Durchschnittliche Gaskosten pro Monat: ".$avg_gas."&euro;<br>
	Aktueller Abschlag 15.00&euro;<br>";
echo WriteFooter();
?>
