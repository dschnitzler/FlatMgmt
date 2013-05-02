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
					<li><a href='index.php'>&Uuml;bersicht</a></li> | 
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

?>
