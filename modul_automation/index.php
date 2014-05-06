<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include_once('../modul_standard/functions.php');
$db 		= ConnectDB();

$channels  	= $db->query("SELECT systemcode, unitcode, status, label FROM automation_config");
$channels  	= $channels->fetchAll();

$html = "";
for($i=0; $i<sizeof($channels); $i++)
{
	$channel = $channels[$i];
	if ($channel["status"] == 0)
		$image = "<img src=\"./images/switch_off.png\">";
	else
		$image = "<img src=\"./images/switch_on.png\">";
	
	$html .= "<a href=\"switch.php?systemcode=".$channel["systemcode"]."&unitcode=".$channel["unitcode"]."\">".$image."</a>"."&nbsp; &nbsp; &nbsp;".$channel["label"]."<br>\n";
}


echo WriteHeader("Automation", "general");
echo $html;
echo WriteFooter();
?>