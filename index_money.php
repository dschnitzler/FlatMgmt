<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
$db = ConnectDB();

echo WriteHeader("&Uuml;bersicht", "money");
echo "
	<h2>Finanzen</h2>
	<img src=\"Diagramm_money.php\"   width=\"770\" height=\"300\">
	<div class=\"post-it\">
	<h1>Monatliche Kosten</h1>
		<ul>
			* Miete        640&euro;<br>
    		* Internet     20&euro;<br>
    		* Strom/Gas    70&euro;<br>
    		* Lebensmittel 200&euro;<br>
			* GEZ 17,98&euro;<br>
			------------------------ <br>
			947,98&euro;
    	</ul>
	</div>
	 ";
echo WriteFooter();
?>
