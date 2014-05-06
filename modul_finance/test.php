<?php
include ("./jpgraph/jpgraph.php");
include ("./jpgraph/jpgraph_line.php");

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

// Grafik Formatieren
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
$graph->Stroke();
?>