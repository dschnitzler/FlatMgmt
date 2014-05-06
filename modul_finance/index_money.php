<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include_once('../modul_standard/functions.php');
$db 	= ConnectDB();
$date 	= date("Y-m-01");

$d_start    = new DateTime('2012-12-01');
$d_end      = new DateTime($date);
$difference = $d_start->diff($d_end); 
$diff_month = $difference->format('%m') + 12*$difference->format('%y'); 

// Kosten für die Miete
$miete 			= 640;

// Berechnung der durchschnittlichen Internetkosten.
$internet1  	= $db->query("SELECT SUM(entry_value) as sum FROM money_entries WHERE entry_category == 4 AND entry_date < '".$date."'");
$internet1  	= $internet1->fetchAll();
$internet 		= $internet1[0]["sum"]/($diff_month-2) + LookupTelephoneCost(DateTime::createFromFormat('Y-m-d', $date));

// Kosten für Strom und Gas
$strom_gas 		= 50;

// Berechnung der durchschnittlichen Kosten für Lebensmittel.
$lebensmittel1  = $db->query("SELECT SUM(entry_value) AS sum FROM money_entries WHERE entry_category == 1 AND entry_date < '".$date."'");
$lebensmittel1  = $lebensmittel1->fetchAll();
$lebensmittel 	= $lebensmittel1[0]["sum"]/($diff_month-2);

// Kosten für die Rundfunkgebühren
$gez 			= 17.98;

// Kosten für die Einrichtung / Wohnungsdekoration
$einrichtung1  = $db->query("SELECT SUM(entry_value) AS sum FROM money_entries WHERE entry_category == 3 AND entry_date < '".$date."' AND entry_value < 100");
$einrichtung1  = $einrichtung1->fetchAll();
$einrichtung 	= $einrichtung1[0]["sum"]/($diff_month-1);


$gesamt = ($miete + $internet + $strom_gas + $lebensmittel + $gez + $einrichtung);

echo WriteHeader("&Uuml;bersicht", "money");
echo "
	<h2>Finanzen</h2>
	<img src=\"Diagramm_money.php\"   width=\"770\" height=\"300\">
	<br>
	<div class=\"post-it\">
	<h1>Monatliche Kosten</h1>
		<ul>
			* Miete        ".round($miete,2).		"&euro;<br>
			* Lebensmittel ".round($lebensmittel,2)."&euro;<br>
    		* Internet     ".round($internet,2).	"&euro;<br>
    		* Strom/Gas    ".round($strom_gas,2).	"&euro;<br>
			* GEZ 		   ".round($gez,2).			"&euro;<br>
			* Einrichtung  ".round($einrichtung,2).	"&euro;<br>
			------------------------ <br>
			Gesamt:        ".round($gesamt,2)."&euro;<br>
			Abschlag: 	   ".round($gesamt/2,2)."&euro;
    	</ul>
	</div>
	 ";
echo WriteFooter();
?>