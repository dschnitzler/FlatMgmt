<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
echo WriteHeader("Release Notes", "general");
echo "<h2>Stromz&auml;hler 1.0.0 (08.02.2013)</h2>
<p> Dies ist die erste Version von Stromzähler.<br>Sie beinhaltet eine Basisfunktionalit&auml;t.</p>
<p>Dieses Release bietet folgende neue Funktionalit&auml;t:</p>
<ul>
	<li> Eingabe von Strom- und Gaszählerständen </li>
	<li> Visualisierung der Strom- und Gasdaten</li>
</ul>
<h2>Wohnungsverwaltung 2.0.0 (27.02.2013)</h2>
<p> Dies ist die erste Version von Wohnungsverwaltung.<br>Sie ist aus der ersten Version von Stromz&auml;hler hervorgegangen.</p>
<p>Dieses Release bietet folgende neue Funktionalit&auml;t:</p>
<ul>
	<li> Eingabe von Finanzdaten (Kassenbons) </li>
	<li> Visualisierung der Finanzdaten</li>
</ul>
";
echo WriteFooter();
?>
