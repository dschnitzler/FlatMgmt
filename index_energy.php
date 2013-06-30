<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
$db = ConnectDB();

echo WriteHeader("Energie", "energy");
echo "	<h2>Strom</h2>
	<img src=\"Diagramm_energy.php?item=strom\" width=\"770\" height=\"300\">
	<h2>Gas</h2>
	<img src=\"Diagramm_energy.php?item=gas\"   width=\"770\" height=\"300\">
	<div class=\"post-it\">
	<h1>Monatliche Kosten</h1>
		<ul>
			* Miete        640&euro;<br>
    		* Internet     20&euro;<br>
    		* Strom/Gas    70&euro;<br>
    		* Lebensmittel 200&euro;<br>
    	</ul>
	</div>
	";

echo WriteFooter();
?>
