<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('../modul_standard/functions.php');

$html = "";
$head = "";
	
if (!isset($_GET['action']))
{
	$head = "Fehler";
	$html = WriteError("Es wurde keine Aktion angegeben.");
}
else
{
	$action = $_GET['action'];
	switch ($action)
	{
		default:
			$head = "Fehler";
			$html = WriteError("Angegebene Aktion nicht bekannt.");
			break;
	}
}

echo WriteHeader($head, "general");
echo $html;
echo WriteFooter();


?>