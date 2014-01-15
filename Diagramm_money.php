<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
	include ("./jpgraph/jpgraph.php");
	include ("./jpgraph/jpgraph_line.php");
	include ("./jpgraph/jpgraph_date.php" );
	include ("./jpgraph/jpgraph_bar.php");
	include('functions.php');
	
$db = ConnectDB();
$entry_categories1 = $db->query("SELECT category_id, category_name, category_colour FROM money_categories");
$entry_categories  = $entry_categories1->fetchAll();

$entry_dates1 = $db->query("SELECT strftime(\"01.%m.%Y\", MIN(entry_date)) AS date_min, strftime(\"01.%m.%Y\", MAX(entry_date)) AS date_max from money_entries");
$entry_dates = $entry_dates1->fetchAll();

$min_date		= $entry_dates[0]['date_min'];
$date_min		= new DateTime($entry_dates[0]['date_min']);
$date_max		= new DateTime($entry_dates[0]['date_max']);

$interval  		= date_diff($date_min, $date_max);
$dates 			= array();
$dates2 		= array();

for($i=0; $i<=$interval->format('%m')+12*$interval->format('%y');$i++)
{
	$dates[$i]  = date("01.m.Y", strtotime($min_date." + ".$i." months"));
	$dates2[$i] = date("M Y", strtotime($min_date." + ".$i." months"));
}

$ydata = array();
$entries = array();
for($i=0; $i<sizeof($entry_categories);$i++)
{
	$ydata[$i] = array();
	$entries[$i] = $entry_categories[$i]['category_id'];
	for ($j=0;$j<sizeof($dates);$j++)
	{
		if ($entries[$i] == 4)
		{
			$ydata[$i][$j] = LookupTelephoneCost(DateTime::createFromFormat('d.m.Y', $dates[$j]));
		}
		else
		{
			$ydata[$i][$j] = 0;
		}
	}
}

$sum_query = $db->query("SELECT SUM(entry_value) AS sum_values, strftime(\"01.%m.%Y\", entry_date) as 'date', entry_category from money_entries group by strftime(\"01.%m.%Y\", entry_date), entry_category");
$sum_result = $sum_query->fetchAll();

for($i=0; $i<sizeof($sum_result);$i++)
{
	$sum_value	= $sum_result[$i]['sum_values'];
	$index_category	= findIndex($entries, $sum_result[$i]['entry_category']);
	$index_date	= findIndex($dates, $sum_result[$i]['date']);
	$ydata[$index_category][$index_date] += $sum_value;
}

$barplots = array();
for($i=0; $i<sizeof($entries);$i++)
{
	$barplots[$i] = new BarPlot($ydata[$i]);
	$barplots[$i]->SetLegend($entry_categories[$i]['category_name']);
	$barplots[$i]->SetColor('blue');
}

$graph	= new Graph(770,300,"auto");
$graph->SetScale("textlin");

$gbplot = new AccBarPlot($barplots);
$graph->Add($gbplot);

$graph->SetMargin(60,20,30,90);
$graph->title->Set("Finanzübersicht");
$graph->xaxis->SetTickLabels($dates2);
$graph->xaxis->title->Set("Zeit");
//$graph->xaxis->SetLabelAngle(45);
$graph->yaxis->title->Set("€");
$graph->SetShadow();
//$graph->legend->Pos(0.05,0.1);
$graph->Stroke();
?>
