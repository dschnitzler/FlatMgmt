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
		case ("restart"):
			$head = "Neustart des Raspberry Pi";
			$html = WriteOK("Der Raspberry Pi wird neugestartet. Bitte haben Sie einen Moment Geduld.");
			passthru("sudo shutdown -r now");
			break;
		case ("shutdown"):
			$head = "Herunterfahren des Raspberry Pi";
			$html = WriteOK("Der Raspberry Pi wird nun heruntergefahren.");
			passthru("sudo shutdown -h now");
			break;
		default:
			$head = "Fehler";
			$html = WriteError("Angegebene Aktion nicht bekannt.");
			break;
	}
}

echo WriteHeader($head, "general");
echo $html;
echo WriteFooter();