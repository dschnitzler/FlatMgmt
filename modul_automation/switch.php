<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('../modul_standard/functions.php');

$html = "";
$head = "";

$error = FALSE;
if (isset($_GET['systemcode']))
{
	$systemcode = $_GET['systemcode'];
}
else
{
	$html .= WriteError("Der Systemcode wurde nicht angegeben.");
	$error = TRUE;
}

if (isset($_GET['unitcode']))
{
	$unitcode = $_GET['unitcode'];
}
else
{
	$html .= WriteError("Der Unitcode wurde nicht angegeben.");
	$error = TRUE;
}
	
$db 	= ConnectDB();
$stmt  	= $db->prepare("UPDATE automation_config SET status= NOT (SELECT status FROM automation_config WHERE systemcode=:systemcode AND unitcode=:unitcode) WHERE systemcode=:systemcode AND unitcode=:unitcode");
$stmt->bindParam(":systemcode", $systemcode);
$stmt->bindParam(":unitcode", $unitcode);
if(!$stmt->execute())
{	
	$html .= WriteError("Unbekannter SQL Fehler");
	$error = TRUE;
}
if (!$error)
{
	$stmt = $db->prepare("SELECT status FROM automation_config WHERE systemcode=:systemcode AND unitcode=:unitcode");
	$stmt->bindParam(":systemcode", $systemcode);
	$stmt->bindParam(":unitcode", $unitcode);
	$stmt->execute();
	$result = $stmt->fetch();
	echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=../modul_automation/index.php\"></head><body>";
	passthru("sudo /home/pi/wiringPi/rcswitch-pi/send ".$systemcode." ".$unitcode." ".$result["status"]);
	echo "</body></html>";
}
else
{
	echo WriteHeader("Fehler", "general");
	echo $html;
	echo WriteFooter();
}
?>