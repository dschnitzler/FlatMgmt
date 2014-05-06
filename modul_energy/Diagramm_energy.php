<?php
include_once("../jpgraph/jpgraph.php");
include_once("../jpgraph/jpgraph_line.php");
include_once("../jpgraph/jpgraph_date.php" );
include_once("../jpgraph/jpgraph_bar.php");
include_once("../modul_standard/functions.php");

$error = FALSE;
if (!isset($_GET['item']))
{
	$error 	= TRUE;
	//$html = WriteError("Es wurde keine Z&auml;hlerauswahl angegeben.");
}
else if ($_GET['item'] == "gas")
{
	$item 	= "Gas";
	$unit 	= "m³";
	$table 	= "gas";
}
else if ($_GET['item'] == "strom")
{
	$item 	= "Strom";
	$unit 	= "kWh";
	$table 	= "electricity";
}
else
{
	$head 	= "Fehler";
	$error 	= TRUE;
	//$html = WriteError("Z&auml;hlerauswahl kann nicht interpretiert werden.");
}

if (isset($_GET['start_date']))
{	$start_date = $_GET['start_date'];}
else
{	$start_date = "2013-01-01";}

if (isset($_GET['end_date']))
{	$end_date = $_GET['end_date'];}
else
{	$end_date = date("Y-m")."-01";}

if ($error == TRUE)
{
	return;
}

$db = ConnectDB();
$result1 = $db->query("SELECT * FROM ".$table." WHERE date >= '".$start_date."' AND date <'".$end_date."' ORDER BY date asc");
$rows1 = $result1->fetchAll();

$date_min	= $rows1[0]['date'];
$value_min	= $rows1[0]['value'];
$datetime_min 	= new DateTime($date_min);

$date_max	= $rows1[sizeof($rows1)-1]['date'];
$value_max	= $rows1[sizeof($rows1)-1]['value'];
$datetime_max 	= new DateTime($date_max);

$interval  	= date_diff($datetime_min, $datetime_max);
$average_gen	= ($value_max - $value_min)/($interval->format('%a'));

$xdata		= array();
$ydata_bar	= array();
$ydata_avg	= array();

$xdata[0] 	= strtotime($date_min);
$ydata_bar[0] 	= 0;
$ydata_avg[0]	= $average_gen;

$n = 1;
for ($i=1;  $i < sizeof($rows1); $i++) 
{
	$date_min		= $rows1[$i-1]['date'];
	$value_min		= $rows1[$i-1]['value'];
	$datetime_min 	= new DateTime($date_min);

	$date_max		= $rows1[$i]['date'];
	$value_max		= $rows1[$i]['value'];
	$datetime_max 	= new DateTime($date_max);
	$interval  		= date_diff($datetime_min, $datetime_max);
	$average		= ($value_max - $value_min)/($interval->format('%a'));
	for ($j=1;  $j <= $interval->format('%a'); $j++)
	{
		$xdata[$n] 	= strtotime($date_min." +".$j." days");
		$ydata_avg[$n] 	= $average_gen;
		$ydata_bar[$n] 	= $average;
		$n = $n + 1;
	}
}

$graph 		= new Graph(770,300,"auto");
$graph->SetScale("datlin");
$avgline  	= new Lineplot($ydata_avg, $xdata);
$barplot	= new Barplot($ydata_bar, $xdata);

$graph->Add($barplot);
$graph->Add($avgline);

$graph->SetMargin(60,20,30,90);
$graph->title->Set($item."verbrauch");

$graph->xaxis->title->Set("Zeit");
$graph->xaxis->SetLabelAngle(45);
$graph->yaxis->title->Set($unit);

$avgline->SetColor("#000000");
$barplot->SetColor("#EC6400");

$avgline->SetWeight(4);
$barplot->SetWeight(8);

$graph->SetShadow();

$graph->Stroke();
?>
