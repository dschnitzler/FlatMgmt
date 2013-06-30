<?php

include('db.php');

function WriteHeader($title, $topic)
{
	$html ="<!DOCTYPE html>
			<html>
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
			<title>".$title."</title>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet_".$topic.".css\">
			</head>
			<body>
			<div id='container'>
			<div id='header'>
			<b>Wohnungs<br>Verwaltung</b>
			</div>
			<div id='trim'>
			&nbsp;
			<div id='menu'>
				<ul>
					<li>
						<a href='index.php'>&Uuml;bersicht</a>
						<ul>
							<a href='index_energy.php'>Energie</a>
							<a href='index_money.php'>Finanzen</a>
						</ul>
					</li> | 
					<li> Eingabe
						<ul>
							<li><a href='input_meter.php?item=strom'>Strom</a></li>
							<li><a href='input_meter.php?item=gas'>Gas</a></li>
							<li><a href='input_money.php'>Finanzen</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id='login'>
			</div>
			</div>
			<div id=\"content\">
			<h1>".$title."</h1>";
	return $html;
}

function WriteFooter()
{
	$html = "</div>
			<div id=\"footer\">
			<a href=\"release_notes.php\">Version 2.0.0</a> | 
			&copy; Daniel Schnitzler
			<br> Hosted on <a href=\"http://raspberrypi.org\">Raspberry Pi</a>
			</div>
			</div>
			</body>
			</html>
			";
	return $html;
}

function WriteError($message)
{
	$html="<div id='template_error'>
			<b>Es ist ein Fehler aufgetreten!</b><br>
		".$message
		."</div>";
	return $html;
}

function WriteOK($message)
{
	$html="<div id='template_ok'>
			<b> Vorgang erfolgreich ausgef&uuml;hrt! </b><br>
		".$message
		."</div>";
	return $html;
}

function FindIndex($array, $value)
{
	for($i = 0; $i < sizeof($array); $i++)
	{
		if ($value==$array[$i])
			return $i;
	}
	return -1;
}

function CalculateCostStrom()
{
	$db 		= ConnectDB();
	$result1 	= $db->query("SELECT * FROM electricity ORDER BY date asc");
	$rows1 		= $result1->fetchAll();

	$date_min		= $rows1[0]['date'];
	$value_min		= $rows1[0]['value'];
	$datetime_min 	= new DateTime($date_min);

	$date_max		= $rows1[sizeof($rows1)-1]['date'];
	$value_max		= $rows1[sizeof($rows1)-1]['value'];
	$datetime_max 	= new DateTime($date_max);

	$interval  		= date_diff($datetime_min, $datetime_max);
	$average_gen	= ($value_max - $value_min)/($interval->format('%a'));
	
	//StromSta(R) OekoPlus
	if($average_gen * 12 <= 2800)
	{
		$arbeitspreis 	= 27.64;
		$grundpreis 	= 73.02;
	} 
	elseif($average_gen * 12 <= 6000)
	{
		$arbeitspreis 	= 26.97;
		$grundpreis 	= 92.02;
	}
	elseif($average_gen * 12 <= 9000)
	{
		$arbeitspreis 	= 26.85;
		$grundpreis 	= 99.16;
	}
	elseif($average_gen * 12 <= 12000)
	{
		$arbeitspreis 	= 26.75;
		$grundpreis 	= 107.73;
	}
	else
	{
		$arbeitspreis 	= 26.67;
		$grundpreis 	= 117.73;
	}
	
	$cost = $grundpreis + $average_gen*$arbeitspreis/100;
	return($cost);
}
?>
