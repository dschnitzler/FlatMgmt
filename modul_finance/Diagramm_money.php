<?php
ini_set('display_errors', true);

error_reporting(E_ALL);
include_once("../jpgraph/jpgraph.php");
include_once("../jpgraph/jpgraph_line.php");
include_once("../jpgraph/jpgraph_date.php" );
include_once("../jpgraph/jpgraph_bar.php");
include_once('../modul_standard/functions.php');
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
/*

// Die Werte der 2 Linien in ein Array speichern
$ydata = array(11,3,8,12,5,1,9,13,5,7);
$ydata2 = array(1,19,15,7,22,14,5,9,21,13);

// Grafik generieren und Grafiktyp festlegen
$graph = new Graph(300,200,"auto");    
$graph->SetScale("textlin");

// Die Zwei Linien generieren
$lineplot=new LinePlot($ydata);

$lineplot2=new LinePlot($ydata2);

// Die Linien zu der Grafik hinzufügen
$graph->Add($lineplot);
$graph->Add($lineplot2);

// Grafik formatieren
$graph->img->SetMargin(40,20,20,40);
$graph->title->Set("Example 4");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$lineplot->SetColor("blue");
$lineplot->SetWeight(2);

$lineplot2->SetColor("orange");
$lineplot2->SetWeight(2);

$graph->yaxis->SetColor("red");
$graph->yaxis->SetWeight(2);
$graph->SetShadow();

// Grafik anzeigen
$graph->Stroke();*/
?>