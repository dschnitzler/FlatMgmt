<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
$db = ConnectDB();

$miete 			= 640;
$internet 		= 20;
$strom_gas 		= 70;

$lebensmittel1  = $db->query("SELECT AVG(sum_values) as average FROM (SELECT SUM(entry_value) AS sum_values FROM money_entries WHERE entry_category == 1 GROUP BY strftime(\"01.%m.%Y\", entry_date))";
$lebensmittel1  = $lebensmittel1->fetchAll();
$lebensmittel 	= $lebensmittel1[0]["average"];
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
			Gesamt:        ".$gesamt."&euro;<br>
			Abschlag: 	   ".($gesamt/2)."&euro;
    	</ul>
	</div>
	 ";
echo WriteFooter();
?>
