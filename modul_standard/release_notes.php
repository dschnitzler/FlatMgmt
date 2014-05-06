<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');
echo WriteHeader("Release Notes", "general");

echo "<h2>Wohnungsverwaltung 2.2.0 (15.01.2014)</h2>
<p>Dieses Release bietet folgende neue Funktionalit&auml;t:</p>
<ul>
	<li> Eingabe Finanzen: Die Liste der Gesch&auml;fte und Kategorien kann in der Oberfl&auml;che erweitert werden.</li>
	<li> Berechnung der Telefonkosten: Die Telefonkosten wurden aufgeteilt in Basiskosten und monatl. Telefonkosten.</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.6 (03.01.2014)</h2>
<p>Dieses Release bietet folgendes Bugfixing:</p>
<ul>
	<li> Ansicht Finanzen: Fehler, der beim Jahreswechsel auftrat, wurde beseitigt</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.5 (18.12.2013)</h2>
<p>Dieses Release bietet folgendes Bugfixing:</p>
<ul>
	<li> Eingabe Energie: Z&auml;hlerwerte m&uuml;ssen in einem nachvollziehbaren Bereich sein (Mittelwert +- Standardabweichung).</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.4 (15.12.2013)</h2>
<p>Dieses Release bietet folgendes Bugfixing:</p>
<ul>
	<li> Eingabe Finanzen + Energie: &Uuml;berpr&uuml;fung des Datums verbessert. Es können keine Kommata als Trennzeichen verwendet werden.</li>
	<li> Ansicht Energie: Fehlerbenachrichtigung, falls das Startdatum der Analyse größer ist als das Enddatum.</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.3 (01.12.2013)</h2>
<p>Dieses Release bietet folgendes Bugfixing:</p>
<ul>
	<li> Ansicht Finanzen: Fehler bei der Berechnung von Zeitintervallen behoben.</li>
	<li> Ansicht Energie: Fehler bei der Berechnung des Standard-Enddatums behoben.</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.2 (11.11.2013)</h2>
<p>Dieses Release bietet folgendes Bugfixing:</p>
<ul>
	<li> Bei ung&uuml;ltigen Werten (z.B. Betrag) in der Eingabemaske Energie werden Fehler angezeigt.</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.1 (06.11.2013)</h2>
<p>Dieses Release bietet folgendes Bugfixing:</p>
<ul>
	<li> Bei ung&uuml;ltigen Werten (z.B. Betrag) in der Eingabemaske Finanzen werden Fehler angezeigt.</li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.1.0 (27.10.2013)</h2>
<p>Dieses Release bietet folgende neue Funktionalit&auml;t:</p>
<ul>
	<li> Der Energieverbrauch kann nun für eine bestimmte Zeitperiode analysiert werden </li>
</ul>";

echo "<h2>Wohnungsverwaltung 2.0.0 (27.02.2013)</h2>
<p> Dies ist die erste Version von Wohnungsverwaltung.<br>Sie ist aus der ersten Version von Stromz&auml;hler hervorgegangen.</p>
<p>Dieses Release bietet folgende neue Funktionalit&auml;t:</p>
<ul>
	<li> Eingabe von Finanzdaten (Kassenbons) </li>
	<li> Visualisierung der Finanzdaten</li>
</ul>";

echo "<h2>Stromz&auml;hler 1.0.0 (08.02.2013)</h2>
<p> Dies ist die erste Version von Stromzähler.<br>Sie beinhaltet eine Basisfunktionalit&auml;t.</p>
<p>Dieses Release bietet folgende neue Funktionalit&auml;t:</p>
<ul>
	<li> Eingabe von Strom- und Gaszählerständen </li>
	<li> Visualisierung der Strom- und Gasdaten</li>
</ul>
";
echo WriteFooter();
?>
