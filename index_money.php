<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
$db = ConnectDB();

$miete 			= 640;
$internet 		= 20;
$strom_gas 		= 70;
$lebensmittel 	= 200;
$gez 			= 17.98;
$gesamt = ($miete + $internet + $strom_gas + $lebensmittel + $gez);

echo WriteHeader("&Uuml;bersicht", "money");
echo "
	<h2>Finanzen</h2>
	<img src=\"Diagramm_money.php\"   width=\"770\" height=\"300\">
	<div class=\"post-it\">
	<h1>Monatliche Kosten</h1>
		<ul>
			* Miete        ".$miete.		"&euro;<br>
    		* Internet     ".$internet.		"&euro;<br>
    		* Strom/Gas    ".$stromg_gas.	"&euro;<br>
    		* Lebensmittel ".$lebensmittel.	"&euro;<br>
			* GEZ 		   ".$gez.			"&euro;<br>
			------------------------ <br>
			".$gesamt."&euro;
    	</ul>
	</div>
	 ";
echo WriteFooter();
?>
