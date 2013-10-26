<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
include('functions.php');

if (isset($_POST['start_month']))
{	$start_month = $_POST['start_month'];}
else
{	$start_month = "01";}

if (isset($_POST['start_year']))
{	$start_year = $_POST['start_year'];}
else
{	$start_year = "2013";}

if (isset($_POST['end_month']))
{	$end_month = $_POST['end_month'];}
else
{	$end_month = date('m',mktime(0,0,0,date("m")+1,date("d"),date("Y")));}

if (isset($_POST['end_year']))
{	$end_year = $_POST['end_year'];}
else
{	$end_year = date("Y");}

$start_date = $start_year."-".$start_month."-01";
$end_date 	= $end_year.  "-".$end_month.  "-01";

$avg_strom 	= GetAverageStrom($start_date, $end_date);
$avg_gas	= GetAverageGas($start_date, $end_date);

$avg_strom_stawag 	= GetCostStromStawag($avg_strom);
$avg_gas_stawag 	= GetCostGasStawag($avg_gas);

echo WriteHeader("Energie", "energy");

echo "<form item=\"id\" action=\"index_energy.php\" method=\"post\">
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
		  <tbody>
			<tr>
				<td>Analyse von</td>
				<td>
					<select name=\"start_month\">\n";
					for ($i = 1; $i <= 12; $i++)
					{
						$i_string = str_pad($i, 2, "0", STR_PAD_LEFT);
						if ($i_string == $start_month)
							{ $selected = "selected"; }
						else
							{ $selected = ""; }
						echo "<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
					}
echo "				</select>
				</td>
				<td>
					<select name=\"start_year\">\n";
					for ($i = 2013; $i <= 2015; $i++)
					{
						$i_string = str_pad($i, 4, "0", STR_PAD_LEFT);
						if ($i_string == $start_year)
							{ $selected = "selected"; }
						else
							{ $selected = ""; }
						echo "<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
					}
echo "				</select>
				</td>
				<td>bis</td>
				<td>
					<select name=\"end_month\">\n";
					for ($i = 1; $i <= 12; $i++)
					{
						$i_string = str_pad($i, 2, "0", STR_PAD_LEFT);
						if ($i_string == $end_month)
							{ $selected = "selected"; }
						else
							{ $selected = ""; }
						echo "<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
					}
echo "				</select>
				</td>
				<td>
					<select name=\"end_year\">\n";
					for ($i = 2013; $i <= 2015; $i++)
					{
						$i_string = str_pad($i, 4, "0", STR_PAD_LEFT);
						if ($i_string == $end_year)
							{ $selected = "selected"; }
						else
							{ $selected = ""; }
						echo "<option ".$selected." value=\"".$i_string."\">".$i_string."<br/>\n";
					}
echo "				</select>
				</td>
			</tr>
			<tr>
				<td>
					<br><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Aktualisieren\" />
				</td>
			</tr>
			</tbody>
			</table>
		</form>";

echo "	<h2>Strom</h2>
	<img src=\"Diagramm_energy.php?item=strom&amp;start_date=".$start_date."&amp;end_date=".$end_date."\" width=\"770\" height=\"300\">
	Durchschnittliche Stromkosten pro Monat: ".$avg_strom_stawag."&euro;<br>
	Aktueller Abschlag 35.00&euro;<br>
	<h2>Gas</h2>
	<img src=\"Diagramm_energy.php?item=gas&amp;start_date=".$start_date."&amp;end_date=".$end_date."\"   width=\"770\" height=\"300\">
	Durchschnittliche Gaskosten pro Monat: ".$avg_gas_stawag."&euro;<br>
	Aktueller Abschlag 15.00&euro;<br>";
echo WriteFooter();
?>
